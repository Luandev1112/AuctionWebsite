@php 
    $howToWork = getContent('how_to_work.content', true);
    $howToWorks = getContent('how_to_work.element', false, 3, true);
@endphp  
<section class="how-section pt-120 pb-120 bg--section">
    <div class="container">
        <div class="section__header-center">
            <h3 class="title">{{__($howToWork->data_values->heading)}}</h3>
            <p>
                {{__($howToWork->data_values->sub_heading)}}
            </p>
        </div>
        <div class="how__wrapper pt-md-4">
            @foreach($howToWorks as $value)
                <div class="how__item">
                    <div class="how__icon">
                        @php echo $value->data_values->work_icon @endphp
                    </div>
                    <h6 class="title text--base">{{__($value->data_values->title)}}</h6>
                    <p>
                        {{__($value->data_values->sub_title)}}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>