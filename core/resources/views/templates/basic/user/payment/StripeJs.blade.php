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
                    <div class="card card-deposit custom--card">
                        <div class="card-body">
                            <div class="img">
                                <img src="{{$deposit->gatewayCurrency()->methodImage()}}" class="card-img-top" alt="@lang('Image')" class="w-100">
                            </div>
                            <div class="text-center mt-4">
                                <form action="{{$data->url}}" method="{{$data->method}}">
                                    <h6 class="text-center">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h6>
                                    <h6 class="my-3 text-center">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</h6>
                                    <script src="{{$data->src}}"
                                        class="stripe-button"
                                        @foreach($data->val as $key=> $value)
                                        data-{{$key}}="{{$value}}"
                                        @endforeach
                                    >
                                    </script>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('button[type="submit"]').addClass(" btn-success btn-round custom-success text-center btn-lg");
        })(jQuery);
    </script>
@endpush
