@extends($activeTemplate.'layouts.auth')
@section('content')
@php
    $policys = getContent('policy_pages.element', false);
@endphp
<section class="account-section d-flex flex-wrap align-items-center justify-content-center">
    <div class="container">
        <div class="account-wrapper">
            <div class="row g-0">
                <div class="col-lg-6 left-side">
                    <div class="account-logo">
                        <div class="logo">
                            <a href="{{route('home')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')"></a>
                        </div>
                        <select class="select-bar langSel">
                            @foreach($language as $item)
                                <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="account-header">
                        <h3 class="title">@lang('Sign Up')</h3>
                    </div>
                    <form class="account-form" action="{{ route('user.register') }}" method="POST" onsubmit="return submitUserForm();">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="fname" class="form--label">@lang('First Name')</label>
                                <input type="text" id="fname" name="firstname" value="{{old('firstname')}}" class="form-control form--control" required="" maxlength="40">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="lname" class="form--label">@lang('Last Name')</label>
                                <input type="text" id="lname" class="form-control form--control" name="lastname" value="{{old('lastname')}}" required="" maxlength="40">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email" class="form--label">@lang('Email Address')</label>
                                <input type="text" id="email" class="form-control form--control checkUser" name="@lang('email')" value="{{old('email')}}" required="" maxlength="40">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="username" class="form--label">@lang('Username')</label>
                                <input type="text" id="username" class="form-control form--control checkUser" name="username" value="{{old('username')}}" required="" maxlength="40">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="country" class="form--label">@lang('Country')</label>
                                <select name="country" id="country" class="form-control form--control">
                                    @foreach($countries as $key => $country)
                                        <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="mobile" class="form--label">@lang('Mobile')</label>
                                <div class="input-group ">
                                    <span class="input-group-text mobile-code bg--transparent text--white p-0 pe-2 m-0"></span>
                                    <input type="hidden" name="mobile_code">
                                    <input type="hidden" name="country_code">
                                    <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}" class="form-control m-0 p-0 form--control checkUser" maxlength="40">
                                </div>
                                <small class="text-danger mobileExist"></small>
                            </div>

                            <div class="form-group col-md-6 hover-input-popup">
                                <label for="password" class="form--label">@lang('Password')</label>
                                <div class="position-relative">
                                    <input type="password" id="password" class="form-control form--control" name="password" required="">
                                    <div class="type-change">
                                        <i class="las la-eye"></i>
                                    </div>
                                    @if($general->secure_password)
                                        <div class="input-popup">
                                          <p class="error lower">@lang('1 small letter minimum')</p>
                                          <p class="error capital">@lang('1 capital letter minimum')</p>
                                          <p class="error number">@lang('1 number minimum')</p>
                                          <p class="error special">@lang('1 special character minimum')</p>
                                          <p class="error minimum">@lang('6 character password')</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="confirm-pass" class="form--label">@lang('Confirm Password')</label>
                                <div class="position-relative">
                                    <input type="password" id="confirm-pass" class="form-control form--control" name="password_confirmation" required="">
                                    <div class="type-change">
                                        <i class="las la-eye"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                @php echo loadReCaptcha() @endphp
                            </div>
                        </div>

                         @include($activeTemplate.'partials.custom_captcha')

                         @if($general->agree)
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="form-check form--check">
                                    <input type="checkbox" name="agree" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">@lang('Accept Our') 
                                        @foreach($policys as $policy)
                                            <a href="{{route('footer.menu', [slug($policy->data_values->title), $policy->id])}}">{{__($policy->data_values->title)}},</a>
                                        @endforeach
                                    </label>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            <button class="cmn--btn" type="submit">@lang('Sign Up')</button>
                        </div>
                        <div class="mt-3">
                            @lang('Already have an account') ? <a href="{{route('user.login')}}" class="text--base">@lang('Sign In Now')</a>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 right-side d-flex flex-wrap align-items-center">
                    <div class="w-100">
                        <div class="account-header text-center mb-3">
                            <h4 class="title mb-0">@lang('Our New Users')</h4>
                        </div>
                        <div class="recent__logins owl-carousel owl-theme">

                            @foreach($users as $user)
                                <div class="item">
                                    <div class="thumb">
                                        <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $user->image,imagePath()['profile']['user']['size'])}}" alt="@lang('client')">
                                        
                                    </div>
                                    <h6 class="name">{{$user->fullname}}</h6>
                                </div>
                            @endforeach
                        </div>
                        <div class="copyright mt-lg-5 mt-4 text-center">
                            &copy; {{Carbon\Carbon::now()->format('Y')}} @lang('All Right Reserved by') 
                            <a href="{{route('home')}}" class="text--base">{{$general->sitename}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade custom--modal" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h6 class="modal-title" id="exampleModalLabel">@lang('You are with us')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>@lang('You already have an account please Sign in')</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                <a href="{{ route('user.login') }}" class="btn btn--primary">@lang('Login')</a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')
<style>
    .country-code .input-group-prepend .input-group-text{
        background: #fff !important;
    }
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
    .hover-input-popup {
        position: relative;
    }
    .hover-input-popup:hover .input-popup {
        opacity: 1;
        visibility: visible;
    }
    .input-popup {
        position: absolute;
        bottom: 130%;
        left: 50%;
        width: 280px;
        background-color: #1a1a1a;
        color: #fff;
        padding: 20px;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
        opacity: 0;
        visibility: hidden;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }
    .input-popup::after {
        position: absolute;
        content: '';
        bottom: -19px;
        left: 50%;
        margin-left: -5px;
        border-width: 10px 10px 10px 10px;
        border-style: solid;
        border-color: transparent transparent #1a1a1a transparent;
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .input-popup p {
        padding-left: 20px;
        position: relative;
    }
    .input-popup p::before {
        position: absolute;
        content: '';
        font-family: 'Line Awesome Free';
        font-weight: 900;
        left: 0;
        top: 4px;
        line-height: 1;
        font-size: 18px;
    }
    .input-popup p.error {
        text-decoration: line-through;
    }
    .input-popup p.error::before {
        content: "\f057";
        color: #ea5455;
    }
    .input-popup p.success::before {
        content: "\f058";
        color: #28c76f;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
      "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
        (function ($) {
            @if($mobile_code)
            $(`option[data-code={{ $mobile_code }}]`).attr('selected','');
            @endif

            $('select[name=country]').change(function(){
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            @if($general->secure_password)
                $('input[name=password]').on('input',function(){
                    secure_password($(this));
                });
            @endif

            $('.checkUser').on('focusout',function(e){
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {mobile:mobile,_token:token}
                }
                if ($(this).attr('name') == 'email') {
                    var data = {email:value,_token:token}
                }
                if ($(this).attr('name') == 'username') {
                    var data = {username:value,_token:token}
                }
                $.post(url,data,function(response) {
                  if (response['data'] && response['type'] == 'email') {
                    $('#existModalCenter').modal('show');
                  }else if(response['data'] != null){
                    $(`.${response['type']}Exist`).text(`${response['type']} already exist`);
                  }else{
                    $(`.${response['type']}Exist`).text('');
                  }
                });
            });

        })(jQuery);

    </script>
@endpush
