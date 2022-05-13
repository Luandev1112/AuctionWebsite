@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="product-single pt-120 pb-120">
    <div class="container">
        <div class="row gy-5 justify-content-between">
            <div class="col-lg-8">
                <div class="product__single-item">
                    <div class="product-thumb-area mb-5">
                        <div class="product-thumb pe-md-4">
                            <img src="{{getImage(imagePath()['product']['path'].'/'.$product->image,imagePath()['product']['size'])}}" alt="product">
                            <div class="meta-post mt-3">
                                <div class="meta-item">
                                    <span class="text--base"><i class="lar la-calendar-check"></i></span> {{showDateTime($product->created_at, 'd M Y')}}
                                </div>
                                <div class="meta-item me-sm-auto">
                                    <span class="text--base"><i class="las la-shopping-cart"></i></span> {{$product->order->count()}}
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
                        <div class="product-content">
                            <h5 class="title mt-0 mb-2">{{__($product->title)}}</h5>
                            <div class="product-price">
                                <div>
                                    {{getAmount($product->amount)}}<span class="text--base"> {{__($general->cur_text)}}</span>
                                </div>
                            </div>
                            <p class="mb-4">
                                {{$product->sub_title}}
                            </p>

                            <div class="ratings mb-4">
                                @if(intval($product->rating) == 1)
                                    <i class="las la-star"></i>
                                @elseif(intval($product->rating) == 2)  
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                @elseif(intval($product->rating) == 3)  
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                @elseif(intval($product->rating) == 4)  
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                @elseif(intval($product->rating) == 5)  
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                @endif
                                ({{getAmount($product->rating)}})
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
                                                    <a href="#">{{$review->user->fullname}}</a>
                                                    <span>@lang('Posted on') {{showDateTime($review->created_at, 'd M Y h:i:s')}}</span>
                                                </h6>
                                                <div class="ratings">
                                                    @if(intval($review->starts) == 1)
                                                        <i class="las la-star"></i>
                                                    @elseif(intval($review->starts) == 2)  
                                                        <i class="las la-star"></i>
                                                        <i class="las la-star"></i>
                                                    @elseif(intval($review->starts) == 3)  
                                                        <i class="las la-star"></i>
                                                        <i class="las la-star"></i>
                                                        <i class="las la-star"></i>
                                                    @elseif(intval($review->starts) == 4)  
                                                        <i class="las la-star"></i>
                                                        <i class="las la-star"></i>
                                                        <i class="las la-star"></i>
                                                        <i class="las la-star"></i>
                                                    @elseif(intval($review->starts) == 5)  
                                                        <i class="las la-star"></i>
                                                        <i class="las la-star"></i>
                                                        <i class="las la-star"></i>
                                                        <i class="las la-star"></i>
                                                        <i class="las la-star"></i>
                                                    @endif
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
                                <h6 class="title">{{__($product->user->fullname)}}</h6>
                            </div>
                        </div>
                        <ul class="seller-info mt-4">
                            <li>
                                @lang('Since'): <span class="text--base">{{showDateTime($product->user->created_at, 'd M Y')}}</span>
                            </li>
                            <li>
                                <div class="ratings">
                                    @if(intval($userReview) == 1)
                                        <i class="las la-star"></i>
                                    @elseif(intval($userReview) == 2)  
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                    @elseif(intval($userReview) == 3)  
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                    @elseif(intval($userReview) == 4)  
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                    @elseif(intval($userReview) == 5)  
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                    @endif
                                    <span>({{getAmount($userReview)}})</span>
                                </div>
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
@endsection