@php
    $contact = getContent('contact_us.content', true);
@endphp
<div class="header-top py-2">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center justify-content-sm-between">
            <div class="d-flex flex-wrap">
                <div class="header-top-item ps-0">
                    <i class="las la-phone-volume"></i>
                    <a href="tel:{{__(@$contact->data_values->contact_number)}}"  class="text--white ms-1">{{__(@$contact->data_values->contact_number)}}</a>
                </div>
                <div class="header-top-item">
                    <i class="las la-envelope-open-text"></i>
                    <a href="mailto:{{__(@$contact->data_values->email_address)}}"  class="text--white ms-1">{{__(@$contact->data_values->email_address)}}</a>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center">
                <span class="title text--base me-1">1 @lang('BTC') = </span>
                <span class="text--white ms-1"> {{getAmount($general->btc_price)}} @lang('USD')</span>
            </div>
        </div>
    </div>
</div>

<div class="header-bottom">
    <div class="container">
        <div class="header-wrapper d-flex justify-content-between">
            <div class="logo">
                <a href="{{route('home')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')"></a>
            </div>
            <ul class="menu">
                <li>
                    <a href="{{route('home')}}">@lang('Home')</a>
                </li>
                @foreach($pages as $k => $data)
                    <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                @endforeach

                <li>
                    <a href="{{route('product')}}">@lang('Product')</a>
                </li>

                <li>
                    <a href="{{route('blog')}}">@lang('Blog')</a>
                </li>

                <li>
                    <a href="{{route('contact')}}">@lang('Contact')</a>
                </li>

                @guest
                    <li>
                        <a href="javascript:void(0)">@lang('Account')</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{route('user.login')}}">@lang('Sign In')</a>
                            </li>
                            <li>
                                <a href="{{route('user.register')}}">@lang('Sign Up')</a>
                            </li>
                        </ul>
                    </li>
                @endguest
                
                @auth
                    <li>
                        <a href="{{route('user.home')}}">@lang('Dashboard')</a>
                    </li>
                @endauth
            </ul>
            <select class="select-bar ms-auto ms-lg-3 langSel">
                @foreach($language as $item)
                    <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                @endforeach
            </select>
            <div class="header-bar ms-3">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</div>
