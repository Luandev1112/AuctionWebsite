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
                    <h6 class="my-3">@lang('Latest Sent Messages')</h6>
                    <table class="table cmn--table">
                        <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Subject')</th>
                                <th>@lang('Message')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse($sends as $send)
                                <tr>
                                    <td data-label="@lang('Date')">
                                        {{showDateTime($send->created_at)}}
                                        <br>
                                        {{diffforhumans($send->created_at)}}
                                    </td>
                                    <td data-label="@lang('User')">{{$send->receiver->username}}</td>
                                    <td data-label="@lang('Subject')">{{$send->subject}}</td>
                                    <td data-label="@lang('Message')">{{$send->message}}</td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{route('user.contact.read', encrypt($send->id))}}" class="btn btn-sm btn--primary">@lang('Read')</a>
                                        <button type="button" class="btn btn-sm btn--success reply" data-id="{{$send->id}}" data-bs-toggle="modal" data-bs-target="#contact">@lang('Reply')</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$sends->links()}}

                     <h6 class="my-3">@lang('Latest Received Messages')</h6>
                    <table class="table cmn--table">
                        <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Subject')</th>
                                <th>@lang('Message')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse($receiveds as $received)
                                <tr>
                                    <td data-label="@lang('Date')">
                                        {{showDateTime($received->created_at)}}
                                        <br>
                                        {{diffforhumans($received->created_at)}}
                                    </td>
                                    <td data-label="@lang('User')">{{$received->sender->username}}</td>
                                    <td data-label="@lang('Subject')">{{$received->subject}}</td>
                                    <td data-label="@lang('Message')">{{$received->message}}</td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{route('user.contact.read', encrypt($received->id))}}" class="btn btn-sm btn--primary">@lang('Read')</a>
                                        <button type="button" class="btn btn-sm btn--success reply" data-id="{{$received->id}}" data-bs-toggle="modal" data-bs-target="#contact">@lang('Reply')</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade custom--modal" id="contact">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Contact with ')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form method="POST" action="{{route('user.contact.reply')}}">
                @csrf
                <input type="hidden" name="contact_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="payment" class="form--label mb-2">@lang('Message')</label>
                        <textarea class="form-control form--control" name="message" required=""></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        "use strict";
        $('.reply').on('click', function () {
        var modal = $('#contact');
         modal.find('input[name=contact_id]').val($(this).data('id'));
         modal.modal('show');
        });
    </script>
@endpush
