@php
    $totadyDeals = App\Models\Product::where('status', 1)
                ->whereDate('created_at', Carbon\Carbon::today())
                ->whereDate('time_duration','>', Carbon\Carbon::now()->toDateTimeString())
                ->orderBy('id', 'DESC')
                ->limit(getPaginate())->with('order')->get();
@endphp
@if($totadyDeals->isNotEmpty())
    <section class="products-section pt-60 pb-60">
        <div class="container">
            <div class="section__header">
                <h5 class="title">@lang('Todays Deal')</h5>
                <div class="owl-nav">
                    <div class="owl-prev"></div>
                    <div class="owl-next"></div>
                </div>
            </div>
            <div class="slider-wrapper">
                <div class="owl-theme owl-carousel products-slider">
                    @foreach($totadyDeals as $totadyDeal)
                        <div class="slide-item">
                            <div class="product-item">
                                <div class="product-inner">
                                    <div class="product-thumb">
                                        @if($totadyDeal->featured == 1)
                                            <span class="ticker">@lang('Featured')</span>
                                        @endif
                                        <a href="{{route('product.detail', $totadyDeal->id)}}" class="d-block">
                                            <img src="{{ getImage(imagePath()['product']['path'].'/'.$totadyDeal->image,imagePath()['product']['size'])}}" alt="@lang('product')">
                                            <h6 class="title">{{__($totadyDeal->title)}}</h6>
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <ul class="countdown">
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
                                                @if($totadyDeal->featured == 1)
                                                    {{showAmount($totadyDeal->amount + $general->featured_price)}}
                                                @else
                                                    {{showAmount($totadyDeal->amount)}}
                                                @endif
                                            </li>
                                            <li>
                                                <div class="ratings">
                                                    @php echo ratings($totadyDeal->rating) @endphp
                                                    ({{getAmount($totadyDeal->rating)}})
                                                </div>
                                            </li>
                                        </ul>
                                        <ul class="meta-list">
                                            <li>
                                                <span class="text--base"><i class="lab la-bitcoin"></i> </span><span class="text--base">
                                                    @if($totadyDeal->featured == 1)
                                                        {{btcRate($totadyDeal->amount + $general->featured_price)}}
                                                    @else
                                                        {{btcRate($totadyDeal->amount)}}
                                                    @endif
                                                </span>
                                            </li>

                                            <li>
                                                <a href="{{route('product.detail', $totadyDeal->id)}}" class="buy-now">@lang('Purchase Now')</a>
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
    </section>
@endif
