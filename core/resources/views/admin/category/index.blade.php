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
                                    <th>@lang('Name')</th>
                                    <th>@lang('Subcategory')</th>
                                    <th>@lang('Specification')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($categorys as $category)
                                <tr>
                                    <td data-label="@lang('Name')">{{__($category->name)}}</td>
                                    <td data-label="@lang('Subcategory')">
                                        <a href="{{route('admin.category.subcategory.list', $category->id)}}" class="icon-btn btn--primary ml-1">@lang('view all')</a>
                                    </td>
                                    <td data-label="@lang('Specification')">
                                        <a href="{{route('admin.category.specification', $category->id)}}" class="icon-btn btn--primary ml-1">@lang('view all')</a>
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if($category->status == 1)
                                            <span class="badge badge--success">@lang('Enable')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Disable')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <a href="javascript:void(0)" class="icon-btn btn--primary ml-1 updateCity"
                                            data-id="{{$category->id}}"
                                            data-name="{{$category->name}}"
                                            data-status ="{{$category->status}}"
                                        ><i class="las la-pen"></i></a>
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
                    {{ paginateLinks($categorys) }}
                </div>
            </div>
        </div>
    </div>


    <div id="cityModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add Category')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.category.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="form-control-label font-weight-bold">@lang('Name')</label>
                            <input type="text" class="form-control form-control-lg" name="name" id="name" placeholder="@lang("Enter Name")"  maxlength="80" required="">
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Status') </label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="status">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary"><i class="fa fa-fw fa-paper-plane"></i>@lang('Create')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="updateCityModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Update Category')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.category.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="form-control-label font-weight-bold">@lang('Name')</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="@lang("Enter Name")"  maxlength="80" required="">
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Status') </label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="status">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary"><i class="fa fa-fw fa-paper-plane"></i>@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="javascript:void(0)" class="btn btn-sm btn--primary box--shadow1 text--small addCity" ><i class="fa fa-fw fa-paper-plane"></i>@lang('Add Category')</a>
@endpush

@push('script')
<script>
    "use strict";
    $('.addCity').on('click', function() {
        $('#cityModel').modal('show');
    });
    
    $('.updateCity').on('click', function() {
        var modal = $('#updateCityModel');
        modal.find('input[name=id]').val($(this).data('id'));
        modal.find('input[name=name]').val($(this).data('name'));
        var data = $(this).data('status');
        if(data == 1){
            modal.find('input[name=status]').bootstrapToggle('on');
        }else{
            modal.find('input[name=status]').bootstrapToggle('off');
        }
        modal.modal('show');
    });
</script>
@endpush
