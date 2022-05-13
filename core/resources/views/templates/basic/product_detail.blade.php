@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="product-single pt-120 pb-120">
    <div class="container">
        <div class="row gy-5 justify-content-between">
            <div class="col-lg-8">
                <div class="product__single-item">
                    <div class="product-thumb-area mb-5">
                        <div class="product-thumb pe-md-4">
                            <div class="position-relative">
                                @if($product->featured == 1)
                                    <span class="ticker">@lang('Featured')</span>
                                @endif
                                <img src="{{getImage(imagePath()['product']['path'].'/'.$product->image,imagePath()['product']['size'])}}" alt="@lang('product')">
                                <div class="meta-post mt-3">
                                    <div class="meta-item">
                                        <span class="text--base"><i class="lar la-calendar-check"></i></span> {{showDateTime($product->created_at, 'd M Y')}}
                                    </div>
                                    <div class="meta-item me-0">
                                        <span class="text--base"><i class="lar la-share-square"></i></span>
                                        <ul class="social-share">
                                            <li>
                                                <a href="https://www.facebook.com/sharer.php?u={{urlencode(url()->current())}}" target="__blank"><i class="fab fa-facebook-f"></i></a>
                                            </li>
                                            <li>
                                                <a href="https://twitter.com/share?url={{urlencode(url()->current())}}&text=Simple Share Buttons&hashtags=simplesharebuttons" target="__blank"><i class="fab fa-twitter"></i></a>
                                            </li>
                                            <li>
                                                <a href="http://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url()->current())}}" target="__blank"><i class="fab fa-linkedin-in"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="product-content">
                            <h5 class="title mt-0 mb-2">{{__($product->title)}}</h5>

                            <div class="d-flex flex-wrap mb-4">
                                <div class="ratings me-4 me-xxl-5">
                                    @php echo ratings($product->rating) @endphp
                                    ({{getAmount($product->rating)}})
                                </div>
                                <div class="available">
                                    <span class="text--base"><i class="las la-shopping-cart"></i></span> @lang('Total Sell') <span class="text--base">({{__($product->order->count())}})</span>
                                </div>
                            </div>

                            <p class="mb-3">
                                {{__($product->sub_title)}}
                            </p>
                            <div class="product-price d-flex flex-wrap justify-content-between mb-3">
                                <div class="my-2">
                                    <span class="text--base"> {{__($general->cur_sym)}}</span> 
                                                @if($product->featured == 1)
                                                    {{showAmount($product->amount + $general->featured_price)}}
                                                @else
                                                    {{showAmount($product->amount)}}
                                                @endif
                                </div>
                                <div class="my-2">
                                    <span class="text--white"><i class="lab la-bitcoin"></i> </span><span class="text--base">
                                        @if($product->featured == 1)
                                            {{btcRate($product->amount + $general->featured_price)}}
                                        @else
                                            {{btcRate($product->amount)}}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="btn__area">
                                <div class="cart-plus-minus">
                                    <div class="cart-decrease qtybutton dec">
                                        <i class="las la-minus"></i>
                                    </div>
                                    <input type="number" id="qty" value="1" min="0">
                                    <div class="cart-increase qtybutton inc">
                                        <i class="las la-plus"></i>
                                    </div>
                                </div>
                                <div>
                                    <a href="javascript:void(0)" class="cmn--btn btn--sm pruchase" data-bs-toggle="modal" data-bs-target="#modal">@lang('Purchase')</a>
                                </div>
                            </div>
                            <div class="specification__lists">
                                <ul>
                                    <li>
                                        <span class="name">@lang('Brand')</span>
                                        <span>{{__($product->brand->name)}}</span>
                                    </li>
                                    <li>
                                        <span class="name">@lang('Ending Date')</span>
                                        <span>{{showDateTime($product->time_duration, 'd M Y')}}</span>
                                    </li>
                                    <li>
                                        <span class="name">@lang('Category')</span>
                                        <span>{{__($product->category->name)}}</span>
                                    </li>
                                    <li>
                                        <span class="name">@lang('Sub Category')</span>
                                        <span>{{__($product->subCategory->name)}}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-sm btn--success" data-bs-toggle="modal" data-bs-target="#contact">@lang('Contact Seller')</button>
                                <button type="button" class="btn btn-sm btn--danger" data-bs-toggle="modal" data-bs-target="#report">@lang('Report Listing')</button>
                            </div>
                        </div>
                    </div>
                    <div class="max-banner mb-4">
                        @php
                            echo advertisements('779x80')
                        @endphp
                    </div>
                    <div class="content">
                        <ul class="nav nav-tabs nav--tabs">
                            <li>
                                <a href="#description" class="active" data-bs-toggle="tab">@lang('Description')</a>
                            </li>
                            <li>
                                <a href="#specification" data-bs-toggle="tab">@lang('Specification')</a>
                            </li>
                            <li>
                                <a href="#reviews" data-bs-toggle="tab">@lang('Reviews')({{$product->review->count()}})</a>
                            </li>
                            <li>
                                <a href="#related-products" data-bs-toggle="tab">@lang('Other Products')</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade fade show active" id="description">
                                <div class="description-item">
                                    @php echo $product->description @endphp
                                </div>
                            </div>
                            <div class="tab-pane fade" id="specification">
                                <div class="specification-wrapper">
                                    <h5 class="title">@lang('Specification')</h5>
                                    <div class="table-wrapper">
                                        <table class="specification-table">
                                            @foreach($product->productSpecification as $productspe)
                                                <tr>
                                                    <th>{{__($productspe->specification->name)}}</th>
                                                    <td>{{$productspe->value}}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reviews">
                                <div class="review-area">

                                @foreach($product->review as $review)
                                    <div class="review-item">
                                        <div class="thumb">
                                            <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $review->user->image,imagePath()['profile']['user']['size']) }}" alt="review">
                                        </div>
                                        <div class="content">
                                            <div class="entry-meta">
                                                <h6 class="posted-on">
                                                    <a href="{{route('profile', $review->user->username)}}">{{$review->user->fullname}}</a>
                                                    <span>@lang('Posted on') {{showDateTime($review->created_at, 'd M Y h:i:s')}}</span>
                                                </h6>
                                                <div class="ratings">
                                                    @php echo ratings($review->stars) @endphp
                                                </div>
                                            </div>
                                            <div class="entry-content">
                                                <p>{{$review->review}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>

                                <div class="add-review pt-4 pt-sm-5">
                                    <h5 class="title bold mb-3 mb-lg-4">@lang('Add Review')</h5>
                                    <form class="review-form rating row" method="POST" action="{{route('user.product.review.store')}}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <div class="review-form-group mb-20 col-md-12 d-flex flex-wrap">
                                            <label class="review-label mb-0 me-3">@lang('Your Ratings') :</label>
                                            <div class="rating-form-group">
                                                <label class="star-label">
                                                    <input type="radio" name="stars" value="1"/>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                </label>
                                                <label class="star-label">
                                                    <input type="radio" name="stars" value="2"/>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                </label>
                                                <label class="star-label">
                                                    <input type="radio" name="stars" value="3"/>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                </label>
                                                <label class="star-label">
                                                    <input type="radio" name="stars" value="4"/>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                </label>
                                                <label class="star-label">
                                                    <input type="radio" name="stars" value="5"/>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="review-form-group mb-20 col-12 d-flex flex-wrap">
                                            <label class="review-label" for="review-comments">@lang('Say Something about this products')</label>
                                            <textarea name="review" class="form-control form--control" id="review-comments" required=""></textarea>
                                        </div>
                                        <div class="review-form-group mb-20 col-12 d-flex flex-wrap">
                                            <button type="submit" class="cmn--btn">@lang('Submit Review')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="related-products">
                                <div class="related-products">
                                    <h5 class="title bold mb-3 mb-lg-4">@lang('Other Products')</h5>
                                    <div class="slider-wrapper">
                                        <div class="owl-theme owl-carousel related-slider">
                                            @foreach($relatedProducts as $relatedProduct)
                                            <div class="slide-item">
                                                <div class="product-item">
                                                    <div class="product-inner">
                                                        <div class="product-thumb">
                                                            @if($relatedProduct->featured == 1)
                                                                <span class="ticker">@lang('Featured')</span>
                                                            @endif
                                                            <a href="{{route('product.detail', $relatedProduct->id)}}" class="d-block">
                                                                <img src="{{ getImage(imagePath()['product']['path'].'/'.$relatedProduct->image,imagePath()['product']['size'])}}" alt="@lang('product image')">
                                                                <h6 class="title">{{__($relatedProduct->title)}}</h6>
                                                            </a>
                                                        </div>
                                                        <div class="product-content">
                                                            <ul class="countdown" data-count_down="{{showDateTime($relatedProduct->time_duration, 'Y/m/d h:i:s')}}">
                                                                <li>
                                                                    <h6 class="countdown__title"><span class="days">@lang('00')</span></h6>
                                                                    <p class="days_text">@lang('days')</p>
                                                                </li>
                                                                <li>
                                                                    <h6 class="countdown__title"><span class="hours">@lang('00')</span></h6>
                                                                    <p class="hours_text">@lang('hours')</p>
                                                                </li>
                                                                <li>
                                                                    <h6 class="countdown__title"><span class="minutes">@lang('00')</span></h6>
                                                                    <p class="minu_text">@lang('minutes')</p>
                                                                </li>
                                                                <li>
                                                                    <h6 class="countdown__title"><span class="seconds">@lang('00')</span></h6>
                                                                    <p class="seco_text">@lang('seconds')</p>
                                                                </li>
                                                            </ul>
                                                            <ul class="meta-list">
                                                                <li>
                                                                   <span class="text--base">{{$general->cur_sym}} </span>
                                                                   @if($relatedProduct->featured == 1)
                                                                        {{showAmount($relatedProduct->amount + $general->featured_price)}}
                                                                    @else
                                                                        {{showAmount($relatedProduct->amount)}}
                                                                    @endif
                                                                </li>
                                                                <li>
                                                                    <div class="ratings">
                                                                        @php echo ratings($relatedProduct->rating) @endphp
                                                                        <span>({{getAmount($relatedProduct->rating)}})</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            <ul class="meta-list">
                                                                <li>
                                                                    <span class="text--base"><i class="lab la-bitcoin"></i> </span><span class="text--base"> 
                                                                        @if($relatedProduct->featured == 1)
                                                                            {{btcRate($relatedProduct->amount + $general->featured_price)}}
                                                                        @else
                                                                            {{btcRate($relatedProduct->amount)}}
                                                                        @endif</span>
                                                                </li>
                                                                <li>
                                                                    <a href="{{route('product.detail', $relatedProduct->id)}}" class="buy-now">@lang('Purchase Now')</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="max-banner mt-5">
                            @php
                                echo advertisements('779x80')
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <aside class="product-single-sidebar ms-xl-3 ms-xxl-5">
                    <div class="countdown-area mb-4">
                        <ul class="countdown" data-count_down="{{showDateTime($product->time_duration, 'Y/m/d h:i:s')}}">
                            <li>
                                <h6 class="countdown__title"><span class="days">@lang('00')</span></h6>
                                <p class="days_text">@lang('days')</p>
                            </li>
                            <li>
                                <h6 class="countdown__title"><span class="hours">@lang('00')</span></h6>
                                <p class="hours_text">@lang('hours')</p>
                            </li>
                            <li>
                                <h6 class="countdown__title"><span class="minutes">@lang('00')</span></h6>
                                <p class="minu_text">@lang('minutes')</p>
                            </li>
                            <li>
                                <h6 class="countdown__title"><span class="seconds">@lang('00')</span></h6>
                                <p class="seco_text">@lang('seconds')</p>
                            </li>
                        </ul>
                    </div>
                    <div class="seller-area mb-4">
                        <h6 class="about-seller mb-4">
                            @lang('About Seller')
                        </h6>
                        <div class="seller">
                            <div class="official-checkmark">
                                <i class="las la-check"></i>
                            </div>
                            <div class="thumb">
                                <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $product->user->image,imagePath()['profile']['user']['size']) }}" alt="@lang('client')">
                            </div>
                            <div class="cont">
                                <h6 class="title"><a href="{{route('profile', $product->user->username)}}">{{__($product->user->fullname)}}</a></h6>
                            </div>
                        </div>
                        <ul class="seller-info mt-4">
                            <li>
                                <span>@lang('Since'):</span> <span class="text--base">{{showDateTime($product->user->created_at, 'd M Y')}}</span>
                            </li>
                            <li>
                                <div class="ratings">
                                    @php echo ratings($userReview) @endphp
                                    <span>({{getAmount($userReview)}})</span>
                                </div>
                            </li>
                            <li>
                                @lang('Total Products') : <span class="text--base">{{$product->user->product->count()}}</span>
                            </li>
                            <li>
                                @lang('Total Sale') : <span class="text--base">{{$totalSale}}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mini-banner">
                        @php
                            echo advertisements('540x984')
                        @endphp
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>


