@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="product-single pt-120 pb-120">
    <div class="container">
        <div class="row gy-5 justify-content-between">
            <div class="col-lg-4 col-xl-3">
                <aside class="product-single-sidebar me-xl-3">
                    <div class="seller-area mb-4">
                        <div class="seller-thumb">
                            <div class="official-checkmark">
                                <i class="las la-check"></i>
                            </div>
                            <div class="thumb">
                                <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $user->image,imagePath()['profile']['user']['size']) }}" alt="@lang('client')">
                            </div>
                            <div class="cont text-center mt-2">
                                <h6 class="title">{{__($user->fullname)}}</h6>
                                <span class="info">{{__($user->email)}}</span>
                            </div>
                        </div>
                        <ul class="seller-info mt-4 profile-page-seller">
                            <li>
                                @lang('Member Since'): <span class="text--base">{{showDateTime($user->created_at, 'd M Y')}}</span>
                            </li>
                            <li>
                                <div>
                                    @lang('Ratings :')
                                </div>
                                <div class="ratings">
                                    @php echo ratings($reviewCount) @endphp
                                    <span>({{getAmount($reviewCount)}})</span>
                                </div>
                            </li>
                            <li>
                                @lang('Total Products') : <span class="text--base">{{$user->product->count()}}</span>
                            </li>
                            <li>
                                @lang('Total Sale') : <span class="text--base">{{$totalSale}}</span>
                            </li>
                        </ul>
                            <div class="text-center">
                                <button type="button" class="btn btn--success mt-3 text-center" data-bs-toggle="modal" data-bs-target="#contact">@lang('Contact Seller')</button>
                            </div>
                    </div>
                    <div class="mini-banner">
                        @php
                            echo advertisements('540x984')
                        @endphp
                    </div>
                </aside>
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="row g-4">
                    @foreach($user->product as $product)
                    <div class="col-md-6 col-xl-4">
                    	<div class="product-item">
                            <div class="product-inner">
                                <div class="product-thumb">
                                    @if($product->featured == 1)
                                        <span class="ticker">@lang('Featured')</span>
                                    @endif
                                    <a href="{{route('product.detail', $product->id)}}" class="d-block">
                                        <img src="{{ getImage(imagePath()['product']['path'].'/'.$product->image,imagePath()['product']['size'])}}" alt="@lang('product')">
                                        <h6 class="title">{{__($product->title)}}</h6>
                                    </a>
                                </div>
                                <div class="product-content">
                                    <ul class="countdown staffCountdown" id="staffproductcount" data-count_down="{{ showDateTime($product->time_duration, 'Y/m/d h:i:s')}}">
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
                                            @if($product->featured == 1)
                                                {{showAmount($product->amount + $general->featured_price)}}
                                            @else
                                                {{showAmount($product->amount)}}
                                            @endif
                                        </li>

                                        <li>
                                            <div class="ratings">
                                                
                                                @php echo ratings($product->rating) @endphp
                                                ({{getAmount($product->rating)}})
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="meta-list">
                                        <li>
                                            <span class="text--base"><i class="lab la-bitcoin"></i> </span><span class="text--base">
                                                @if($product->featured == 1)
                                                    {{btcRate($product->amount + $general->featured_price)}}
                                                @else
                                                    {{btcRate($product->amount)}}
                                                @endif
                                            </span>
                                        </li>
                                        <li>
                                            <a href="{{route('product.detail', $product->id)}}" class="buy-now">@lang('Purchase Now')</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="notification__area mt-5">
                    <table class="cmn--table table">
                        <thead>
                            <th>
                                @lang('Username')
                            </th>
                            <th>
                               @lang('Review')
                            </th>
                            <th>
                                @lang('Date')
                            </th>
                            <th>
                                @lang('Ratings')
                            </th>
                        </thead>
                        <tbody>
                            @forelse($reviews as $review)
                                <tr>
                                    <td data-label="@lang('Username')">
                                        <div>
                                            <a href="{{route('profile', $review->user->username)}}" class="text--base">{{$review->user->fullname}}</a>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Review')">
                                        <div class="comments-details">
                                            {{__($review->review)}}
                                        </div>
                                    </td>
                                    <td data-label="@lang('Date')">
                                        <div>
                                            {{showDateTime($review->created_at, 'd M Y')}}
                                        </div>
                                    </td>
                                    <td data-label="@lang('Ratings')">
                                        <div class="ratings">
                                            @php echo ratings($review->starts) @endphp
                                            ({{getAmount($review->starts)}})
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{$emptyMessage}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-center">
                    @php
                        echo advertisements('779x80')
                    @endphp
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade custom--modal" id="contact">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Contact with ') {{__($user->username)}}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form method="POST" action="{{route('user.contact.store')}}">
                @csrf
                <input type="hidden" name="receiver_id" value="{{$user->id}}">

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
@endsection

@push('script')
    <script>
        "use strict";
        $('.staffCountdown').each(function() {
            var finalDate = $(this).data('count_down');
            $(this).countdown({
                date: finalDate,
                offset: +6,
                day: 'Day',
                days: 'Days'
            });
        });
    </script>
@endpush
