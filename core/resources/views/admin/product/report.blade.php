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
                                <th>@lang('Report')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Product')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td data-label="@lang('Report')">
                                    <span>{{__($report->report)}}</span><br>
                                </td>

                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{$report->user->fullname}}</span>
                                    <br>
                                    <span class="small">
                                        <a href="{{ route('admin.users.detail', $report->user_id)}}"><span>@</span>{{ $report->user->username }}</a>
                                    </span>
                                </td>

                                <td data-label="@lang('Product')">
                                    <span>{{str_limit($report->product->title, 40)}}</span>
                                </td>

                                <td data-label="@lang('Action')">
                                    <a href="{{route('admin.product.detail', $report->product_id)}}" class="icon-btn btn--primary ml-1"><i class="las la-desktop"></i></a>
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
                {{ paginateLinks($reports) }}
            </div>
        </div>
    </div>
</div>
@endsection

