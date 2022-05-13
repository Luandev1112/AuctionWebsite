@php
    $endingsoons = App\Models\Product::where('status', 1)
            ->whereDate('time_duration','>', Carbon\Carbon::now()->toDateTimeString())
            ->orderBy('time_duration', 'ASC')
            ->limit(getPaginate())->with('order')->get();
@endphp

<section class="products-section pt-60 pb-60">
    <div class="container">
        <div class="section__header">
            <h5 class="title">@lang('Ending Soon')</h5>
            <div class="owl-nav">
                <div class="owl-prev"></div>
                <div class="owl-next"></div>
            </div>
        </div>
        <div class="slider-wrapper">
            <div class="owl-theme owl-carousel products-slider">
                @foreach($endingsoons as $endingsoon)
                    <div class="slide-item">
                        <div class="product-item">
                            <div class="product-inner">
                                <div class="product-thumb">
                                    @if($endingsoon->featured == 1)
                                        <span class="ticker">@lang('Featured')</span>
                                    @endif
                                    <a href="{{route('product.detail', $endingsoon->id)}}" class="d-block">
                                        <img src="{{ getImage(imagePath()['product']['path'].'/'.$endingsoon->image,imagePath()['product']['size'])}}" alt="@lang('product')">
                                        <h6 class="title">{{__($endingsoon->title)}}</h6>
                                    </a>
                                </div>

                                <div class="product-content">
                                    <ul class="countdown" data-count_down="{{showDateTime($endingsoon->time_duration, 'Y/m/d h:i:s')}}">
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
                                            @if($endingsoon->featured == 1)
                                                {{showAmount($endingsoon->amount + $general->featured_price)}}
                                            @else
                                                {{showAmount($endingsoon->amount)}}
                                            @endif
                                        </li>
                                        <li>
                                            <div class="ratings">
                                                @php echo ratings($endingsoon->rating) @endphp
                                                ({{getAmount($endingsoon->rating)}})
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="meta-list">
                                        <li>
                                            <span class="text--base"><i class="lab la-bitcoin"></i> </span><span class="text--base">
                                                @if($endingsoon->featured == 1)
                                                    {{btcRate($endingsoon->amount + $general->featured_price)}}
                                                @else
                                                    {{btcRate($endingsoon->amount)}}
                                                @endif
                                            </span>
                                        </li>
                                        <li>
                                            <a href="{{route('product.detail', $endingsoon->id)}}" class="buy-now">@lang('Purchase Now')</a>
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
