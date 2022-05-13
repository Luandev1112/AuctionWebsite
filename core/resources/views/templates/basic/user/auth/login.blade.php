@extends($activeTemplate.'layouts.auth')
@section('content')
<section class="account-section d-flex flex-wrap align-items-center justify-content-center">
    <div class="container">
        <div class="account-wrapper">
            <div class="row g-0 flex-row-reverse">
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
                        <h3 class="title">@lang('Sign In')</h3>
                    </div>

                    <form class="account-form" method="POST" action="{{ route('user.login')}}" onsubmit="return submitUserForm();">
                        @csrf
                        
                        <div class="form-group">
                            <label for="username" class="form--label">@lang('Email Or Username')</label>
                            <input type="text" id="username" value="{{old('username')}}" class="form-control form--control" name="username" required="">
                        </div>

                        <div class="form-group">
                            <label for="password" class="form--label">@lang('Password')</label>
                            <div class="position-relative">
                                <input type="password" id="password" class="form-control form--control" name="password">
                                <div class="type-change">
                                    <i class="las la-eye"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            @php echo loadReCaptcha() @endphp
                        </div>

                        @include($activeTemplate.'partials.custom_captcha')
                        <div class="d-flex flex-wrap justify-content-between">
                            <a href="{{route('user.password.request')}}" class="text--base">@lang('Forgot Password')?</a>
                        </div>
                        <div class="mt-4">
                            <button class="cmn--btn" type="submit">@lang('Sign In')</button>
                        </div>
                        <div class="mt-3">
                            @lang("Don't have an account") ? <a href="{{ route('user.register') }}" class="text--base">@lang('Create Account Now')</a>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 right-side d-flex flex-wrap align-items-center">
                    <div class="w-100">
                        <div class="account-header text-center mb-3">
                            <h4 class="title mb-0">@lang('Recently Signed In')</h4>
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
                            &copy; {{Carbon\Carbon::now()->format('Y')}} @lang('All Right Reserved by') <a href="{{route('user.login')}}" class="text--base">{{$general->sitename}}</a>
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
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
    </script>
@endpush
