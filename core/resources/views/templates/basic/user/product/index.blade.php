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
                    <table class="table cmn--table">
                        <thead>
                            <tr>
                               <th>@lang('Title')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Time Duration')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse($products as $product)
                                <tr>
                                    <td data-label="@lang('Title')">{{str_limit($product->title, 20)}}</td>
                                    <td data-label="@lang('Category')">{{__($product->category->name)  }}</td>
                                    <td data-label="@lang('Amount')">
                                        <strong>{{showAmount($product->amount)}} {{__($general->cur_text)}}</strong>
                                    </td>
                                    <td data-label="@lang('Time Duration')">
                                        {{showDateTime($product->time_duration, 'd M Y')}}</strong>
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if($product->status == 0)
                                            <span class="badge badge--primary">@lang('Pending ')</span>
                                        @elseif($product->status == 1 && $product->time_duration > Carbon\Carbon::now())
                                            <span class="badge badge--success">@lang('Approved ')</span>
                                        @elseif($product->status == 2)
                                            <span class="badge badge--danger">@lang('Cancel')</span>
                                        @elseif(Carbon\Carbon::now() > $product->time_duration)
                                            <span class="badge badge--warning">@lang('Expired')</span>
                                        @endif
                                    </td>

                                    <td data-label="@lang('Action')">
                                        <a href="{{route('user.add.product.specification',$product->id)}}" class="btn btn--warning text-white  @if($product->productSpecification->isEmpty()) warining--grow @endif">
                                            @if($product->productSpecification->isEmpty())
                                                @lang('Add')
                                            @else
                                                @lang('Update')
                                            @endif
                                            @lang('Specification')
                                        </a>
                                        <a href="{{route('user.product.edit', $product->id)}}" class="btn btn--primary">@lang('Edit')</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{$emptyMessage}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection