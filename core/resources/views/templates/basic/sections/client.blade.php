@php 
    $client = getContent('client.content', true);
    $clients = getContent('client.element', false);
@endphp  
<section class="client-section pt-120 pb-120">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <img src="{{getImage('assets/images/frontend/client/'. @$client->data_values->client_image, '600x600')}}" class="client--thumb" alt="@lang('client')">
            </div>
            <div class="col-lg-7">
                <div class="client-slider owl-theme owl-carousel">
                    @foreach($clients as $value)
                        <div class="client-item">
                            <blockquote>
                                 {{__($value->data_values->testimonial)}}
                            </blockquote>
                            <h6 class="text--base">
                                {{__($value->data_values->name)}}
                            </h6>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
