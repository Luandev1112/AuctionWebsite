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
                    <div class="card custom--card h-auto">
                    	<div class="card-body">
	                        <form action="{{route('user.product.update', $product->id)}}"  method="post" enctype="multipart/form-data">
	                            @csrf
	                            <div class="row">
		                            <div class="col-md-12 mb-20">
		                                <label for="title" class="form--label mb-2">@lang('Title') <sup class="text--danger">*</sup></label>
		                                <input class="form-control form--control-2 bg--body" id="title" type="text" maxlength="255" name="title" value="{{$product->title}}" placeholder="@lang('Enter Title')" required="">
		                            </div>
		                           
		                            <div class="col-md-12 mb-20">
		                                <label for="sub_title" class="form--label mb-2">@lang('Sub Title') <sup class="text--danger">*</sup></label>
		                                <input class="form-control form--control-2 bg--body" id="sub_title" type="text" maxlength="255" name="sub_title" value="{{$product->sub_title}}" placeholder="@lang('Enter Sub Title')" required="">
		                            </div>
		                        </div>

		                        <div class="row">
		                        	<div class="col-md-6 mb-20">
		                                <label for="category" class="form--label mb-2">@lang('Select Category') <sup class="text--danger">*</sup></label>
		                                <select class="form-control  form--control-2 bg--body" name="category_id" id="category" required="">
		                                	<option value="">@lang('Select One')</option>
		                                	@foreach($categories as $category)
		                                		<option value="{{$category->id}}" data-subcategory="{{json_encode($category->subCategory)}}" @if($product->category_id == $category->id) selected @endif >{{__($category->name)}}</option>
		                                	@endforeach
		                                </select>
		                            </div>

		                            <div class="col-md-6 mb-20">
		                                <label for="sub_category" class="form--label mb-2">@lang('Select Sub Category') <sup class="text--danger">*</sup></label>
		                                <select class="form-control  form--control-2 bg--body" name="sub_category" id="sub_category" required="">
		                                	<option value="">@lang('Select One')</option>
		                                </select>
		                            </div>
		                        </div>

		                        <div class="row">

		                        	<div class="col-md-6 mb-20">
		                                <label for="brand" class="form--label mb-2">@lang('Select Brand') <sup class="text--danger">*</sup></label>
		                                <select class="form-control  form--control-2 bg--body" name="brand" id="brand" required="">
		                                	<option value="">@lang('Select One')</option>
		                                	@foreach($brands as $brand)
		                                		<option value="{{$brand->id}}" @if($product->brand_id == $brand->id) selected @endif>{{__($brand->name)}}</option>
		                                	@endforeach
		                                </select>
		                            </div>


		                            <div class="col-md-6 mb-20">
		                                <label for="amounts" class="form--label mb-2">@lang('Amount') <sup class="text--danger">*</sup></label>
		                               	<div class="input-group mb-3">
		  									<input type="text" class="form-control form--control-2 bg--body" id="amounts" value="{{getAmount($product->amount)}}" name="amount" 
		  									 placeholder="@lang('Enter Amount')" aria-label="Recipient's username" aria-describedby="basic-addon2">
		  									<span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
										</div>
		                            </div>
		                        </div>

		                        <div class="row">
		                            <div class="col-md-6 mb-20">
		                                <label for="time_duration" class="form--label mb-2">@lang('Time Duration') <sup class="text--danger">*</sup></label>
		                                <input class="form-control form--control-2 bg--body" id="time_duration" type="date" name="time_duration" value="{{showDateTime($product->time_duration, 'Y-m-d')}}"  required="">
		                            </div>

		                            <div class="col-md-6 mb-20">
		                                <label for="file" class="form--label mb-2">@lang('Image') </label>
		                                <input class="form-control form--control-2 bg--body" type="file" id="file" name="image">
		                            </div>
		                        </div>

		                         <div class="row">
		                        	<div class="col-md-12 mb-20">
		                        		<div class="form-check">
											<input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" @if($product->featured) checked @endif>
											<label class="form-check-label" for="flexCheckDefault">
											   @lang('Feature Listing By featuring a listing you agree that an extra') {{getAmount($general->featured_price)}} {{$general->cur_text}} @lang('for items fee will be added to the final seller fee once the item is sold.')
											</label>
										</div>
		                        	</div>
		                        </div>


		                        <div class="row">
		                            <div class="col-md-12 mb-20">
		                                <label for="keyword" class="form--label mb-2">@lang('Key words') <sup class="text--danger">*</sup></label>
		                                <select class="form-control form--control-2 bg--body select2-auto-tokenize" name="keywords[]" multiple="multiple" type="text" id="keyword" name="keyword" required="">
		                                	@if($product->keyword)
		                                	  	@foreach($product->keyword as $name)
	                                                <option value="{{$name}}" selected="true">{{__($name)}}</option>
	                                            @endforeach
	                                        @endif
		                                </select>
		                            </div>
		                        </div>

		                        <div class="row">
		                        	<div class="col-md-12 mb-20">
			                        	<label for="description" class="form--label mb-2">@lang('Description') <sup class="text--danger">*</sup></label>
			                        	<textarea class="form-control form--control-2 bg--body nicEdit" name="description" id="description">
			                        		@php echo $product->description @endphp
			                        	</textarea>
			                        </div>
		                        </div>

	                            <div class="col-lg-12 text-end">
	                                <button type="submit" class="cmn--btn">@lang('Create Product')</button>
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

@push('style-lib')
    <link rel="stylesheet" href="{{asset('assets/global/css/select2.min.css')}}">
@endpush


@push('script-lib')
 	<script src="{{asset('assets/global/js/nicEdit.js')}}"></script>
 	<script src="{{asset('assets/global/js/select2.min.js')}}"></script>
@endpush

@push('script')
	<script>
		"use strict";
		bkLib.onDomLoaded(function() {
	        $( ".nicEdit" ).each(function( index ) {
	            $(this).attr("id","nicEditor"+index);
	            new nicEditor({fullPanel : true}).panelInstance('nicEditor'+index,{hasPanel : true});
	        });
	    });

	    $('.select2-auto-tokenize').select2({
            tags: true,
            tokenSeparators: [',']
        })

	    $('select[name=category_id]').on('change',function() {
            $('select[name=sub_category]').html('<option value="">@lang('Select One')</option>');
            var subcategory = $('select[name=category_id] :selected').data('subcategory');
            var html = '';
            subcategory.forEach(function myFunction(item, index) {
                if (item.id == {{$product->sub_category_id }}) {
                       html += `<option value="${item.id}" selected>${item.name}</option>`
                }else{
                    html += `<option value="${item.id}">${item.name}</option>`
                }
            });
            $('select[name=sub_category]').append(html);
        }).change();
	</script>
@endpush

@push('style')
<style>
	.select2-container--default .select2-selection--multiple {
		padding: 4px 5px 8px 5px;
		background-color: transparent;
		border:  1px solid rgba(255, 255, 255, 0.1) !important;
	}
	.select2-container--default .select2-results__option--selected {
		    background-color: #042444;
	}
	.select2-container--default .select2-search--inline .select2-search__field {
		color: #fff !important;
	}
	.select2-container--default .select2-selection--multiple .select2-selection__choice,
	.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
		background-color: #4400ff;
		color: #fff;
	}
	.select2-container--default .select2-selection--multiple .select2-selection__choice__remove,
	.select2-container--default .select2-selection--multiple .select2-selection__choice {
		color:  #fff;
	}
</style>
@endpush