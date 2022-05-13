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
                                <th>@lang('Category - Brand')</th>
                                <th>@lang('Time Duration - Amount')</th>
                                <th>@lang('Featured Item')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td data-label="@lang('Title')">
                                    <span>{{__(str_limit($product->title, 30))}}</span><br>
                                    <span> {{__(str_limit($product->sub_title, 20))}}</span>
                                </td>

                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{$product->user->fullname}}</span>
                                    <br>
                                    <span class="small">
                                        <a href="{{ route('admin.users.detail', $product->user_id)}}"><span>@</span>{{ $product->user->username }}</a>
                                    </span>
                                </td>

                                <td data-label="@lang('Category - Brand')">
                                    <span class="font-weight-bold">{{__($product->category->name)}}</span><br>
                                    {{__($product->brand->name)}}
                                </td>

                                <td data-label="@lang('Time Duration - Amount')">
                                    {{showDateTime($product->time_duration, 'd M Y')}}<br>
                                    <span class="font-weight-bold">{{getAmount($product->amount)}} {{__($general->cur_text)}}</span>
                                </td>

                                <td data-label="@lang('Featured Item')">
                                    @if($product->featured == 1)
                                        <span class="badge badge--success badge-pill font-weight-bold">@lang('Included')</span>
                                        <a href="javascript:void(0)" class="icon-btn btn--info ml-2 notInclude" data-toggle="tooltip" title="" data-original-title="@lang('Not Include')" data-id="{{ $product->id }}">
                                            <i class="las la-arrow-alt-circle-left"></i>
                                        </a>
                                    @else
                                        <span class="badge badge--warning badge-pill font-weight-bold text-white">@lang('Not included')</span>
                                        <a href="javascript:void(0)" class="icon-btn btn--success ml-2 include text-white" data-toggle="tooltip" title="" data-original-title="@lang('Include')" data-id="{{ $product->id }}">
                                            <i class="las la-arrow-alt-circle-right"></i>
                                        </a>
                                    @endif
                                </td>

                                <td data-label="@lang('Status')">
                                    @if($product->status == 0)
                                        <span class="badge badge--primary">@lang('Pending')</span><br>
                                        {{diffForHumans($product->created_at)}}
                                    @elseif($product->status == 1 && $product->time_duration > Carbon\Carbon::now())
                                        <span class="badge badge--success">@lang('Approved')</span>
                                    @elseif($product->status == 2)
                                        <span class="badge badge--danger">@lang('Cancel')</span>
                                    @elseif(Carbon\Carbon::now() > $product->time_duration)
                                        <span class="badge badge--warning">@lang('Expired')</span>
                                    @endif
                                </td>

                                <td data-label="@lang('Action')">
                                    @if($product->status == 0)
                                        <a href="javascript:void(0)" data-id="{{$product->id}}" class="icon-btn btn--success ml-1 approved"><i class="las la-check"></i></a>
                                        <a href="javascript:void(0)" data-id="{{$product->id}}" class="icon-btn btn--danger ml-1 cancel"><i class="las la-times"></i></a>
                                    @elseif($product->status == 1 && $product->time_duration > Carbon\Carbon::now())
                                        <a href="javascript:void(0)" data-id="{{$product->id}}" class="icon-btn btn--danger ml-1 cancel"><i class="las la-times"></i></a>
                                    @endif
                                    <a href="{{route('admin.product.detail', $product->id)}}" class="icon-btn btn--primary ml-1"><i class="las la-desktop"></i></a>
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
                {{ paginateLinks($products) }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="approvedby" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Approval Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            
            <form action="{{route('admin.product.approveby')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to approved this product?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="cancelBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Cancel Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            
            <form action="{{route('admin.product.cancelby')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to cancel this product?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="includeFeatured" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Featured Item Include')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="{{ route('admin.product.featured.include') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure include this product featured list?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="NotincludeFeatured" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Featured Item Remove')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="{{ route('admin.product.featured.remove') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure remove this product featured list?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <form action="{{route('admin.product.search', $scope ?? str_replace('admin.product.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or Title')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

    <form action="{{route('admin.product.category',$scope ?? str_replace('admin.product.', '', request()->route()->getName()))}}" method="GET" class="form-inline float-sm-right bg--white ">
        <div class="input-group has_append">
            <select class="form-control" name="category_id">
                <option>----@lang('Select Category')----</option> 
                @foreach($categorys as $category)
                    <option value="{{$category->id}}" @if(@$categoryId == $category->id) selected @endif>{{__($category->name)}}</option> 
                @endforeach
           </select>
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush



@push('script')
<script>
    "use strict";
    $('.approved').on('click', function () {
        var modal = $('#approvedby');
        modal.find('input[name=id]').val($(this).data('id'))
        modal.modal('show');
    });

    $('.cancel').on('click', function () {
        var modal = $('#cancelBy');
        modal.find('input[name=id]').val($(this).data('id'))
        modal.modal('show');
    });

    $('.include').on('click', function () {
        var modal = $('#includeFeatured');
        modal.find('input[name=id]').val($(this).data('id'))
        modal.modal('show');
    });

    $('.notInclude').on('click', function () {
        var modal = $('#NotincludeFeatured');
        modal.find('input[name=id]').val($(this).data('id'))
        modal.modal('show');
    });
</script>
@endpush

