@php 
    $partner = getContent('partner.content', true);
    $partners = getContent('partner.element', false);
@endphp  
<div class="partner-section pt-120 pb-120">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <div class="sponsor-content">
                    <div class="section__header-center ms-0 text-start">
                        <span class="cate">{{__($partner->data_values->title)}}</span>
                        <h3 class="title">{{__($partner->data_values->heading)}}</h3>
                        <p>
                           {{__($partner->data_values->sub_heading)}}
                        </p>
                    </div>
                    <ul class="partner--list">
                        @php
                            echo $partner->data_values->description
                        @endphp
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sponsor-wrapper">
                    @foreach($partners as $value)
                        <div class="sponsor-thumb">
                            <img src="{{getImage('assets/images/frontend/partner/'. @$value->data_values->patrner_image, '300x49')}}" alt="@lang('sponsor')">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
