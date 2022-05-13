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
                            <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center mt-4">
                                @csrf
                                <h6>@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h6>
                                <h6 class="my-3">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</h6>
                                <button type="button" class="cmn--btn" id="btn-confirm">@lang('Pay Now')</button>
                                <script
                                    src="//js.paystack.co/v1/inline.js"
                                    data-key="{{ $data->key }}"
                                    data-email="{{ $data->email }}"
                                    data-amount="{{$data->amount}}"
                                    data-currency="{{$data->currency}}"
                                    data-ref="{{ $data->ref }}"
                                    data-custom-button="btn-confirm"
                                >
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
