@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $contact = getContent('contact_us.content', true);
@endphp
<section class="contact-section pt-120 pb-120">
    <div class="container">
        <div class="account-wrapper shadow-none">
            <div class="row g-0">
                <div class="col-lg-6 left-side">
                    <div class="account-header">
                        <span class="text--base d-block mb-4">@lang('Contact Us')</span>
                        <h3 class="title">{{__($contact->data_values->title)}}</h3>
                        <p>
                            {{__($contact->data_values->short_details)}}
                        </p>
                    </div>
                    <form class="account-form" method="POST" action="">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form--label">@lang('Name')</label>
                            <input type="text" id="name" class="form-control form--control" value="@if(auth()->user()) {{ auth()->user()->fullname }} @else {{ old('name') }} @endif" @if(auth()->user()) readonly @endif name="name" required="">
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form--label">@lang('Email Address')</label>
                            <input type="email" id="email" class="form-control form--control" value="@if(auth()->user()) {{ auth()->user()->email }} @else {{ old('email') }} @endif" @if(auth()->user()) readonly @endif name="email" required="">
                        </div>

                         <div class="form-group">
                            <label for="subject" class="form--label">@lang('Subject')</label>
                            <input type="text" id="subject" class="form-control form--control" name="subject" required="">
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form--label">@lang('Messages')</label>
                            <textarea name="message" class="form-control form--control" id="message" required=""></textarea>
                        </div>
                        <div class="mt-4">
                            <button class="cmn--btn" type="submit">@lang('Send Message')</button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-6 right-side d-flex flex-wrap align-items-center">
                    <div class="w-100">
                        <div class="account-header">
                            <span class="text--base d-block mb-4">@lang('Contact Info')</span>
                            <h3 class="title mb-0">@lang('Contact Details')</h3>
                        </div>
                        <div class="contact__info-item">
                            <h6 class="title">@lang('Office Address')</h6>
                            <ul>
                                <li>
                                    <i class="las la-map-marker"></i> {{__($contact->data_values->contact_details)}}
                                </li>
                            </ul>
                        </div>
                        <div class="contact__info-item">
                            <h6 class="title">@lang('Email Adress')</h6>
                            <ul>
                                <li>
                                    <a href="mailto:{{__($contact->data_values->email_address)}}"><i class="las la-envelope-open-text"></i> {{__($contact->data_values->email_address)}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="contact__info-item">
                            <h6 class="title">@lang('Phone Number')</h6>
                            <ul>
                                <li>
                                    <a href="tel:{{__($contact->data_values->contact_number)}}"><i class="las la-phone-volume"></i>{{__($contact->data_values->contact_number)}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <div class="maps"></div>
        </div>
    </div>
</section>
@endsection


@push('script-lib')
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCo_pcAdFNbTDCAvMwAD19oRTuEmb9M50c"></script>
@endpush

@push('script')
    <script>
    "use strict";    
    var styleArray = [{
        "featureType": "all",
        "elementType": "geometry",
        "stylers": [{
          "color": "#202c3e"
        }]
      },
      {
        "featureType": "all",
        "elementType": "labels.text.fill",
        "stylers": [{
            "gamma": 0.01
          },
          {
            "lightness": 20
          },
          {
            "weight": "1.39"
          },
          {
            "color": "#ffffff"
          }
        ]
      },
      {
        "featureType": "all",
        "elementType": "labels.text.stroke",
        "stylers": [{
            "weight": "0.96"
          },
          {
            "saturation": "9"
          },
          {
            "visibility": "on"
          },
          {
            "color": "#000000"
          }
        ]
      },
      {
        "featureType": "all",
        "elementType": "labels.icon",
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [{
            "lightness": 30
          },
          {
            "saturation": "9"
          },
          {
            "color": "#29446b"
          }
        ]
      },
      {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [{
          "saturation": 20
        }]
      },
      {
        "featureType": "poi.park",
        "elementType": "geometry",
        "stylers": [{
            "lightness": 20
          },
          {
            "saturation": -20
          }
        ]
      },
      {
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [{
            "lightness": 10
          },
          {
            "saturation": -30
          }
        ]
      },
      {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#193a55"
        }]
      },
      {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [{
            "saturation": 25
          },
          {
            "lightness": 25
          },
          {
            "weight": "0.01"
          }
        ]
      },
      {
        "featureType": "water",
        "elementType": "all",
        "stylers": [{
          "lightness": -20
        }]
      }
    ]

    var mapOptions = {
        center: new google.maps.LatLng({{__($contact->data_values->latitude)}}, {{__($contact->data_values->longitude)}}),
        zoom: 10,
        styles: styleArray,
        scrollwheel: false,
        backgroundColor: '#e5ecff',
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementsByClassName("maps")[0],
      mapOptions);
    var myLatlng = new google.maps.LatLng({{__($contact->data_values->latitude)}}, {{__($contact->data_values->longitude)}});
    var focusplace = {lat: 55.864237, lng: -4.251806};
    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        icon: {
            url: "assets/images/map-marker.png"
        }
    })
</script>
@endpush