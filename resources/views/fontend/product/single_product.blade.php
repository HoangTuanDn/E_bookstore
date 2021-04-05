@extends('layouts.master')

@section('js')
    <script src="{{asset('fontend/common/single.js')}}"></script>
    <script src="{{asset('fontend/common/cart.js')}}"></script>
@endsection

@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Shop Single</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="index.html">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Shop Single</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- Start main Content -->
    <div class="maincontent bg--white pt--80 pb--55">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12">

                    {!! $inc_list !!}

                    <div class="wn__related__product pt--80 pb--50">
                        <div class="section__title text-center">
                            <h2 class="title__be--2">{{__('related_products')}}</h2>
                        </div>
                        <div class="row mt--60">
                            <div class="productcategory__slide--2 arrows_style owl-carousel owl-theme">
                                <!-- Start Single Product -->
                                @foreach($relatedProducts as $product)
                                    <div class="product product__style--3 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="product__thumb">
                                            <a class="first__img" href="{{route('home.shop.single_product', ['slug'=>$product->slug])}}"><img src="{{$product->featured_img}}" alt="product image"></a>
                                            @if($product['type'] == __('best'))
                                                <div class="hot__box">
                                                    <span class="hot-label">{{__('best')}}</span>
                                                </div>
                                            @elseif($product['type'] == __('hot'))
                                                <div class="hot__box">
                                                    <span class="hot-label">{{__('hot')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product__content content--center">
                                            <h4><a href="{{route('home.shop.single_product', ['slug'=>$product->slug])}}">{{$product->name}}</a></h4>
                                            <ul class="prize d-flex">
                                                <li>{!! number_format($product->discount, 0, ',', '.') . __('currency_unit') !!}</li>
                                                <li class="old_prize">{!! number_format($product->price , 0, ',', '.').  __('currency_unit') !!}</li>
                                            </ul>
                                            <div class="action">
                                                <div class="actions_inner" data-url="{{route('home.shop.single_product',['slug' => $product['slug']])}}" data-image="{{$product['featured_img']}}" data-author="{{$product['author']}}" data-discount="{!! number_format($product['discount'], 0, ',', '.') . __('currency_unit') !!}" data-title="{{$product['title']}}" data-price="{!! number_format($product['price'], 0, ',', '.').  __('currency_unit') !!}"  data-name="{{$product['name']}}" data-id="{{$product['id']}}" >
                                                    <ul class="add_to_links">
                                                        <li><a class="cart" href="{{route('home.checkout')}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                                        <li><a class="wishlist" data-name="{{$product['name']}}" data-id="{{$product['id']}}" data-action="add_to_cart"  href="{{route('home.cart.store')}}"><i class="bi bi-shopping-cart-full"></i></a></li>
                                                        <li><a class="compare"  data-action="add_to_wishlist" data-exist="{{__('exist_in_wishlist',['name' => $product['name']])}}" data-add="{{__('add_to_wishlist',['name' => $product['name']])}}" href="{{route('home.wish_list')}}"><i class="bi bi-heart-beat"></i></a></li>
                                                        <li><a data-toggle="modal" data-action="quick_view" data-url="{{route('home.cart.store')}}" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"><i class="bi bi-search"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__hover--content">
                                                <ul class="rating d-flex">
                                                    <li class="on"><i class="fa fa-star-o"></i></li>
                                                    <li class="on"><i class="fa fa-star-o"></i></li>
                                                    <li class="on"><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Start Single Product -->
                            </div>
                        </div>
                    </div>
                    <div class="wn__related__product">
                        <div class="section__title text-center">
                            <h2 class="title__be--2">{{__('upsell_products')}}</h2>
                        </div>
                        <div class="row mt--60">
                            <div class="productcategory__slide--2 arrows_style owl-carousel owl-theme">
                                @foreach($upsellProducts as $product)
                                    <div class="product product__style--3 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="product__thumb">
                                            <a class="first__img" href="{{route('home.shop.single_product', ['slug'=>$product->slug])}}"><img src="{{$product->featured_img}}" alt="product image"></a>
                                            @if($product['type'] == __('best'))
                                                <div class="hot__box">
                                                    <span class="hot-label">{{__('best')}}</span>
                                                </div>
                                            @elseif($product['type'] == __('hot'))
                                                <div class="hot__box">
                                                    <span class="hot-label">{{__('hot')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product__content content--center">
                                            <h4><a href="{{route('home.shop.single_product', ['slug'=>$product->slug])}}">{{$product->name}}</a></h4>
                                            <ul class="prize d-flex">
                                                <li>{!! number_format($product->discount, 0, ',', '.') . __('currency_unit') !!}</li>
                                                <li class="old_prize">{!! number_format($product->price, 0, ',', '.' ).  __('currency_unit') !!}</li>
                                            </ul>
                                            <div class="action">
                                                <div class="actions_inner" data-url="{{route('home.shop.single_product',['slug' => $product['slug']])}}" data-image="{{$product['featured_img']}}" data-author="{{$product['author']}}" data-discount="{!! number_format($product['discount'], 0, ',', '.') . __('currency_unit') !!}" data-title="{{$product['title']}}" data-price="{!! number_format($product['price'], 0, ',', '.').  __('currency_unit') !!}"  data-name="{{$product['name']}}" data-id="{{$product['id']}}" >
                                                    <ul class="add_to_links">
                                                        <li><a class="cart" href="{{route('home.checkout')}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                                        <li><a class="wishlist" data-name="{{$product['name']}}" data-id="{{$product['id']}}" data-action="add_to_cart"  href="{{route('home.cart.store')}}"><i class="bi bi-shopping-cart-full"></i></a></li>
                                                        <li><a class="compare"  data-action="add_to_wishlist" data-exist="{{__('exist_in_wishlist',['name' => $product['name']])}}" data-add="{{__('add_to_wishlist',['name' => $product['name']])}}" href="{{route('home.wish_list')}}"><i class="bi bi-heart-beat"></i></a></li>
                                                        <li><a data-toggle="modal" data-action="quick_view" data-url="{{route('home.cart.store')}}" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"><i class="bi bi-search"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__hover--content">
                                                <ul class="rating d-flex">
                                                    <li class="on"><i class="fa fa-star-o"></i></li>
                                                    <li class="on"><i class="fa fa-star-o"></i></li>
                                                    <li class="on"><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                    <div class="shop__sidebar">
                        <aside class="wedget__categories poroduct--cat">
                            <h3 class="wedget__title">{{__('product_categories')}}</h3>
                            <ul>
                                @foreach($categories as $category)
                                    <li ><a data-action="btnFilterCategory" href="{{route('home.shop', ['category' => $category->slug])}}" data-value="{{$category->slug}}">{{$category->name}}<span>({{$category->products->count()}})</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </aside>
                        <aside class="wedget__categories pro--range">
                            <h3 class="wedget__title">{{__('filter_by_price')}}</h3>
                            <div class="content-shopby">
                                <div class="price_filter s-filter clear">
                                    <form action="{{route('home.shop')}}" method="GET">
                                        <div id="slider-range"></div>
                                        <div class="slider__range--output">
                                            <div class="price__output--wrap filter_price">
                                                <div class="price--output">
                                                    <span>{{__('price')}} :</span><input  type="text" name="price" id="amount" >
                                                </div>
                                                <div class="price--filter">
                                                    <a data-action="btnFilterPrice" href="{{route('home.shop')}}">{{__('filter')}}</a>
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
                                    <li ><a href="{{route('home.shop', ['tag' => $tag->slug])}}"  data-action="btnFilterTag" >{{$tag->name}}</a></li>
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
            </div>
        </div>
    </div>
    <!-- End main Content -->
    <!-- Start Search Popup -->
    <div class="box-search-content search_active block-bg close__top">
        <form id="search_mini_form--2" class="minisearch" action="#">
            <div class="field__search">
                <input type="text" placeholder="Search entire store here...">
                <div class="action">
                    <a href="#"><i class="zmdi zmdi-search"></i></a>
                </div>
            </div>
        </form>
        <div class="close__wrap">
            <span>close</span>
        </div>
    </div>
    <!-- End Search Popup -->
    {{--quick view--}}
    @include('fontend.quick_view')
@endsection
