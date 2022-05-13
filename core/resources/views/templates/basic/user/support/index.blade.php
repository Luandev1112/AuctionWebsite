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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex flex-wrap justify-content-end text-end  my-2">
                                <a href="{{route('ticket.open') }}" class="cmn--btn ">@lang('New Ticket')</a>
                            </div>
                            <table class="table cmn--table">
                                <thead>
                                    <tr>
                                        <th>@lang('Subject')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Priority')</th>
                                        <th>@lang('Last Reply')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($supports as $key => $support)
                                        <tr>
                                            <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                            <td data-label="@lang('Status')">
                                                @if($support->status == 0)
                                                    <span class="badge badge--success">@lang('Open')</span>
                                                @elseif($support->status == 1)
                                                    <span class="badge badge--primary">@lang('Answered')</span>
                                                @elseif($support->status == 2)
                                                    <span class="badge badge--warning">@lang('Customer Reply')</span>
                                                @elseif($support->status == 3)
                                                    <span class="badge badge--dark">@lang('Closed')</span>
                                                @endif
                                            </td>
                                            <td data-label="@lang('Priority')">
                                                @if($support->priority == 1)
                                                    <span class="badge badge--dark">@lang('Low')</span>
                                                @elseif($support->priority == 2)
                                                    <span class="badge badge--success">@lang('Medium')</span>
                                                @elseif($support->priority == 3)
                                                    <span class="badge badge--primary">@lang('High')</span>
                                                @endif
                                            </td>
                                            <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                            <td data-label="@lang('Action')">
                                                <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn--primary btn-sm">
                                                    <i class="fa fa-desktop"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-center">@lang('No data found')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                             {{$supports->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
