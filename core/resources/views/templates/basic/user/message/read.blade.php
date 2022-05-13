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
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card custom--card">
                                <div class="card-body">
                                    @forelse($reads as $read)
                                        <div class="row border @if($loop->even) border-primary @else border-warning @endif rounded my-3 py-3 mx-2">
                                            <div class="col-md-9">
                                                <p class="text-white font-weight-bold my-3">
                                                    @lang('Posted on') {{ $read->created_at->format('l, dS F Y') }}</p>
                                                <p>{{$read->message}}</p>
                                            </div>
                                        </div>
                                    @empty
                                    	<div class="text-center">{{$emptyMessage}}</div>
                                    @endforelse
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