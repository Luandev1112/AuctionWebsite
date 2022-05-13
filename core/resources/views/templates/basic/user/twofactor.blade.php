@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="dashboard-section pt-60 pb-60">
    <div class="container">
        <div class="pt-60 pb-60">
            <div class="row">
                <div class="col-xl-3">
                    @include($activeTemplate . 'partials.sidebar')
                </div>
                <div class="col-xl-9">
                    <div class="mb-4 d-xl-none text-end">
                        <div class="sidebar__init">
                            <i class="las la-columns"></i>
                        </div>
                    </div>
                    <div class="row justify-content-center g-4">
                        <div class="col-lg-6 col-md-6">
                            @if(Auth::user()->ts)
                                <div class="card custom--card">
                                    <div class="card-header">
                                        <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mx-auto text-center">
                                            <a href="javascript:void(0)"  class="btn btn-block btn-lg btn--danger" data-bs-toggle="modal" data-bs-target="#disableModal">
                                                @lang('Disable Two Factor Authenticator')</a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card custom--card">
                                    <div class="card-header">
                                        <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="key" value="{{$secret}}" class="form-control form--control" id="referralURL" readonly>
                                                <span class="input-group-text text--base copytext" id="copyBoard"> <i class="fa fa-copy"></i></span>
                                            </div>
                                        </div>

                                        <div class="form-group mx-auto text-center">
                                            <img class="mx-auto" src="{{$qrCodeUrl}}">
                                        </div>

                                        <div class="form-group mx-auto text-center">
                                            <a href="#0" class="btn btn--success btn-lg" data-bs-toggle="modal" data-bs-target="#enableModal">@lang('Enable Two Factor Authenticator')</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="card custom--card">
                                <div class="card-header">
                                    <h5 class="card-title">@lang('Google Authenticator')</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mt-3">@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
                                    <a class="btn btn--base btn-md mt-3" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('DOWNLOAD APP')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div id="enableModal" class="modal fade custom--modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Verify Your Otp')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form action="{{route('user.twofactor.enable')}}" method="POST">
                @csrf
                <div class="modal-body ">
                    <div class="form-group">
                        <input type="hidden" name="key" value="{{$secret}}">
                        <input type="text" class="form-control form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('close')</button>
                    <button type="submit" class="btn btn--success">@lang('Verify')</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="disableModal" class="modal fade custom--modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Verify Your Otp Disable')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form action="{{route('user.twofactor.disable')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Verify')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        (function($){
            "use strict";
            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
@endpush


