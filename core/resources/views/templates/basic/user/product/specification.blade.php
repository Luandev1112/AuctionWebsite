@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="dashboard-section pt-60 pb-60">
    <div class="container">
        <div class="pt-60 pb-60">
            <div class="row gy-5">
                <div class="col-xl-3">
                    @include($activeTemplate . 'partials.sidebar')
                </div>
                <div class="col-xl-9">
                    <div class="mb-4 d-xl-none text-end">
                        <div class="sidebar__init">
                            <i class="las la-columns"></i>
                        </div>
                    </div>
                    <div class="card custom--card">
                    	<div class="card-body">
	                        <form action="{{route('user.store.product.specification', $product->id)}}"  method="post" enctype="multipart/form-data">
	                            @csrf
	                            <div class="row">
	                            	@foreach($product->category->specification as $specification)
			                            <div class="col-md-6 mb-20">
			                                <label for="title" class="form--label mb-2">{{__($specification->name)}} <sup class="text--danger">*</sup></label>
			                                <input class="form-control form--control-2 bg--body" id="title" type="text" maxlength="255" name="{{$specification->slug}}" value="{{@$specification->productSpecification->value}}" placeholder="@lang('Enter') {{__($specification->name)}}" required="">
			                            </div>
			                        @endforeach
		                        </div>

	                            <div class="col-lg-12 text-end">
	                                <button type="submit" class="cmn--btn"> 
	                                	@if($product->productSpecification->isEmpty())
                             				@lang('Add')
                                        @else
                                            @lang('Update')
                                        @endif
                                        	@lang(' Product Specification')
                                    </button>
	                            </div>
	                        </form>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
