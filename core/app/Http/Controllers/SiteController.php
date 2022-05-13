<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Advertisement;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Review;
use App\Models\Subcategory;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        
        $pageTitle = 'Home';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','home')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle','sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact',compact('pageTitle'));
    }

    public function profile($username)
    {
        $user = User::where('username', $username)->where('status', 1)->firstOrFail();
        $pageTitle = $user->username. " Product list";
        $emptyMessage = "No data found";

        $reviews = Review::whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->with('user')->paginate(getPaginate());

        $reviewCount = $reviews->avg('starts');

        $totalSale = Order::where('status', '!=', 0)->whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->count();
        return view($this->activeTemplate . 'profile', compact('pageTitle', 'emptyMessage', 'user', 'totalSale', 'reviews', 'reviewCount'));
    }

    public function categoryProduct($id)
    {
        $category = Category::findOrFail($id);
        $pageTitle = ucfirst($category->name) ." Product list";
        $emptyMessage = "No data found";
        $brands = Brand::where('status', 1)->with('product')->latest()->get();
        $products = Product::where('sub_category_id', $id)
                    ->where('status', 1)
                    ->whereDate('time_duration','>', Carbon::now()->toDateTimeString())
                    ->inRandomOrder()->with('order')
                    ->paginate(getPaginate(12));
        return view($this->activeTemplate . 'product', compact('pageTitle', 'emptyMessage', 'products', 'brands'));
    }

    public function subCategoryProduct($id)
    {
        $subCategory = Subcategory::findOrFail($id);
        $pageTitle = ucfirst($subCategory->name) ." Product list";
        $emptyMessage = "No data found";
        $brands = Brand::where('status', 1)->with('product')->latest()->get();
        $products = Product::where('sub_category_id', $id)
                    ->where('status', 1)
                    ->whereDate('time_duration','>', Carbon::now()->toDateTimeString())
                    ->inRandomOrder()->with('order')
                    ->paginate(getPaginate(12));
        return view($this->activeTemplate . 'product', compact('pageTitle', 'emptyMessage', 'products', 'brands'));

    }

    public function product()
    {
        if(session()->has('range')){
            session()->forget('range');
        }
        $pageTitle = "All product";
        $emptyMessage = "No data found";
        $brands = Brand::where('status',1)->with('product')->latest()->get();
        $products = Product::where('status', 1)
                    ->whereDate('time_duration','>', Carbon::now()->toDateTimeString())
                    ->inRandomOrder()->with('order')
                    ->paginate(getPaginate(12));
        return view($this->activeTemplate . 'product', compact('pageTitle', 'emptyMessage', 'products', 'brands'));
    }

    public function productFilter(Request $request)
    {
        $request->validate([
            'sort' => 'nullable|in:1,2,3,4',
            'brand.*' => 'nullable|exists:brands,id',
            'category.*' => 'nullable|exists:categories,id'
        ]);
        $pageTitle = "Product Filter Search";
        $emptyMessage = "No data found";
        $brandId = $request->brand;
        $categoryId = $request->category;
        $sortId = $request->sort;
        $search = $request->search;
        $brands = Brand::where('status',1)->with('product')->latest()->get();
        $products = Product::where('status', 1)
                    ->whereDate('time_duration','>', Carbon::now()->toDateTimeString());
        if($request->category){
            $products = $products->whereIn('category_id', $request->category);
        }
        if($request->brand){
            $products = $products->whereIn('brand_id', $request->brand);
        }
        if($request->amount){
            $amount = filter_var($request->amount,FILTER_SANITIZE_NUMBER_INT);
            $amountArray = explode("-",$amount);
            if(session()->has('range')){
                session()->forget('range');
            }
            session()->put('range',$amountArray);
            $products = $products->whereBetween('amount', $amountArray);
        }
        if($request->sort){
            if($request->sort == 1){
                $products = $products->orderby('id', 'DESC');
            }
            if($request->sort == 2){
                $products = $products->orderby('rating', 'DESC');
            }
            if($request->sort == 3){
                $products = $products->orderby('amount', 'DESC');
            }
            if($request->sort == 4){
                $products = $products->withCount('order')->orderby('order_count', 'DESC');
            }
        }
        if($request->search){
            $products = $products->whereJsonContains('keyword', $search)->orWhere('title', 'like', "%$search%");
        }
        $products = $products->with('order')->paginate(getPaginate(12));
        return view($this->activeTemplate . 'product', compact('pageTitle', 'emptyMessage', 'products', 'brands', 'categoryId', 'sortId', 'search', 'brandId'));
    }


    public function productDetails($id)
    {
        $pageTitle = "Product details";
        $product = Product::where('id', $id)->where('status', 1)
                    ->whereDate('time_duration','>', Carbon::now()->toDateTimeString())
                    ->with('productSpecification.specification', 'review.user')->firstOrFail();
                    
        $user = $product->user;
        $relatedProducts = Product::where('status', 1)
                    ->whereDate('time_duration','>', Carbon::now()->toDateTimeString())
                    ->where('user_id', $user->id)->where('id', '!=', $id)
                    ->limit(9)->inRandomOrder()->get();

        $totalSale = Order::where('status', '!=', 0)->whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->count();
        $userReview = Review::whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->with('user')->avg('starts');
        return view($this->activeTemplate . 'product_detail', compact('pageTitle','product', 'relatedProducts', 'totalSale', 'userReview'));
    }

    public function contactSubmit(Request $request)
    {
        $attachments = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);
        $random = getNumber();
        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();
        
        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blog(){
        $pageTitle = "Blog";
        $blogs = Frontend::where('data_keys','blog.element')->paginate(getPaginate());
        return view($this->activeTemplate.'blog',compact('blogs','pageTitle'));
    }

    public function blogDetails($id,$slug){
        $pageTitle = "Blog Details";
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $recentBlogs = Frontend::where('data_keys','blog.element')->orderby('id', 'DESC')->limit(8)->paginate(getPaginate());
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle', 'recentBlogs'));
    }


    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json('Cookie accepted successfully');
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }


    public function adclicked($id)
    {
        $ads = Advertisement::where('id', decrypt($id))->firstOrFail();
        $ads->click +=1;
        $ads->save();
        return redirect($ads->redirect_url);
    }


    public function footerMenu($slug, $id)
    {
        $data = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle =  $data->data_values->title;
        return view($this->activeTemplate . 'menu', compact('data', 'pageTitle'));
    }

}
