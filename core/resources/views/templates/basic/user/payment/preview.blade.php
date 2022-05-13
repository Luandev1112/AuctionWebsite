@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="dashboard-section pt-60 pb-60">
    <div class="container">
        <div class="pt-60 pb-60">
            <div class="row">
                <div class="col-xl-3">
                    @include($activeTemplate . 'partials.sidebar')
                </div>
                <div class="col-xl-9 align-self-start">
                    <div class="mb-4 d-xl-none text-end">
                        <div class="sidebar__init">
                            <i class="las la-columns"></i>
                        </div>
                    </div>
                    <div class="card custom--card">
                        <div class="card-header text-center p-3 py-sm-4 px-sm-4">
                            <h5 class="title m-0">@lang('Deposit Preview')</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="deposit-preview-body p-4">
                                <div class="deposit-group">
                                    <label for="amountt" class="deposit--label">@lang('Deposit Amount') :</label>
                                    <div class="input-group input--group">
                                        <div class="text-end">
                                            {{showAmount($data->amount)}} {{__($general->cur_text)}}
                                        </div>
                                    </div>
                                </div>
                                <div class="deposit-group">
                                    <label for="per-time" class="deposit--label">@lang('Charge') :</label>
                                    <div class="input-group input--group">
                                        <div class="text-end">
                                            {{showAmount($data->charge)}} {{__($general->cur_text)}}
                                        </div>
                                    </div>
                                </div>
                                <div class="deposit-group">
                                    <label for="per-time" class="deposit--label">@lang('Payable') :</label>
                                    <div class="input-group input--group">
                                        <div class="text-end">
                                           {{showAmount($data->amount + $data->charge)}} {{__($general->cur_text)}}
                                        </div>
                                    </div>
                                </div>

                                <div class="deposit-group">
                                    <label for="per-time" class="deposit--label">@lang('Conversion Rate') :</label>
                                    <div class="input-group input--group">
                                        <div class="text-end">
                                           1 {{__($general->cur_text)}} = {{showAmount($data->rate)}}  {{__($data->baseCurrency())}}
                                        </div>
                                    </div>
                                </div>

                                <div class="deposit-group">
                                    <label for="per-time" class="deposit--label">@lang('In') :</label>
                                    <div class="input-group input--group">
                                        <div class="text-end">
                                           {{$data->baseCurrency()}} : <strong>{{showAmount($data->final_amo)}}</strong>
                                        </div>
                                    </div>
                                </div>

                                @if($data->gateway->crypto==1)
                                    <div class="deposit-group">
                                        <label for="per-time" class="deposit--label">@lang('Conversion with') :</label>
                                        <div class="input-group input--group">
                                            <div class="text-end">
                                               <b> {{ __($data->method_currency) }}</b> @lang('and final value will Show on next step')
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="text-end mt-4">
                                    @if( 1000 >$data->method_code)
                                        <a href="{{route('user.deposit.confirm')}}" class="cmn--btn justify-content-center">@lang('Pay Now')</a>
                                    @else
                                        <a href="{{route('user.deposit.manual.confirm')}}" class="cmn--btn justify-content-center">@lang('Pay Now')</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


