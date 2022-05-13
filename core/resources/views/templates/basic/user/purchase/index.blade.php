@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="dashboard-section pt-60 pb-60">
    <div class="container">
        <div class="pt-60 pb-60">
            <div class="row justify-content-center g-4">
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
                                <th>@lang('Title')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Product Amount')</th>
                                <th>@lang('Qty')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Order Number')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse($purchaseProducts as $purchaseProduct)
                                <tr>
                                    <td data-label="@lang('Title')">
                                        {{str_limit($purchaseProduct->product->title, 20)}}
                                    </td>
                                    <td data-label="@lang('User')">
                                        <a href="{{route('profile', $purchaseProduct->product->user->username)}}">{{$purchaseProduct->product->user->username}}</a>
                                    </td>
                                    <td data-label="@lang('Product Amount')">
                                        {{showAmount($purchaseProduct->product->amount)}} {{__($general->cur_text)}}
                                    </td>
                                    <td data-label="@lang('Qty')">
                                        {{__($purchaseProduct->qty)}}
                                    </td>
                                    <td data-label="@lang('Amount')">
                                        {{showAmount($purchaseProduct->amount)}} {{__($general->cur_text)}}
                                    </td>
                                    <td data-label="@lang('Order Number')">
                                        {{__($purchaseProduct->order_number)}}
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if($purchaseProduct->status == 1)
                                            <span class="badge badge--primary">@lang('Pending')</span>
                                        @elseif($purchaseProduct->status == 2)
                                            <span class="badge badge--success">@lang('Complete')</span>
                                        @elseif($purchaseProduct->status == 3)
                                            <span class="badge badge--info">@lang('In Process')</span>
                                        @elseif($purchaseProduct->status == 4)
                                            <span class="badge badge--info">@lang('Shipped')</span><br>
                                             <span>{{showDateTime($purchaseProduct->shipped_date, 'd M Y')}}</span>
                                        @elseif($purchaseProduct->status == 5)
                                            <span class="badge badge--warning">@lang('Dispute')</span>
                                            <button class="btn btn--warning reportBtn px-2" data-bs-toggle="modal" data-bs-target="#reportModal" data-report="{{$purchaseProduct->dispute}}"><i class="fa fa-info"></i></button>
                                        @elseif($purchaseProduct->status == 6)
                                            <span class="badge badge--danger">@lang('Cancel')</span>
                                        @elseif($purchaseProduct->status == 7)
                                            <span class="badge badge--success">@lang('Refund')</span>     
                                        @endif
                                    </td>

                                    <td data-label="@lang('Action')">
                                        @if($purchaseProduct->status == 4)
                                            <a href="javascript:void(0)" class="btn btn--success complated" data-bs-toggle="modal" data-bs-target="#complatedModal" data-order_number="{{$purchaseProduct->order_number}}"><i class="las la-check"></i>
                                            </a>

                                            <a href="javascript:void(0)" class="btn btn--danger disputed" data-bs-toggle="modal" data-bs-target="#disputedModal" data-order_number="{{$purchaseProduct->order_number}}"><i class="las la-times"></i>
                                            </a>
                                        @endif

                                        <a href="{{route('user.order.detail', $purchaseProduct->product_id)}}" class="btn btn--primary"><i class="las la-desktop"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{$emptyMessage}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$purchaseProducts->links()}}
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade custom--modal" id="complatedModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Order Complete')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form method="POST" action="{{route('user.purchase.product.complated')}}">
            @csrf
                <input type="hidden" name="order_number">
                <div class="modal-body">
                    <p>@lang('Are you sure to complete this order')?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade custom--modal" id="disputedModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Order Disputed')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form method="POST" action="{{route('user.purchase.product.dispute')}}">
            @csrf
                <input type="hidden" name="order_number">
                <div class="modal-body">
                    <p>@lang('Are you sure to disputed this order')?</p>

                    <div class="form-group">
                        <label for="report" class="form--label">@lang('Why Dispute')</label>
                        <textarea id="report" class="form-control form--control" name="report" required=""></textarea>
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


<div class="modal fade custom--modal" id="reportModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Disputed Report')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form method="POST" action="{{route('user.order.inprocess')}}">
            @csrf
                <input type="hidden" name="order_number">
                <div class="modal-body">
                     <div class="report"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        "use strict";
        $('.reportBtn').on('click', function() {
            var modal = $('#reportModal');
            var feedback = $(this).data('report');
            modal.find('.report').html(`<p> ${feedback} </p>`);
            modal.modal('show');
        });

        $('.complated').on('click', function() {
            var modal = $('#complatedModal');
            modal.find('input[name=order_number]').val($(this).data('order_number'));
            modal.modal('show');
        });

        $('.disputed').on('click', function() {
            var modal = $('#disputedModal');
            modal.find('input[name=order_number]').val($(this).data('order_number'));
            modal.modal('show');
        });
    </script>
@endpush