<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$general->sitename(__($pageTitle))}}</title>
    @include('partials.seo')
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'frontend/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'frontend/css/magnific-popup.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'frontend/css/owl.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'frontend/css/main.css')}}">
    <link rel="shortcut icon" href="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" type="@lang('image/x-icon')">
    <link href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{$general->base_color}}" rel="stylesheet"/>
    @stack('style-lib')
    @stack('style')
</head>

<body>
    @stack('fbComment')
    <main class="main-body">
        <div class="overlay"></div>
        <a href="#" class="scrollToTop"><i class="las la-angle-up"></i></a>
        <div class="preloader" id="preloader">
            <div class="logo">
            </div>
            <div class="loader-frame">
                <div class="loader1" id="loader1">
                </div>
                <div class="circle"></div>
                <h4 class="hello">@lang('Hello')</h4>
                <h6 class="wellcome">@lang('Wellcome to') <span>{{$general->sitename}}</span></h6>
            </div>
        </div>
        @yield('content')
    </main>
    @include($activeTemplate . 'partials.footer')
    <script src="{{asset('assets/global/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'frontend/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'frontend/js/rafcounter.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'frontend/js/magnific-popup.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'frontend/js/countdown.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'frontend/js/owl.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'frontend/js/main.js')}}"></script>
    @stack('script-lib')
    @stack('script')
    @include('partials.plugins')
    @include('partials.notify')

    <script>
        (function ($) {
        "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{route('home')}}/change/"+$(this).val() ;
            });
            @if(@$cookie->data_values->status && !session('cookie_accepted'))
                $('#cookieModal').modal('show');
            @endif
        })(jQuery);
    </script>
</body>
</html>