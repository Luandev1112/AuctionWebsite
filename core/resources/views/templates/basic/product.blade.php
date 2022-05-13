@extends($activeTemplate . 'layouts.frontend')
@section('content')
<section class="product-search pt-120 pb-120">
    <div class="container">
        <div class="row flex-wrap-reverse">
            <div class="col-lg-4 col-xl-3">
                <aside class="search-filter">
                    <div class="filter-widget pt-3 pb-2">
                        <h4 class="title m-0"><i class="las la-random"></i>@lang('Filters')</h4>
                        <span class="close-filter-bar d-lg-none">
                            <i class="las la-times"></i>
                        </span>
                    </div>

                    <div class="filter-widget">
                        <h6 class="sub-title">@lang('Filter Price')</h6>
                        <form method="GET" action="{{route('product.filter')}}">
                            <div id="slider-range"></div>
                            <div class="price-range">
                                <button type="submit" class="btn btn--base">@lang('Price')</button>
                                <input type="text" name="amount" id="amount" readonly>
                            </div>
                        </form>
                    </div>
                    <div class="filter-widget">
                        <h6 class="sub-title">@lang('Filter Brand')</h6>
                        <form method="GET" action="{{route('product.filter')}}">
                            @foreach($brands as $brand)
                                <div class="form-check form--check">
                                    <input type="checkbox" class="form-check-input brandType" name="brand[]" value="{{$brand->id}}" id="brand.{{$brand->id}}" @if(@in_array($brand->id, @$brandId)) checked @endif>
                                    <label class="form-check-label d-flex justify-content-between" for="brand.{{$brand->id}}"><span>{{__($brand->name)}}</span> <span>({{$brand->product->count()}})</span></label>
                                </div>
                            @endforeach
                        </form>
                    </div>

                    <div class="filter-widget">
                        <h6 class="sub-title">@lang('Filter Category')</h6>
                        <form method="GET" action="{{route('product.filter')}}">
                            @foreach($categories as $category)
                                <div class="form-check form--check">
                                    <input type="checkbox" class="form-check-input categoryType" name="category[]" value="{{$category->id}}" id="{{$category->id}}" @if(@in_array($category->id, @$categoryId)) checked @endif>
                                    <label class="form-check-label d-flex justify-content-between" for="{{$category->id}}"><span>{{__($category->name)}}</span> <span>({{$category->product->count()}})</span></label>
                                </div>
                            @endforeach
                        </form>
                    </div>

                </aside>
                <div class="mini-banner-area mt-4">
                    <div class="mini-banner">
                        @php
                            echo advertisements('540x984')
                        @endphp
                    </div>
                    <div class="mini-banner">
                        @php
                            echo advertisements('300x250')
                        @endphp
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9">
                <form method="GET" action="{{route('product.filter')}}">
                    <div class="filter-category-header">
                        <div class="filter-select-item d-lg-none">
                            <div class="filter-btn">
                                <i class="las la-filter"></i>
                            </div>
                        </div>
                        <div class="filter-select-item">
                            <span class="label">@lang('Sort by')</span>
                            <div class="select-item">
                                <select class="select-bar sortType" name="sort">
                                    <option value="1" @if(@$sortId == 1) selected @endif>@lang('Newest')</option>
                                    <option value="2" @if(@$sortId == 2) selected @endif>@lang('Ratings')</option>
                                    <option value="3" @if(@$sortId == 3) selected @endif>@lang('Price')</option>
                                    <option value="4" @if(@$sortId == 4) selected @endif>@lang('Sales')</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-group input--group filter-select-item flex-grow-1">
                            <input type="text" class="form-control form--control" name="search" value="{{@$search}}" placeholder="@lang('Search Here')">
                            <button class="input-group-text btn--base cmn--btn">
                                <i class="las la-search"></i>
                            </button>
                          </div>
                    </div>
                </form>
                <div class="row g-4">
                    @foreach($products as $product)
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
                {{$products->links()}}
                <div class="max-banner mt-4">
                    @php
                        echo advertisements('779x80')
                    @endphp
                </div>
            </div>
        </div>
    </div>
</section>
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

        $('.categoryType').on('click', function(){
            this.form.submit();
        });

        $('.brandType').on('click', function(){
            this.form.submit();
        });

        $('.sortType').on('change', function(){
            this.form.submit();
        });

        @if(session()->has('range'))
            var data1 = {{session('range')[0]}};
            var data2 = {{session('range')[1]}};
        @else
            var data1 = 0;
            var data2 = {{$general->search_max}};
        @endif

        $( "#slider-range" ).slider({
            range:true,
            min:0,
            max:{{$general->search_max}},
            values: [data1, data2],
            slide: function( event, ui ) {
              $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $( "#slider-range").slider( "values", 1));
    </script>
@endpush
