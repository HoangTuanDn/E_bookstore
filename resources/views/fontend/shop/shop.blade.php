@extends('layouts.master')

@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Shop Grid</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="index.html">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Shop Grid</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- Start Shop Page -->
    <div class="page-shop-sidebar left--sidebar bg--white section-padding--lg">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 order-2 order-lg-1 md-mt-40 sm-mt-40">
                    <div class="shop__sidebar">
                        <aside class="wedget__categories poroduct--cat">
                            <h3 class="wedget__title">{{__('product_categories')}}</h3>
                            <ul>
                                @foreach($categories as $category)
                                    <li ><a data-action="btnFilterCategory" href="{{route('home.shop', ['language'=>app()->getLocale(), 'category' => $category->slug])}}" data-value="{{$category->slug}}">{{app()->getLocale() === 'en' ? $categoryTranslate[$category->name] : $category->name}}<span>({{$category->products()->count()}})</span></a>
                                    </li>
                                @endforeach

                            </ul>
                        </aside>
                        <aside class="wedget__categories pro--range">
                            <h3 class="wedget__title">{{__('filter_by_price')}}</h3>
                            <div class="content-shopby">
                                <div class="price_filter s-filter clear">
                                    <form action="{{route('home.shop', ['language' => app()->getLocale()])}}" method="GET">
                                        <div id="slider-range"></div>
                                        <div class="slider__range--output">
                                            <div class="price__output--wrap filter_price">
                                                <div class="price--output">
                                                    <span>{{__('price')}} :</span><input type="text" name="price" id="amount" >
                                                </div>
                                                <div class="price--filter">
                                                    <a data-action="btnFilterPrice" href="{{route('home.shop', ['language' => app()->getLocale()])}}">{{__('filter')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </aside>
                        <aside class="wedget__categories poroduct--tag">
                            <h3 class="wedget__title">{{__('product_tags')}}</h3>
                            <ul>
                                @foreach($tags as $tag)
                                    <li ><a href="{{route('home.shop', ['language'=>app()->getLocale(), 'tag' => $tag->slug])}}"  data-action="btnFilterTag" >{{$tag->name}}</a></li>
                                @endforeach
                            </ul>
                        </aside>
                        <aside class="wedget__categories sidebar--banner">
                            <img src="{{asset('fontend/images/others/banner_left.jpg')}}" alt="banner images">
                            <div class="text">
                                <h2>new products</h2>
                                <h6>save up to <br> <strong>40%</strong>off</h6>
                            </div>
                        </aside>
                    </div>
                </div>
                <div class="col-lg-9 col-12 order-1 order-lg-2 product_wrapper">
                    {!! $inc_list !!}
                </div>
            </div>

        </div>
    </div>
    <!-- End Shop Page -->
{{--    quick view--}}
    @include('fontend.quick_view')
@endsection

@section('js')
    <script src="{{asset('fontend/common/shop.js')}}"></script>
@endsection