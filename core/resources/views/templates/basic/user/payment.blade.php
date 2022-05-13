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
                    @foreach($gatewayCurrency as $data)
                            <div class="col-sm-6 col-md-4 col-xl-3">
                                <div class="card custom--card deposit-card">
                                    <div class="card-header text-center">
                                        <h6 class="title m-0">{{__($data->name)}}</h6>
                                    </div>
                                    <img src="{{$data->methodImage()}}" alt="@lang('deposit')">
                                    <div class="card-body text-center">
                                        <form action="{{route('user.order.payment.insert')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="order_number" value="{{session()->get('order_number')}}">
                                            <input type="hidden" name="currency" value="{{$data->currency}}">
                                            <input type="hidden" name="method_code" value="{{$data->method_code}}">
                                            <button type="submit" class="btn btn--base">@lang('Payment Now')</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
