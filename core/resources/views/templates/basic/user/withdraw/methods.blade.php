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
                    <div class="row g-4">
                    @foreach($withdrawMethod as $data)
                        <div class="col-sm-6 col-lg-4">
                            <div class="card custom--card">
                                <div class="card-header text-center">
                                    <h6 class="title m-0">{{__($data->name)}}</h6>
                                </div>
                                <div class="card-body">
                                    <img src="{{getImage(imagePath()['withdraw']['method']['path'].'/'. $data->image,imagePath()['withdraw']['method']['size'])}}" class="card-img-top" alt="{{__($data->name)}}" class="w-100">
                                    <ul class="list-group text-center">
                                        <li class="list-group-item">@lang('Limit')
                                            : {{showAmount($data->min_limit)}}
                                            - {{showAmount($data->max_limit)}} {{__($general->cur_text)}}
                                        </li>

                                        <li class="list-group-item"> @lang('Charge')
                                            - {{showAmount($data->fixed_charge)}} {{__($general->cur_text)}}
                                            + {{showAmount($data->percent_charge)}}%
                                        </li>
                                        <li class="list-group-item">@lang('Processing Time')
                                            - {{$data->delay}}
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    <a href="javascript:void(0)"  data-id="{{$data->id}}"
                                    data-resource="{{$data}}"
                                    data-min_amount="{{showAmount($data->min_limit)}}"
                                    data-max_amount="{{showAmount($data->max_limit)}}"
                                    data-fix_charge="{{showAmount($data->fixed_charge)}}"
                                    data-percent_charge="{{showAmount($data->percent_charge)}}"
                                    data-base_symbol="{{__($general->cur_text)}}"
                                    class="btn btn--base withdraw" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                        @lang('Withdraw Now')</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade custom--modal" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title method-name" id="withdrawModalLabel">@lang('Withdraw')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
                </div>
                <form action="{{route('user.withdraw.money')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p class="text-danger withdrawLimit"></p>
                        <p class="text-danger withdrawCharge"></p>

                        <div class="form-group">
                            <input type="hidden" name="currency"  class="edit-currency form-control">
                            <input type="hidden" name="method_code" class="edit-method-code  form-control">
                        </div>

                        <div class="form-group">
                            <label class="form--label mb-2">@lang('Enter Amount') : </label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form--control-2 bg--body" id="amounts" value="{{old('amount')}}" name="amount"
                                 placeholder="@lang('Enter Amount')" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.withdraw').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var withdrawLimit = `@lang('Withdraw Limit'): ${minAmount} - ${maxAmount}  {{__($general->cur_text)}}`;
                $('.withdrawLimit').text(withdrawLimit);
                var withdrawCharge = `@lang('Charge'): ${fixCharge} {{__($general->cur_text)}} ${(0 < percentCharge) ? ' + ' + percentCharge + ' %' : ''}`
                $('.withdrawCharge').text(withdrawCharge);
                $('.method-name').text(`@lang('Withdraw Via') ${result.name}`);
                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.id);
            });
        })(jQuery);
    </script>
@endpush

