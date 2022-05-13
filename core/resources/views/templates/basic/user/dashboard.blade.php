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
                    <div class="row justify-content-center g-4">
                        <div class="col-lg-4 col-sm-6">
                            <div class="dashboard__item">
                                <div class="content">
                                    <span class="subtitle">@lang('Balance')</span>
                                    <h4 class="title">{{$general->cur_sym}} {{getAmount($user->balance)}}</h4>
                                </div>
                                <div class="thumb">
                                    <i class="las la-money-bill"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="dashboard__item">
                                <div class="content">
                                    <span class="subtitle">@lang('Total Deposit')</span>
                                    <h4 class="title">{{$general->cur_sym}} {{getAmount($amount['deposit'])}}</h4>
                                </div>
                                <div class="thumb">
                                    <i class="las la-wallet"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="dashboard__item">
                                <div class="content">
                                    <span class="subtitle">@lang('Total Withdraw')</span>
                                    <h4 class="title">{{$general->cur_sym}} {{getAmount($amount['withdraw'])}}</h4>
                                </div>
                                <div class="thumb">
                                    <i class="las la-credit-card"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="dashboard__item">
                                <div class="content">
                                    <span class="subtitle">@lang('Total Transaction')</span>
                                    <h4 class="title">{{$transactionCount}}</h4>
                                </div>
                                <div class="thumb">
                                    <i class="las la-file-invoice-dollar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="dashboard__item">
                                <div class="content">
                                    <span class="subtitle">@lang('Total Products')</span>
                                    <h4 class="title">{{$product['all']}}</h4>
                                </div>
                                <div class="thumb">
                                    <i class="lab la-product-hunt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="dashboard__item">
                                <div class="content">
                                    <span class="subtitle">@lang('Total Sold Product')</span>
                                    <h4 class="title">{{$product['sold']}}</h4>
                                </div>
                                <div class="thumb">
                                    <i class="las la-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-60">
                        <h5 class="wish-title">@lang('Transaction Log')</h5>
                        <table class="table cmn--table">
                            <thead>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Transaction ID')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Post Balance')</th>
                                    <th>@lang('Detail')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td data-label="@lang('Date')">
                                            <div>
                                                {{showDateTime($transaction->created_at)}}<br>
                                                {{diffForHumans($transaction->created_at)}}
                                            </div>
                                        </td>
                                        <td data-label="@lang('Transaction ID')">
                                            {{$transaction->trx}}
                                        </td>
                                        <td data-label="@lang('Amount')">
                                            <strong
                                                @if($transaction->trx_type == '+')
                                                    class="text--success"
                                                @else
                                                    class="text--danger"
                                                @endif>
                                                {{($transaction->trx_type == '+') ? '+':'-'}} {{getAmount($transaction->amount)}} {{__($general->cur_text)}}
                                            </strong>
                                        </td>

                                        <td data-label="@lang('Post Balance')">
                                            <div>
                                                {{getAmount($transaction->post_balance)}} {{$general->cur_text}}
                                            </div>
                                        </td>

                                        <td data-label="Detail">
                                            <div>
                                                {{__($transaction->details)}}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{$emptyMessage}}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
