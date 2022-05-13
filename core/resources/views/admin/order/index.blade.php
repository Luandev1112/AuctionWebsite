@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Title - Sub Title')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Product User')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('Shipping Date - Order Number')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td data-label="@lang('Title - Sub Title')">
                                    <span class="font-weight-bold">{{__(str_limit($order->product->title, 30))}}</span><br>
                                    <span> {{__(str_limit($order->product->sub_title, 20))}}</span>
                                </td>

                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{$order->user->fullname}}</span>
                                    <br>
                                    <span class="small">
                                        <a href="{{ route('admin.users.detail', $order->user_id)}}"><span>@</span>{{ $order->user->username }}</a>
                                    </span>
                                </td>

                                <td data-label="@lang('Product User')">
                                    <span class="font-weight-bold">{{$order->product->user->fullname}}</span>
                                    <br>
                                    <span class="small">
                                        <a href="{{ route('admin.users.detail', $order->product->user_id)}}"><span>@</span>{{ $order->product->user->username }}</a>
                                    </span>
                                </td>

                                <td data-label="@lang('Amount')">
                                    <span class="font-weight-bold"> 
                                        @if($order->product->featured == 1)
                                            ((<span data-toggle="tooltip" data-original-title="Product Price">{{__($general->cur_sym)}}{{getAmount($order->product->amount)}}</span> x <span data-toggle="tooltip" data-original-title="QTY">{{__($order->qty)}})</span> + 
                                             <span data-toggle="tooltip" data-original-title="Featured Price">{{getAmount($general->featured_price * $order->qty)}}</span>)
                                        @else
                                            {{__($general->cur_sym)}}{{getAmount($order->product->amount)}} X {{__($order->qty)}}
                                        @endif
                                    </span><br>
                                       
                                    <span class="font-weight-bold text--success">
                                        {{getAmount($order->amount)}} {{__($general->cur_text)}}
                                    </span>
                                </td>

                                <td data-label="@lang('Charge')">
                                    <span class="font-weight-bold text--danger">{{getAmount($order->charge)}} {{$general->cur_text}}</span>
                                </td>

                                <td data-label="@lang('Shipping Date - Order Number')">
                                    @if($order->shipped_date)
                                        {{showDateTime($order->shipped_date, 'd M Y')}}
                                    @else
                                        @lang('N/A')
                                    @endif<br>
                                    <span class="font-weight-bold">{{$order->order_number}}</span>
                                </td>
                                <td data-label="@lang('Status')">
                                    @if($order->status == 1)
                                        <span class="badge badge--primary">@lang('Pending')</span>
                                    @elseif($order->status == 2)
                                        <span class="badge badge--success">@lang('Complete')</span>
                                    @elseif($order->status == 3)
                                        <span class="badge badge--info">@lang('In Process')</span>
                                    @elseif($order->status == 4)
                                        <span class="badge badge--primary">@lang('Shipped')</span>
                                    @elseif($order->status == 5)
                                        <span class="badge badge--warning">@lang('Dispute')</span>
                                        <a href="javascript:void(0)" data-report="{{$order->dispute}}" class="icon-btn btn--danger ml-1 reportBtn"><i class="las la-exclamation"></i></a>
                                    @elseif($order->status == 6)
                                        <span class="badge badge--danger">@lang('Cancel')</span>  
                                    @elseif($order->status == 7)
                                        <span class="badge badge--success">@lang('Refund')</span>   
                                    @endif
                                </td>
                                <td data-label="@lang('Action')">
                                    @if($order->status == 5)
                                        <a href="javascript:void(0)" data-id="{{$order->id}}" class="icon-btn btn--info ml-1 refundBtn">@lang('Refund')</a>
                                        <a href="javascript:void(0)" data-id="{{$order->id}}" class="icon-btn btn--warning ml-1 complatedBtn">@lang('Resolve')</a>
                                    @endif
                                    <a href="{{route('admin.product.detail', $order->product_id)}}" class="icon-btn btn--primary ml-1"><i class="las la-desktop"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                {{ paginateLinks($orders) }}
            </div>
        </div>
    </div>
</div>

<div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Disputed Report')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="report"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--danger" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Refund Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{route('admin.order.refund')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you want to refund money for this order?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="complatedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Complated Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            
            <form action="{{route('admin.order.resolved')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you want to complete this order?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <form action="{{route('admin.order.search', $scope ?? str_replace('admin.order.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Order number .....')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush

@push('script')
    <script>
        "use strict";
        $('.reportBtn').on('click', function() {
            var modal = $('#detailModal');
            var feedback = $(this).data('report');
            modal.find('.report').html(`<p> ${feedback} </p>`);
            modal.modal('show');
        });

        $('.refundBtn').on('click', function () {
            var modal = $('#refundModal');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });

        $('.complatedBtn').on('click', function () {
            var modal = $('#complatedModal');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });
    </script>
@endpush


