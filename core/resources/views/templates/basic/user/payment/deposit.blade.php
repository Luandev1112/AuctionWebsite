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
                       @foreach($gatewayCurrency as $data)
                            <div class="col-sm-6 col-md-4 col-xl-3">
                                <div class="card custom--card deposit-card">
                                    <div class="card-header text-center">
                                        <h6 class="title m-0">{{__($data->name)}}</h6>
                                    </div>
                                    <img src="{{$data->methodImage()}}" alt="@lang('deposit')">
                                    <div class="card-body text-center">
                                    <a href="javascript:void(0)" data-id="{{$data->id}}"
                                        data-name="{{$data->name}}"
                                        data-currency="{{$data->currency}}"
                                        data-method_code="{{$data->method_code}}"
                                        data-min_amount="{{showAmount($data->min_amount)}}"
                                        data-max_amount="{{showAmount($data->max_amount)}}"
                                        data-base_symbol="{{$data->baseSymbol()}}"
                                        data-fix_charge="{{showAmount($data->fixed_charge)}}"
                                        data-percent_charge="{{showAmount($data->percent_charge)}}" class="btn btn--base deposit" data-bs-toggle="modal" data-bs-target="#modal">
                                            @lang('Deposit Now')</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade custom--modal" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title method-name"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form method="POST" action="{{route('user.deposit.insert')}}">
                @csrf
                <input type="hidden" name="currency" class="edit-currency">
                <input type="hidden" name="method_code" class="edit-method-code">
                <div class="modal-body">
                    <ul class="mb-4">
                        <li>
                            <span class="text--success depositLimit"></span>
                        </li>
                        <li>
                            <span class="text--danger depositCharge"></span>
                        </li>
                    </ul>
                    <label class="form--label mb-2">@lang('Enter Amount')</label>
                    <div class="input-group input--group">
                        <input type="text" class="form-control form--control h--50px" name="amount" placeholder="@lang('0.0')">
                        <span class="input-group-text btn--primary cmn--btn border-0 h--50px">
                            {{$general->cur_text}}
                        </span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        "use strict";
        $('.deposit').on('click', function () {
            var name = $(this).data('name');
            var currency = $(this).data('currency');
            var method_code = $(this).data('method_code');
            var minAmount = $(this).data('min_amount');
            var maxAmount = $(this).data('max_amount');
            var baseSymbol = "{{$general->cur_text}}";
            var fixCharge = $(this).data('fix_charge');
            var percentCharge = $(this).data('percent_charge');

            var depositLimit = `@lang('Deposit Limit'): ${minAmount} - ${maxAmount}  ${baseSymbol}`;
            $('.depositLimit').text(depositLimit);
            var depositCharge = `@lang('Charge'): ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
            $('.depositCharge').text(depositCharge);
            $('.method-name').text(`@lang('Payment By ') ${name}`);
            $('.currency-addon').text(baseSymbol);
            $('.edit-currency').val(currency);
            $('.edit-method-code').val(method_code);
        });
    </script>
@endpush
