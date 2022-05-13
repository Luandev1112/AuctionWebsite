@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                	<form action="{{route('admin.ads.update', $ads->id)}}" method="POST" enctype="multipart/form-data">
                		@csrf
                		<div class="row">
	                		<div class="col-lg-6">
		                		<div class="form-group">
		                			<label for="name" class="font-weight-bold">@lang('Name')</label>
		                			<input type="text" name="name" id="name" value="{{$ads->name}}" class="form-control" maxlength="60" required="">
		                		</div>
		                	</div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="size" class="font-weight-bold">@lang('Select Ad Size')</label>
                                    <input type="text" name="size" class="form-control" value="{{$ads->size}}" readonly="">
                                </div>
                            </div>
		                </div>

		                @if($ads->type == 1)
		                	<div class="row">
		                        <div class="col-lg-4">
		                            <div class="form-group ru">
		                                <label for="redirect_url" class="font-weight-bold">@lang('Redirect Url')</label>
		                                <input type="text" class="form-control" name="redirect_url" value="{{$ads->redirect_url}}" id="redirect_url">
		                            </div>
		                        </div>

		                        <div class="col-lg-4">
		                			<div class="form-group">
		                                <label for="symbol" class="form-control-label font-weight-bold">@lang('Ad Image')</label>
		                                <div class="custom-file">
		                                    <input type="file" name="adimage" class="custom-file-input" id="customFileLangHTML" required="">
		                                    <label class="custom-file-label" for="customFileLangHTML" data-browse="@lang('Choose Image')">@lang('Image')</label>
		                                </div>
		                            </div>
		                		</div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                        data-toggle="toggle" data-on="@lang('Enable')" @if($ads->status == 1) checked @endif data-off="@lang('Disabled')" name="status">
                                    </div>
                                </div>
		                    </div>
                        @else
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="script" class="font-weight-bold">@lang('Ad Script')</label>
                                        <textarea type="text" class="form-control" name="script" id="script">{{$ads->script}}</textarea>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                               data-toggle="toggle" data-on="@lang('Enable')" @if($ads->status == 1) checked @endif data-off="@lang('Disabled')" name="status"
                                              >
                                    </div>
                                </div>
                            </div>
                        @endif
                       	<div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block btn-lg"><i class="fa fa-fw fa-paper-plane"></i> @lang('Advertisement update')</button>
                        </div>
                	</form>
                </div>
            </div>
        </div>
    </div>

@push('breadcrumb-plugins')
    <a href="{{route('admin.ads.index')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i>@lang('Go Back')</a>
@endpush
@endsection


@push('script')
    <script>
        'use strict';
        $(document).on("change",".custom-file-input",function(){
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endpush
