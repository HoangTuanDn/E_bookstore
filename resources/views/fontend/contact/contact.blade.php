@extends('layouts.master')

@section('js')
    <script src="{{asset('fontend/common/sendMessage.js')}}"></script>
@endsection

@section('content')
<div class="ht__bradcaump__area bg-image--6">
    @include('fontend.breadcumb',['pageNameLC' => __('contact_l')])
</div>
<!-- End Bradcaump area -->
<!-- Start Contact Area -->
<section class="wn_contact_area bg--white pt--80 pb--80">
    <div class="google__map pb--80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="googleMap"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="contact-form-wrap">
                    <h2 class="contact__title">{{__('get_in_touch')}}</h2>
                    <p>{{__('get_in_touch_detail')}}</p>
                    <form id="contact-form" action="{{route('home.concat.send', ['language'=> app()->getLocale()])}}" method="post">
                        <div class="single-contact-form space-between">
                            <input type="text" name="name" placeholder="{{__('name') .'*'}}">
                        </div>
                        <div class="single-contact-form space-between">
                            <input type="email" name="email" placeholder="Email*">

                        </div>
                        <div class="single-contact-form">
                            <input type="text" name="subject" placeholder="{{__('subject') . '*'}}">
                        </div>
                        <div class="single-contact-form message">
                            <textarea name="message" placeholder="{{__('type_your_message_here') . '...'}}"></textarea>
                        </div>
                        <div class="contact-btn">
                            <button data-action="send-message">{{__('send_email')}}</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-lg-4 col-12 md-mt-40 sm-mt-40">
                <div class="wn__address">
                    <h2 class="contact__title">{{__('get_office_info')}}</h2>
                    <p>{{__('get_office_info_detail')}}</p>
                    <div class="wn__addres__wreapper">

                        <div class="single__address">
                            <i class="icon-location-pin icons"></i>
                            <div class="content">
                                <span>{{__('address')}}:</span>
                                <p>{{$data['address_1']}}</p>
                                <p>{{$data['address_2']}}</p>
                            </div>
                        </div>

                        <div class="single__address">
                            <i class="icon-phone icons"></i>
                            <div class="content">
                                <span>{{__('phone')}}:</span>
                                <p>{{$data['phone']}}</p>
                            </div>
                        </div>

                        <div class="single__address">
                            <i class="icon-envelope icons"></i>
                            <div class="content">
                                <span>{{__('email')}}:</span>
                                <p>{{$data['email']}}</p>
                            </div>
                        </div>

                        <div class="single__address">
                            <i class="icon-globe icons"></i>
                            <div class="content">
                                <span>{{__('website_address')}}:</span>
                                <p>{{$data['website_address']}}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZqULsOb2GC4WTYiBjC0Lh3VFrOvJxIEE&callback=myMap" > </script>
<script>
    google.maps.event.addDomListener(window, 'load', init);

    function init() {
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: 12,

            scrollwheel: false,

            // The latitude and longitude to center the map (always required)
            center: new google.maps.LatLng(21.037750060042892, 105.7738251393719),
            styles:
                [

                    {
                        "featureType": "administrative",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#444444"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#f2f2f2"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "all",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 45
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "transit.station.bus",
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "saturation": "-16"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#04b7ff"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    }
                ]
        };

        var mapElement = document.getElementById('googleMap');

        // Create the Google Map using our element and options defined above
        var map = new google.maps.Map(mapElement, mapOptions);

        // Let's also add a marker while we're at it
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(21.037750060042892, 105.7738251393719),
            map: map,
            title: 'Dcare!',
            icon: 'images/icons/map.png',
            animation:google.maps.Animation.BOUNCE

        });
    }
</script>
<!-- End Contact Area -->
@endsection