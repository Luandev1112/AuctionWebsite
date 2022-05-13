@php
    $socialIcons = getContent('social_icon.element', false);
    $policys = getContent('policy_pages.element', false);
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp

@if(@$cookie->data_values->status && !session('cookie_accepted'))
    <div class="cookie__wrapper ">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-between">
            <p class="txt my-2">
               @php echo @$cookie->data_values->description @endphp
              <a href="{{ @$cookie->data_values->link }}" target="_blank">@lang('Read Policy')</a>
            </p>
              <a href="javascript:void(0)" class="btn btn--base my-2 policy">@lang('Accept')</a>
          </div>
        </div>
    </div>
 @endif

<footer>
    <div class="container">
        <div class="footer-top">
            <div class="footer-top-btn">
                <a href="javascript:void(0)" class="more--btn">
                    + @lang('More') <span>@lang('Explore More')</span>
                </a>
            </div>
            <div class="footer-hidden-links">
                <div class="footer-wrapper">
                    @foreach($categories as $category)
                        <div class="footer__widget">
                            <h6 class="title"><a href="{{route('category.product', $category->id)}}" class="text--base">{{__($category->name)}}</a></h6>
                            <ul>
                                @foreach($category->subCategory as $subCategory)
                                    <li>
                                        <a href="{{route('subcategory.product', $subCategory->id)}}">{{__($subCategory->name)}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-bottom-wrapper">
                <div class="copyright">
                    &copy; {{Carbon\Carbon::now()->format('Y')}} @lang('All Right Reserved by') <a href="{{route('home')}}" class="text--base">{{__($general->sitename)}}</a>
                </div>
                <ul class="privacy--menu">
                    @foreach($policys as $policy)
                        <li>
                            <a href="{{route('footer.menu', [slug($policy->data_values->title), $policy->id])}}">{{__($policy->data_values->title)}}</a>
                        </li>
                    @endforeach

                </ul>
                <ul class="social-icons">
                    @foreach($socialIcons as $socialIcon)
                        <li><a href="{{$socialIcon->data_values->url}}" target="_blank">@php echo $socialIcon->data_values->social_icon @endphp</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>



@push('script')
<script>
    'use strict';
    $('.policy').on('click',function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.get('{{route('cookie.accept')}}', function(response){
            $('.cookie__wrapper').addClass('d-none');
            iziToast.success({message: response, position: "topRight"});
        });
    });
</script>
@endpush


 
