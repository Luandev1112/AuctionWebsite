@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Advertisement Type')</th>
                                <th scope="col">@lang('Total Click')</th>
                                <th scope="col">@lang('Ad Size')</th>
                                <th scope="col">@lang('Total Impression')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($ads as $advr)
                        <tr>
                            <td data-label="@lang('Name')">
                                @if ($advr->type == 1)
                                    <div class="user">
                                        <div class="thumb">
                                            <a href="{{getImage(imagePath()['advertisement']['path'].'/'. $advr->image,$advr->size)}}" target="__blank">
                                                <img src="{{getImage(imagePath()['advertisement']['path'].'/'. $advr->image,$advr->size)}}" alt="@lang('image')">
                                            </a>
                                        </div>
                                        <span class="name">{{__($advr->name)}}</span>
                                    </div>
                                @else
                                    <span class="name">{{__($advr->name)}}</span>
                                @endif
                            </td>

                            <td data-label="@lang('Advertisement Type')">
                                @if($advr->type == 1)
                                    <span class="font-weight-normal badge badge--success">@lang('Banner')</span>
                                @else
                                    <span class="font-weight-normal badge badge--primary">@lang('Script')</span>
                                @endif
                            </td>

                            <td data-label="@lang('Total Click')">
                                {{__($advr->click)}}
                            </td>

                            <td data-label=">@lang('Ad Size')">
                                <span class="text--small badge font-weight-normal badge--primary">{{__($advr->size)}}</span>
                            </td>

                             <td data-label="@lang('Total Impression')">
                                {{__($advr->impression)}}
                            </td>
                         
                            <td data-label="@lang('Status')">
                                @if($advr->status == 1)
                                    <span class="badge badge--success">@lang('Enable')</span>
                                @else
                                    <span class="badge badge--danger">@lang('Disable')</span>
                                @endif
                            </td>
                            
                            <td data-label="Action">
                                <a href="{{route('admin.ads.edit', $advr->id)}}" class="icon-btn mr-2 edit" data-toggle="tooltip" title="@lang('Edit')">
                                    <i class="las la-pen text--shadow"></i>
                                </a>
                                <a href="javascript:void(0)" data-id="{{$advr->id}}" class="icon-btn btn--danger delete" data-toggle="tooltip" title="@lang('Delete')"><i class="las la-trash text--shadow"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
             {{paginateLinks($ads)}}
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="adModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
       <form action="{{route('admin.ads.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add Advertisement')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="font-weight-bold">@lang('Name')</label>
                    <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="@lang("Enter Name")" value="{{old('name')}}" id="name" maxlength="60" required="">
                </div>

                <div class="form-group">
                    <label for="size" class="font-weight-bold">@lang('Select Ad Size')</label>
                    <select class="form-control form-control-lg" name="size" id="size">
                        <option value="">@lang('Select Size')</option>
                        <option value="540x984">@lang('540x984')</option>
                        <option value="779x80">@lang('779x80')</option>
                        <option value="300x250">@lang('300x250')</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="type" class="font-weight-bold">@lang('Select Type')</label>
                    <select class="form-control type form-control-lg" id="type" name="type" required>
                        <option selected="" disabled="">----@lang('Select One')----</option>
                        <option value="1">@lang('Banner')</option>
                        <option value="2">@lang('Script')</option>
                    </select>
                </div>
                
                <div id="bannerAdd">
                    <div class="form-group ru">
                        <label for="redirect_url" class="font-weight-bold">@lang('Redirect Url')</label>
                        <input type="text" class="form-control form-control-lg" name="redirect_url" placeholder="@lang('http/https://example.com')" value="{{old('redirect_url')}}" id="redirect_url">
                    </div>

                    <div class="form-group">
                        <label for="symbol" class="form-control-label font-weight-bold">@lang('Ad Image')</label>
                        <div class="custom-file">
                            <input type="file" name="adimage" class="custom-file-input" id="customFileLangHTML">
                            <label class="custom-file-label" for="customFileLangHTML" data-browse="@lang('Choose Image')">@lang('Image')</label>
                        </div>
                    </div>
                </div>

                <div id="scriptAdd">
                    <div class="form-group">
                        <label for="script" class="font-weight-bold">@lang('Ad Script')</label>
                        <textarea type="text" class="form-control" name="script" id="script">{{old('script')}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-control-label font-weight-bold">@lang('Status') </label>
                    <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="status">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                <button type="submit" class="btn btn--primary"><i class="fa fa-fw fa-paper-plane"></i>@lang('Save')</button>
            </div>
        </div>
       </form>
    </div>
</div>


<div class="modal fade" id="deleteAds" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Delete Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('admin.ads.delete') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this ads?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <button type="button" data-toggle="modal" data-target="#adModal" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="fa fa-fw fa-paper-plane"></i>@lang('Add Ads')</button>
@endpush

@push('script')
    <script>
        'use strict';
        $("#bannerAdd").hide();
        $("#scriptAdd").hide();
        $('.type').on("change",function () {
            if($(this).val() == 1){
                $("#bannerAdd").show();
                $("#scriptAdd").hide();
            } else if($(this).val() == 2) {
                $("#bannerAdd").hide();
                $("#scriptAdd").show();
            }
        });
        $(document).on("change",".custom-file-input",function(){
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $('.delete').on('click', function () {
            var modal = $('#deleteAds');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });
    </script>
@endpush