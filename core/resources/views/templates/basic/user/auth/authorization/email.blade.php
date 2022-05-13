@extends($activeTemplate .'layouts.auth')
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
                    <form class="account-form" method="POST" action="{{route('user.verify.email')}}">
                        @csrf
                        <div class="form-group">
                            <label for="code" class="form--label">@lang('Verification Code')</label>
                            <input type="text" id="code" value="{{old('email_verified_code')}}" maxlength="7" class="form-control form--control" name="email_verified_code" required="">
                        </div>
                 
                        <div class="d-flex flex-wrap justify-content-between">
                            <p>@lang('Please check including your Junk/Spam Folder. if not found, you can') <a href="{{route('user.send.verify.code')}}?type=email" class="forget-pass"> @lang('Resend code')</a></p>
                                @if($errors->has('resend'))
                                    <br/>
                                    <small class="text-danger">{{ $errors->first('resend') }}</small>
                                @endif
                        </div>

                        <div class="mt-4">
                            <button class="cmn--btn" type="submit">@lang('Submit')</button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-6 right-side d-flex flex-wrap align-items-center">
                    <div class="w-100">
                        <div class="account-header text-center mb-3">
                            <h4 class="title mb-0">@lang('Please Verify Your Email to Get Access')</h4>
                            <h5 class="title mt-3">@lang('Your Email'): <strong>{{auth()->user()->email}}</strong></h5>
                        </div>
                        <div class="copyright mt-lg-5 mt-4 text-center">
                            &copy; {{Carbon\Carbon::now()->format('Y')}} @lang('All Right Reserved by') <a href="#0" class="text--base">{{$general->sitename}}</a>
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
        $('#code').on('input change', function () {
          var xx = document.getElementById('code').value;
          
              $(this).val(function (index, value) {
                 value = value.substr(0,7);
                  return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
              });
          
      });
    })(jQuery)
</script>
@endpush