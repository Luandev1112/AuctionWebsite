@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="dashboard-section pt-60 pb-60">
    <div class="container">
        <div class="pt-60 pb-60">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card custom--card">
                        <div class="card-header card-header-bg d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class="card-title mt-0">
                                @if($my_ticket->status == 0)
                                    <span class="badge badge--success">@lang('Open')</span>
                                @elseif($my_ticket->status == 1)
                                    <span class="badge badge--primary">@lang('Answered')</span>
                                @elseif($my_ticket->status == 2)
                                    <span class="badge badge--warning">@lang('Replied')</span>
                                @elseif($my_ticket->status == 3)
                                    <span class="badge badge--dark">@lang('Closed')</span>
                                @endif
                                [@lang('Ticket')#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}
                            </h5>
                            <button class="btn btn-danger close-button" type="button" title="@lang('Close Ticket')" data-bs-toggle="modal" data-bs-target="#DelModal"><i class="fa fa-lg fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="support__wrapper">
                                @if($my_ticket->status != 4)
                                    <form class="chat-form bg-transparent row" method="post" action="{{ route('ticket.reply', $my_ticket->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="replayTicket" value="1">
                                    
                                        <div class="form-group col-md-12">
                                            <textarea name="message" class="form-control form--control-2 bg--body" id="inputMessage" placeholder="@lang('Your Reply')"></textarea>
                                        </div>
                                      
                                        <div class="d-flex form-group align-items-end">
                                            <div class="flex-grow-1 file-upload">
                                                <label for="inputAttachments">@lang('Attachments')</label>
                                                <input type="file" name="attachments[]" id="inputAttachments" class="form-control form--control-2 bg--body h--50px">
                                                <div id="fileUploadsContainer"></div>
                                            </div>
                                            <div class="ms-3">
                                                <button type="button" class="btn px-3 h--50px btn--primary addFile">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>

                                            <div class="ms-3">
                                                <button type="submit" class="btn btn--success h--50px">
                                                    <i class="fa fa-reply"></i> @lang('Reply')
                                                </button>
                                            </div>
                                        </div>
                                        <p class="mt-3">
                                            @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                        </p>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <div class="card-body">
                            @foreach($messages as $message)
                                @if($message->admin_id == 0)
                                    <div class="row border border-primary rounded my-3 py-3 mx-2">
                                        <div class="col-md-3 border-right text-right">
                                            <h6 class="my-3">{{ $message->ticket->name }}</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="text-white font-weight-bold my-3">
                                                @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                            <p>{{$message->message}}</p>
                                            @if($message->attachments()->count() > 0)
                                                <div class="mt-2">
                                                    @foreach($message->attachments as $k=> $image)
                                                        <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="row border border-warning rounded my-3 py-3 mx-2" style="background-color: #ff6a0033">
                                        <div class="col-md-3 border-right text-right">
                                            <h6 class="my-3">{{ $message->admin->name }}</h6>
                                            <p class="lead text-muted">@lang('Admin')</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="text-white font-weight-bold my-3">
                                                @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                            <p>{{$message->message}}</p>
                                            @if($message->attachments()->count() > 0)
                                                <div class="mt-2">
                                                    @foreach($message->attachments as $k=> $image)
                                                        <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <div class="modal fade custom--modal" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                    @csrf
                    <input type="hidden" name="replayTicket" value="2">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Confirmation')!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to close this support ticket')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>
                            @lang('Close')
                        </button>
                        <button type="submit" class="btn btn--success btn-sm"><i class="fa fa-check"></i> @lang("Confirm")
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(
                    `<div class="input-group mt-3">
                        <input type="file" name="attachments[]" class="form-control form--control-2 bg--body h--50px" required />
                        <span class="input-group-text btn btn--danger support-btn remove-btn">x</span>
                    </div>`
                )
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);

    </script>
@endpush
