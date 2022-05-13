@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-4 col-md-4 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Product Image')</h5>
                    <div class="p-3 bg--white text-center">
                        <img src="{{ getImage(imagePath()['product']['path'].'/'.$product->image,imagePath()['product']['size'])}}" alt="@lang('Image')" class="b-radius--8 product-image d-inline-block" >
                    </div>

                    <h5 class="mb-20 text-muted">@lang('Title') </h5>
                    <span class="mb-10 text-muted">{{__($product->title)}}</span>
                    <h5 class="mb-20 text-muted mt-3">@lang('Sub Title')</h5>
                    <span class="mb-10 text-muted">{{__($product->sub_title)}}</span>
                    <h5 class="mb-20 text-muted mt-3">@lang('Product Specification')</h5>
                    <ul class="list-group">
                        @foreach($product->productSpecification as $specifi)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{__($specifi->specification->name)}}
                                <span class="font-weight-bold">{{$specifi->value}}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="card-title border-bottom pb-2">@lang('Product Information')</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Brand')
                            <span class="font-weight-bold">{{__($product->brand->name)}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Category')
                            <span class="font-weight-bold">{{__($product->category->name)}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Sub Category')
                            <span class="font-weight-bold">{{__($product->subCategory->name)}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Amount')
                            <span class="font-weight-bold">{{getAmount($product->amount)}} {{$general->cur_text}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Time Duration')
                            <span class="font-weight-bold">{{showDateTime($product->time_duration, 'd M Y')}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @if($product->status == 0)
                                <span class="badge badge--primary">@lang('Pending')</span>
                            @elseif($product->status == 1)
                                <span class="badge badge--success">@lang('Approved')</span>
                            @elseif($product->status == 2)
                                <span class="badge badge--danger">@lang('Cancel')</span>
                            @elseif($product->status == 3)
                                 <span class="badge badge--danger">@lang('Cancel')</span>
                            @endif
                        </li>
                    </ul>
                    <h6 class="mt-4">Product Description</h6>
                    <div class="mt-3">
                        @php echo $product->description @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('style')
<style>
    .product-image {
        width: 100%;
        height: 260px;
        object-fit: cover;
        object-position: center;
    }
</style>
@endpush