<div class="modal fade custom--modal" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Payment for order')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form method="POST" action="{{route('user.order.store')}}">
                @csrf
                <input type="hidden" name="qty" id="productQty">
                <input type="hidden" name="product_id" value="{{$product->id}}">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="payment" class="form--label mb-2">@lang('Select Option')</label>
                        <select class="form-control form--control-2 bg--body" name="payment_type" id="payment">
                            <option value="">@lang('Select One')</option>
                            <option value="1">@lang('Checkout')</option>
                            <option value="2">{{__($general->sitename)}} @lang('wallet')</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade custom--modal" id="contact">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Contact with ') {{__($product->user->username)}}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form method="POST" action="{{route('user.contact.store')}}">
                @csrf
                <input type="hidden" name="receiver_id" value="{{$product->user_id}}">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="subject" class="form--label mb-2">@lang('Subject')</label>
                        <input type="text" id="subject" class="form-control form--control" name="subject" required="">
                    </div>

                    <div class="form-group">
                        <label for="payment" class="form--label mb-2">@lang('Message')</label>
                        <textarea class="form-control form--control" name="message" required=""></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade custom--modal" id="report">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Report this product')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form method="POST" action="{{route('user.product.report')}}">
                @csrf
                <input type="hidden" name="product_id" value="{{$product->id}}">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="payment" class="form--label mb-2">@lang('Report')</label>
                        <textarea class="form-control form--control" name="report" placeholder="Enter Report" required=""></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('script')
<script>
    "use strict";
    $('.pruchase').on('click', function(){
        var qty = $('#qty').val()
        $('#productQty').val(qty);
    });
</script>
@endpush
