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
                    <div class="support--card-wrapper mw-100">
                        <div class="card custom--card mb-5">
                            <div class="card-header">
                                <div class="d-flex flex-wrap justify-content-end support-ticket-header">
                                    <a href="{{route('ticket')}}" class="cmn--btn">@lang('All Tickets')</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="support__wrapper">
                                    <form class="chat-form bg-transparent row" action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                                        @csrf
                                        <div class="form-group col-md-6">
                                            <label for="name" class="form--label mb-2">@lang('Name')</label>
                                            <input type="text" class="form-control form--control-2 bg--body h--50px" name="name" id="name" value="{{@$user->firstname . ' '.@$user->lastname}}" readonly="">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="email" class="form--label mb-2">@lang('Email')</label>
                                            <input type="text" class="form-control form--control-2 bg--body h--50px" id="email" name="email" value="{{@$user->email}}" readonly="">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="subject" class="form--label mb-2">@lang('Subject')</label>
                                            <input type="text" class="form-control form--control-2 bg--body h--50px" id="subject" name="subject" placeholder="@lang('Enter Subject')">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="priority">@lang('Priority')</label>
                                            <select name="priority" class="form-control form--control-2 bg--body h--50px">
                                                <option value="3">@lang('High')</option>
                                                <option value="2">@lang('Medium')</option>
                                                <option value="1">@lang('Low')</option>
                                            </select>
                                        </div>

                                        <div class="row form-group ">
                                            <div class="col-sm-9 file-upload">
                                                <label for="inputAttachments">@lang('Attachments')</label>
                                                <input type="file" name="attachments[]" id="inputAttachments" class="form-control form--control-2 bg--body h--50px">
                                                <div id="fileUploadsContainer"></div>
                                                <p class="mt-3">
                                                    @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                                </p>
                                            </div>
                                            <div class="col-sm-1 mt-4">
                                                <button type="button" class="btn btn--success addFile">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="message" class="form--label mb-2">@lang('Message')</label>
                                            <textarea class="form-control form--control-2 bg--body" name="message" id="message" placeholder="@lang('Enter Message')"></textarea>
                                        </div>
                                        <div class="form-group col-md-12 mb-0">
                                            <button class="cmn--btn" type="submit" id="recaptcha" ><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(`
                    <div class="input-group mt-2">
                        <input type="file" name="attachments[]" class="form-control form--control-2 bg--body h--50px" required />
                        <span class="input-group-text btn btn-danger support-btn remove-btn">x</span>
                    </div>
                `)
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
