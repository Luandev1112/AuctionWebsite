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
                    <table class="table cmn--table">
                        <thead>
                            <tr>
                                <th>@lang('Transaction ID')</th>
                                <th>@lang('Gateway')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('After Charge')</th>
                                <th>@lang('Rate')</th>
                                <th>@lang('Receivable')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Time')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse($withdraws as $k=>$data)
                                <tr>
                                    <td data-label="@lang('Transaction ID')">{{$data->trx}}</td>
                                    <td data-label="@lang('Gateway')">{{__($data->method->name)}}</td>
                                    <td data-label="@lang('Amount')">
                                        <strong>{{showAmount($data->amount)}} {{__($general->cur_text)}}</strong>
                                    </td>
                                    <td data-label="@lang('Charge')" class="text-danger">
                                        {{showAmount($data->charge)}} {{__($general->cur_text)}}
                                    </td>
                                    <td data-label="@lang('After Charge')">
                                        {{showAmount($data->after_charge)}} {{__($general->cur_text)}}
                                    </td>
                                    <td data-label="@lang('Rate')">
                                        {{showAmount($data->rate)}} {{__($data->currency)}}
                                    </td>
                                    <td data-label="@lang('Receivable')" class="text--success">
                                       {{showAmount($data->final_amount)}} {{__($data->currency)}}
                                    </td>
                                    <td data-label="@lang('Status')">
                                        <div>
                                            @if($data->status == 2)
                                                <span class="badge badge--primary">@lang('Pending')</span>
                                            @elseif($data->status == 1)
                                                <span class="badge badge--success">@lang('Completed')</span>
                                                <button class="btn btn--info approveBtn px-2" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></button>
                                            @elseif($data->status == 3)
                                                <span class="badge badge--danger">@lang('Rejected')</span>
                                                <button class="btn btn--info approveBtn px-2" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></button>
                                            @endif
                                        </div>
                                    </td>
                                    <td data-label="@lang('Time')">
                                        {{showDateTime($data->created_at)}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage)}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$withdraws->links()}}
                </div>
            </div>
        </div>
    </div>
</section>

<div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Details')</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="withdraw-detail"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        (function($){
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');
                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
