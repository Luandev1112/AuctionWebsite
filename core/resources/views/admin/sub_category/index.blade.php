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
                                    <th>@lang('Category')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($subCategorys as $subCategory)
                                <tr>
                                    <td data-label="@lang('Name')">{{__($subCategory->name)}}</td>
                                    <td data-label="@lang('Category')">{{__($subCategory->category->name)}}</td>
                                    <td data-label="@lang('Action')">
                                        <a href="javascript:void(0)" class="icon-btn btn--primary ml-1 updateSubcategory"
                                            data-id="{{$subCategory->id}}"
                                            data-name="{{$subCategory->name}}"
                                            data-category_id="{{$subCategory->category_id}}"
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
                    {{ paginateLinks($subCategorys) }}
                </div>
            </div>
        </div>
    </div>


    <div id="addSubCategoryModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add Sub Category')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.subcategory.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="category_id" class="form-control-label font-weight-bold">@lang('Select Category')</label>
                            <select class="form-control form-control-lg" id="category_id" name="category_id">
                                <option value="">@lang('Select One')</option>
                                @foreach($categorys as $category)
                                    <option value="{{$category->id}}">{{__($category->name)}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name" class="form-control-label font-weight-bold">@lang('Name')</label>
                            <input type="text" class="form-control form-control-lg" name="name" id="name" placeholder="@lang("Enter Name")"  maxlength="120" required="">
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


    <div id="updateSubCategoryModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Update Sub Category')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.subcategory.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="category_id" class="form-control-label font-weight-bold">@lang('Select Category')</label>
                            <select class="form-control form-control-lg" id="category_id" name="category_id">
                                <option value="">@lang('Select One')</option>
                                @foreach($categorys as $category)
                                    <option value="{{$category->id}}">{{__($category->name)}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name" class="form-control-label font-weight-bold">@lang('Name')</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="@lang("Enter Name")"  maxlength="120" required="">
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
    <a href="javascript:void(0)" class="btn btn-sm btn--primary box--shadow1 text--small addSubCategory" ><i class="fa fa-fw fa-paper-plane"></i>@lang('Add Sub Category')</a>
@endpush

@push('script')
<script>
    "use strict";
    $('.addSubCategory').on('click', function() {
        $('#addSubCategoryModel').modal('show');
    });
    
    $('.updateSubcategory').on('click', function() {
        var modal = $('#updateSubCategoryModel');
        modal.find('input[name=id]').val($(this).data('id'));
        modal.find('input[name=name]').val($(this).data('name'));
        modal.find('select[name=category_id]').val($(this).data('category_id'));
        modal.modal('show');
    });
</script>
@endpush
