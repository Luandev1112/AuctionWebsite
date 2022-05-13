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
                        <div class="card card-deposit custom--card">
                            <div class="card-body">
                                <div class="card-body card-body-deposit text-center">
                                    <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount }}</span> {{__($data->currency)}}</h4>
                                    <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
                                    <img src="{{$data->img}}" alt="@lang('Image')">
                                    <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
