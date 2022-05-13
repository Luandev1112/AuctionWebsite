@extends($activeTemplate.'layouts.frontend')
@section('content')
@php 
    $banners = getContent('banner.element', false);
@endphp

 <section class="banner-section bg--section overflow-hidden">
    <div class="banner-slider owl-theme owl-carousel">
        @foreach($banners as $banner)
            <div class="banner-slide-item">
                <div class="container">
                    <div class="banner-wrapper @if($loop->even) flex-row-reverse @endif">
                        <div class="banner-content">
                            <h6 class="subtitle">{{__($banner->data_values->heading)}}</h6>
                            <h1 class="title">{{__($banner->data_values->sub_heading)}}</h1>
                            <p>
                                {{__($banner->data_values->description)}}
                            </p>
                            <div class="btn__grp">
                                <a href="{{url($banner->data_values->btn_url)}}" class="cmn--btn">{{__($banner->data_values->btn_name)}}</a>
                            </div>
                        </div>
                        <div class="banner-thumb">
                            <img src="{{getImage('assets/images/frontend/banner/'. @$banner->data_values->banner_image, '720x506')}}" alt="@lang('banner')">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@if($sections->secs != null)
    @foreach(json_decode($sections->secs) as $sec)
        @include($activeTemplate.'sections.'.$sec)
    @endforeach
@endif
@endsection
