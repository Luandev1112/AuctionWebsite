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
                                <h6 class="text-center">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{$deposit->method_currency}}</h6>
                                <h6 class="my-3 text-center">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</h6>
                                <form action="{{$data->url}}" method="{{$data->method}}">
                                    <input type="hidden" custom="{{$data->custom}}" name="hidden">
                                    <script src="{{$data->checkout_js}}"
                                            @foreach($data->val as $key=>$value)
                                            data-{{$key}}="{{$value}}"
                                        @endforeach >
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
    <script>
        (function ($) {
            "use strict";
            $('input[type="submit"]').addClass("cmn--btn");
        })(jQuery);
    </script>
@endpush
