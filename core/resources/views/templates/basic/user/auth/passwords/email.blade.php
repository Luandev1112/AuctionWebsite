@extends($activeTemplate.'layouts.auth')
@section('content')
<section class="account-section d-flex flex-wrap align-items-center justify-content-center">
    <div class="container">
        <div class="account-wrapper">
            <div class="row g-0 flex-row-reverse">
                <div class="col-lg-6 left-side">
                    <div class="account-logo justify-content-center">
                        <div class="logo">
                            <a href="{{route('home')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')"></a>
                        </div>
                    </div>
                    <form class="account-form" method="POST" action="{{ route('user.password.email') }}">
                        @csrf
                        <div class="form-group">
                            <label for="types" class="form--label">@lang('Select One')</label>
                            <select name="type" id="types" class="form-control form--control">
                                <option value="email">@lang('E-Mail Address')</option>
                                <option value="username">@lang('Username')</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="username" class="form--label my_value"></label>
                            <input type="text" id="username" class="form-control form--control checkUser" name="value" value="{{old('value')}}" required="" maxlength="40">
                        </div>

                        <div class="mt-4">
                            <button class="cmn--btn" type="submit">@lang('Submit')</button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-6 right-side d-flex flex-wrap align-items-center">
                    <div class="w-100">
                        <div class="account-header text-center mb-3">
                            <h4 class="title mb-0">@lang('Forgot Password')</h4>
                        </div>
                        <div class="copyright mt-lg-5 mt-4 text-center">
                            &copy; {{Carbon\Carbon::now()->format('Y')}} @lang('All Right Reserved by') <a href="{{route('home')}}" class="text--base">{{$general->sitename}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    (function($){
        "use strict";
        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }
    })(jQuery)
</script>
@endpush