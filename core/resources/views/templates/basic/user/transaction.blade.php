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
                                <th>@lang('Date')</th>
                                <th>@lang('TRX')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('Post Balance')</th>
                                <th>@lang('Detail')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse($transactions as $transaction)
                                <tr>
                                    <td data-label="@lang('Date')">
                                        {{showDateTime($transaction->created_at)}}
                                        <br>
                                        {{diffforhumans($transaction->created_at)}}

                                    </td>
                                    <td data-label="@lang('TRX')">{{$transaction->trx}}</td>
                                    <td data-label="@lang('Amount')">
                                        <strong
                                            @if($transaction->trx_type == '+') class="text--success" @else class="text--danger" @endif>
                                            {{($transaction->trx_type == '+') ? '+':'-'}}
                                            {{getAmount($transaction->amount)}} {{$general->cur_text}}
                                        </strong>
                                    </td>
                                    <td data-label="@lang('Charge')">{{getAmount($transaction->charge)}} {{$general->cur_text}}</td>
                                    <td data-label="@lang('Post Balance')">{{getAmount($transaction->post_balance)}} {{$general->cur_text}}</td>
                                    <td data-label="@lang('Detail')">{{__($transaction->details)}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$transactions->links()}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
