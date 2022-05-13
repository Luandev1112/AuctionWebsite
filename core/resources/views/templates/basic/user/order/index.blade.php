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
                           @forelse($orderLists as $orderList)
                                <tr>
                                    <td data-label="@lang('Title')">
                                        {{str_limit($orderList->product->title, 20)}}
                                    </td>
                                    <td data-label="@lang('User')">
                                        <a href="{{route('profile', $orderList->user->username)}}">{{__($orderList->user->username)}}</a>
                                    </td>
                                    <td data-label="@lang('Product Amount')">
                                        {{showAmount($orderList->product->amount)}} {{$general->cur_text}}
                                    </td>
                                    <td data-label="@lang('Qty')">
                                        {{$orderList->qty}}
                                    </td>
                                    <td data-label="@lang('Amount')">
                                        {{showAmount($orderList->amount)}} {{__($general->cur_text)}}
                                    </td>

                                    <td data-label="@lang('Order Number')">
                                        {{__($orderList->order_number)}}
                                    </td>

                                    <td data-label="@lang('Status')">
                                        @if($orderList->status == 1)
                                            <span class="badge badge--primary">@lang('Pending')</span>
                                        @elseif($orderList->status == 2)
                                            <span class="badge badge--success">@lang('Complete')</span>
                                        @elseif($orderList->status == 3)
                                            <span class="badge badge--info">@lang('In Process')</span>
                                        @elseif($orderList->status == 4)
                                            <span class="badge badge--info">@lang('Shipped')</span><br>
                                            <span>{{showDateTime($orderList->shipped_date, 'd M Y')}}</span>
                                        @elseif($orderList->status == 5)
                                            <span class="badge badge--warning">@lang('Dispute')</span>
                                            <button class="btn btn--warning reportBtn px-2" data-bs-toggle="modal" data-bs-target="#reportModal" data-report="{{$orderList->dispute}}"><i class="fa fa-info"></i></button>
                                        @elseif($orderList->status == 6)
                                            <span class="badge badge--danger">@lang('Cancel')</span>
                                        @elseif($orderList->status == 7)
                                            <span class="badge badge--success">@lang('Refund')</span>     
                                        @endif
                                    </td>

                                    <td data-label="@lang('Action')">
                                        @if($orderList->status == 1)
                                            <a href="javascript:void(0)" class="btn btn--success inprocess" data-bs-toggle="modal" data-bs-target="#inprocessModal" data-order_number="{{$orderList->order_number}}"><i class="las la-check"></i>
                                            </a>

                                            <a href="javascript:void(0)" class="btn btn--danger cancel" data-bs-toggle="modal" data-bs-target="#cancelModal" data-order_number="{{$orderList->order_number}}">
                                                <i class="las la-times"></i>
                                            </a>
                                        @endif

                                        @if($orderList->status == 3)
                                            <a href="javascript:void(0)" class="btn btn--success shipped" data-bs-toggle="modal" data-bs-target="#shippedModal" data-order_number="{{$orderList->order_number}}"><i class="las la-check"></i>
                                            </a>
                                        @endif
                                        <a href="{{route('user.order.detail', $orderList->product_id)}}" class="btn btn--primary"><i class="las la-desktop"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{$emptyMessage}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$orderLists->links()}}
                </div>
            </div>
        </div>
    </div>
</section>



<div class="modal fade custom--modal" id="inprocessModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Order In Process Confirmation')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form method="POST" action="{{route('user.order.inprocess')}}">
            @csrf
                <input type="hidden" name="order_number">
                <div class="modal-body">
                    <p>@lang('Are you sure to in-process this order')?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade custom--modal" id="cancelModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Order Canceled Confirmation')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form method="POST" action="{{route('user.order.cancelled')}}">
            @csrf
                <input type="hidden" name="order_number">
                <div class="modal-body">
                    <p>@lang('Are you sure to canceled this order')?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade custom--modal" id="shippedModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Order Shipped Confirmation')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form method="POST" action="{{route('user.order.shipped')}}">
            @csrf
                <input type="hidden" name="order_number">
                <div class="modal-body">
                    <p>@lang('Are you sure to ship this order')?</p>

                    <div class="form-group">
                        <label for="date" class="form--label">@lang('Shipping Date')</label>
                        <input type="date" id="date" class="form-control form--control" name="shpping_date" required="">
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

    $('.inprocess').on('click', function() {
        var modal = $('#inprocessModal');
        modal.find('input[name=order_number]').val($(this).data('order_number'));
        modal.modal('show');
    });

    $('.shipped').on('click', function() {
        var modal = $('#shippedModal');
        modal.find('input[name=order_number]').val($(this).data('order_number'));
        modal.modal('show');
    });

    $('.cancel').on('click', function() {
        var modal = $('#cancelModal');
        modal.find('input[name=order_number]').val($(this).data('order_number'));
        modal.modal('show');
    });
</script>
@endpush