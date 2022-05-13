@php 
    $counter = getContent('counter.content', true);
    $counters = getContent('counter.element', false);
@endphp
  
<section class="counter-section pt-120 pb-120 bg--section">
    <div class="container">
        <div class="section__header-center">
            <span class="cate">{{__($counter->data_values->title)}}</span>
            <h3 class="title">
                {{__($counter->data_values->heading)}}
            </h3>
            <p>
                {{__($counter->data_values->sub_heading)}}
            </p>
        </div>
        <div class="row justify-content-center g-4">
            @foreach($counters as $value)
                <div class="col-lg-3 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__icon">
                            @php echo $value->data_values->counter_icon @endphp
                        </div>
                        <div class="counter__content">
                            <div class="d-flex flex-wrap">
                                <h4 class="title rafcounter" data-counter-end="{{$value->data_values->counter_digit}}">0</h4>
                            </div>
                            <h5 class="subtitle">{{$value->data_values->title}}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

