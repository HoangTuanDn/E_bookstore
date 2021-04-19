@extends('layouts.master')

@section('js')
    <script src="{{asset('fontend/common/shop.js')}}"></script>
@endsection

@section('content')
    <!-- Start Slider area -->
    <div class="slider-area brown__nav slider--15 slide__activation slide__arrow01 owl-carousel owl-theme">
        <!-- Start Single Slide -->
        <div class="slide animation__style10 bg-image--1 fullscreen align__center--left">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="slider__content">
                            <div class="contentbox">
                                {!! __('banner_header') !!}
                                <a class="shopbtn" href="{{route('home.shop', ['language' => app()->getLocale()])}}">{{__('go_shop')}}</a>
                                @if($isHomePage)
                                    <input type="hidden" value="oth-page">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->
        <!-- Start Single Slide -->
        <div class="slide animation__style10 bg-image--7 fullscreen align__center--left">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="slider__content">
                            <div class="contentbox">
                                {!! __('banner_header') !!}
                                <a class="shopbtn" href="{{route('home.shop', ['language' => app()->getLocale()])}}">{{__('go_shop')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->
    </div>
    <!-- End Slider area -->
    <!-- Start BEst Seller Area -->
    <section class="wn__product__area brown--color pt--80  pb--30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section__title text-center">
                        <h2 class="title__be--2">{!! __('new_product_header') !!}</h2>
                        <p>{!!__('new_product_detail')!!}</p>
                    </div>
                </div>
            </div>
            <!-- Start Single Tab Content -->
            <div class="furniture--4 border--round arrows_style owl-carousel owl-theme row mt--50">
                <!-- Start Single Product -->
                @foreach($newProduct as $product)
                    <div class="product product__style--3">
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product__thumb">
                                <a class="first__img" href="{{route('home.shop.single_product', ['language' => app()->getLocale(), 'slug'=>$product->slug])}}"><img src="{{$product->featured_img}}" alt="product image"></a>
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
                                <h4><a href="{{route('home.shop.single_product',  ['language' => app()->getLocale(), 'slug'=>$product->slug])}}">{{$product->name}}</a></h4>
                                <ul class="prize d-flex">
                                    <li>{!! number_format($product->discount, 0, ',', '.') . __('currency_unit') !!}</li>
                                    <li class="old_prize">{!! number_format($product->price, 0, ',', '.').  __('currency_unit') !!}</li>
                                </ul>
                                <div class="action">
                                    <div class="actions_inner" data-review="{{__('reviews_count', ['number' => $product->customerReviews()->count()])}}" data-url="{{route('home.shop.single_product', ['language' => app()->getLocale(), 'slug' => $product['slug']])}}" data-image="{{$product['featured_img']}}" data-author="{{$product['author']}}" data-discount="{!! number_format($product['discount'], 0, ',', '.') . __('currency_unit') !!}" data-title="{{$product['title']}}" data-price="{!! number_format($product['price'], 0, ',', '.').  __('currency_unit') !!}"  data-name="{{$product['name']}}" data-id="{{$product['id']}}">
                                        <ul class="add_to_links">
                                            <li><a class="cart" data-action="checkout-single" href="{{route('home.checkout', ['language' => app()->getLocale(), 'slug'=>$product['slug']])}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                            <li><a class="wishlist" data-name="{{$product['name']}}" data-id="{{$product['id']}}" data-action="add_to_cart"  href="{{route('home.cart.store', ['language' => app()->getLocale()])}}"><i class="bi bi-shopping-cart-full"></i></a></li>
                                            <li><a class="compare"  data-action="add_to_wishlist" data-exist="{{__('exist_in_wishlist',['name' => $product['name']])}}" data-add="{{__('add_to_wishlist',['name' => $product['name']])}}" href="{{route('home.wish_list', ['language' => app()->getLocale()])}}"><i class="bi bi-heart-beat"></i></a></li>
                                            <li><a data-toggle="modal" data-action="quick_view" data-url="{{route('home.cart.store', ['language' => app()->getLocale()])}}" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"><i class="bi bi-search"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product__hover--content">
                                    <ul class="rating d-flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($product->getRate($product->id) == 0)
                                                <li><i class="fa fa-star-o"></i></li>
                                            @elseif($product->getRate($product->id) > 0 && $i <= $product->getRate($product->id))
                                                <li class="on"><i class="fa fa-star-o"></i></li>
                                            @else
                                                <li><i class="fa fa-star-o"></i></li>
                                            @endif
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- End Single Tab Content -->
        </div>
    </section>
    <!-- Start BEst Seller Area -->
    <!-- Start NEwsletter Area -->
    <section class="wn__newsletter__area bg-image--2">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-5 col-md-12 col-12 ptb--150">
                    <div class="section__title text-center">
                        <h2>{{__('stay_with_us')}}</h2>
                    </div>
                    <div class="newsletter__block text-center">
                        <p>{{__('stay_with_us_detail')}}</p>
                        <form action="{{route('home.register_email', ['language' => app()->getLocale()])}}">
                            <div class="newsletter__box">
                                <input type="email" name="email" placeholder="{{__('enter_your_email')}}">
                                <button data-action="subscribe">{{__('subscribe')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End NEwsletter Area -->
    <!-- Start Best Seller Area -->
    <section class="wn__bestseller__area bg--white pt--80  pb--30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section__title text-center">
                        <h2 class="title__be--2">{!! __('all_product_header') !!}</h2>
                        <p>{!! __('all_product_detail') !!}</p>
                    </div>
                </div>
            </div>
            <div class="row mt--50">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="product__nav nav justify-content-center" role="tablist">
                        <a class="nav-item nav-link active" data-toggle="tab" href="#nav-all" role="tab">{{__('all')}}</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#nav-biographic" role="tab">{{__('biographic')}}</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#nav-adventure" role="tab">{{__('adventure')}}</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#nav-humor" role="tab">{{__('humor')}}</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#nav-cook" role="tab">{{__('cook')}}</a>
                    </div>
                </div>
            </div>
            <div class="tab__container mt--60">
                <!-- Start Single Tab Content -->
                <div class="row single__tab tab-pane fade show active" id="nav-all" role="tabpanel">
                    <div class="product__indicator--4 arrows_style owl-carousel owl-theme">
                        @foreach($allProducts as $products)
                            <div class="single__product">
                                @foreach($products as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                        <div class="product product__style--3">
                                            <div class="product__thumb">
                                                <a class="first__img" href="{{route('home.shop.single_product',  ['language' => app()->getLocale(), 'slug'=>$product->slug])}}"><img src="{{$product->featured_img}}" alt="product image"></a>
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
                                            <div class="product__content content--center content--center">
                                                <h4><a href="{{route('home.shop.single_product',  ['language' => app()->getLocale(), 'slug'=>$product->slug])}}">{{$product->name}}</a></h4>
                                                <ul class="prize d-flex">
                                                    <li>{!! number_format($product->discount, 0, ',', '.') . __('currency_unit') !!}</li>
                                                    <li class="old_prize">{!!  number_format($product->price, 0, ',', '.') .  __('currency_unit') !!}</li>
                                                </ul>
                                                <div class="action">
                                                    <div class="actions_inner" data-review="{{__('reviews_count', ['number' => $product->customerReviews()->count()])}}" data-url="{{route('home.shop.single_product', ['language' => app()->getLocale(), 'slug' => $product['slug']])}}" data-image="{{$product['featured_img']}}" data-author="{{$product['author']}}" data-discount="{!! number_format($product['discount'], 0, ',', '.') . __('currency_unit') !!}" data-title="{{$product['title']}}" data-price="{!! number_format($product['price'], 0, ',', '.').  __('currency_unit') !!}"  data-name="{{$product['name']}}" data-id="{{$product['id']}}">
                                                        <ul class="add_to_links">
                                                            <li><a class="cart" data-action="checkout-single" href="{{route('home.checkout', ['language' => app()->getLocale(), 'slug'=>$product['slug']])}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                                            <li><a class="wishlist" data-name="{{$product['name']}}" data-id="{{$product['id']}}" data-action="add_to_cart"  href="{{route('home.cart.store', ['language' => app()->getLocale()])}}"><i class="bi bi-shopping-cart-full"></i></a></li>
                                                            <li><a class="compare"  data-action="add_to_wishlist" data-exist="{{__('exist_in_wishlist',['name' => $product['name']])}}" data-add="{{__('add_to_wishlist',['name' => $product['name']])}}" href="{{route('home.wish_list', ['language' => app()->getLocale()])}}"><i class="bi bi-heart-beat"></i></a></li>
                                                            <li><a data-toggle="modal" data-action="quick_view" data-url="{{route('home.cart.store', ['language' => app()->getLocale()])}}" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"><i class="bi bi-search"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product__hover--content">
                                                    <ul class="rating d-flex">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($product->getRate($product->id) == 0)
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @elseif($product->getRate($product->id) > 0 && $i <= $product->getRate($product->id))
                                                                <li class="on"><i class="fa fa-star-o"></i></li>
                                                            @else
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @endif
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Start Single Tab Content -->
                <div class="row single__tab tab-pane fade" id="nav-biographic" role="tabpanel">
                    <div class="product__indicator--4 arrows_style owl-carousel owl-theme">
                        @foreach($biographicProducts as $products)
                            <div class="single__product">
                                @foreach($products as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                        <div class="product product__style--3">
                                            <div class="product__thumb">
                                                <a class="first__img" href="{{route('home.shop.single_product',  ['language' => app()->getLocale(), 'slug'=>$product->slug])}}"><img src="{{$product->featured_img}}" alt="product image"></a>
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
                                            <div class="product__content content--center content--center">
                                                <h4><a href="{{route('home.shop.single_product',  ['language' => app()->getLocale(), 'slug'=>$product->slug])}}">{{$product->name}}</a></h4>
                                                <ul class="prize d-flex">
                                                    <li>{!! number_format($product->discount, 0, ',', '.') . __('currency_unit') !!}</li>
                                                    <li class="old_prize">{!! number_format($product->price , 0, ',', '.').  __('currency_unit') !!}</li>
                                                </ul>
                                                <div class="action">
                                                    <div class="actions_inner" data-review="{{__('reviews_count', ['number' => $product->customerReviews()->count()])}}" data-url="{{route('home.shop.single_product', ['language' => app()->getLocale(), 'slug' => $product['slug']])}}" data-image="{{$product['featured_img']}}" data-author="{{$product['author']}}" data-discount="{!! number_format($product['discount'], 0, ',', '.') . __('currency_unit') !!}" data-title="{{$product['title']}}" data-price="{!! number_format($product['price'], 0, ',', '.').  __('currency_unit') !!}"  data-name="{{$product['name']}}" data-id="{{$product['id']}}">
                                                        <ul class="add_to_links">
                                                            <li><a class="cart" data-action="checkout-single" href="{{route('home.checkout', ['language' => app()->getLocale(), 'slug'=>$product['slug']])}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                                            <li><a class="wishlist" data-name="{{$product['name']}}" data-id="{{$product['id']}}" data-action="add_to_cart"  href="{{route('home.cart.store', ['language' => app()->getLocale()])}}"><i class="bi bi-shopping-cart-full"></i></a></li>
                                                            <li><a class="compare"  data-action="add_to_wishlist" data-exist="{{__('exist_in_wishlist',['name' => $product['name']])}}" data-add="{{__('add_to_wishlist',['name' => $product['name']])}}" href="{{route('home.wish_list', ['language' => app()->getLocale()])}}"><i class="bi bi-heart-beat"></i></a></li>
                                                            <li><a data-toggle="modal" data-action="quick_view" data-url="{{route('home.cart.store', ['language' => app()->getLocale()])}}" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"><i class="bi bi-search"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product__hover--content">
                                                    <ul class="rating d-flex">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($product->getRate($product->id) == 0)
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @elseif($product->getRate($product->id) > 0 && $i <= $product->getRate($product->id))
                                                                <li class="on"><i class="fa fa-star-o"></i></li>
                                                            @else
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @endif
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Start Single Tab Content -->
                <div class="row single__tab tab-pane fade" id="nav-adventure" role="tabpanel">
                    <div class="product__indicator--4 arrows_style owl-carousel owl-theme">
                        @foreach($adventureProducts as $products)
                            <div class="single__product">
                                @foreach($products as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                        <div class="product product__style--3">
                                            <div class="product__thumb">
                                                <a class="first__img" href="{{route('home.shop.single_product',  ['language' => app()->getLocale(), 'slug'=>$product->slug])}}"><img src="{{$product->featured_img}}" alt="product image"></a>
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
                                            <div class="product__content content--center content--center">
                                                <h4><a href="{{route('home.shop.single_product',  ['language' => app()->getLocale(), 'slug'=>$product->slug])}}">{{$product->name}}</a></h4>
                                                <ul class="prize d-flex">
                                                    <li>{!! number_format($product->discount, 0, ',', '.') . __('currency_unit') !!}</li>
                                                    <li class="old_prize">{!! number_format($product->price , 0, ',', '.').  __('currency_unit') !!}</li>
                                                </ul>
                                                <div class="action">
                                                    <div class="actions_inner" data-review="{{__('reviews_count', ['number' => $product->customerReviews()->count()])}}" data-url="{{route('home.shop.single_product', ['language' => app()->getLocale(), 'slug' => $product['slug']])}}" data-image="{{$product['featured_img']}}" data-author="{{$product['author']}}" data-discount="{!! number_format($product['discount'], 0, ',', '.') . __('currency_unit') !!}" data-title="{{$product['title']}}" data-price="{!! number_format($product['price'], 0, ',', '.').  __('currency_unit') !!}"  data-name="{{$product['name']}}" data-id="{{$product['id']}}">
                                                        <ul class="add_to_links">
                                                            <li><a class="cart" data-action="checkout-single" href="{{route('home.checkout', ['language' => app()->getLocale(), 'slug'=>$product['slug']])}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                                            <li><a class="wishlist" data-name="{{$product['name']}}" data-id="{{$product['id']}}" data-action="add_to_cart"  href="{{route('home.cart.store', ['language' => app()->getLocale()])}}"><i class="bi bi-shopping-cart-full"></i></a></li>
                                                            <li><a class="compare"  data-action="add_to_wishlist" data-exist="{{__('exist_in_wishlist',['name' => $product['name']])}}" data-add="{{__('add_to_wishlist',['name' => $product['name']])}}" href="{{route('home.wish_list', ['language' => app()->getLocale()])}}"><i class="bi bi-heart-beat"></i></a></li>
                                                            <li><a data-toggle="modal" data-action="quick_view" data-url="{{route('home.cart.store', ['language' => app()->getLocale()])}}" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"><i class="bi bi-search"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product__hover--content">
                                                    <ul class="rating d-flex">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($product->getRate($product->id) == 0)
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @elseif($product->getRate($product->id) > 0 && $i <= $product->getRate($product->id))
                                                                <li class="on"><i class="fa fa-star-o"></i></li>
                                                            @else
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @endif
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Start Single Tab Content -->
                <div class="row single__tab tab-pane fade" id="nav-humor" role="tabpanel">
                    <div class="product__indicator--4 arrows_style owl-carousel owl-theme">
                        @foreach($humorProducts as $products)
                            <div class="single__product">
                                @foreach($products as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                        <div class="product product__style--3">
                                            <div class="product__thumb">
                                                <a class="first__img" href="{{route('home.shop.single_product',  ['language' => app()->getLocale(), 'slug'=>$product->slug])}}"><img src="{{$product->featured_img}}" alt="product image"></a>
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
                                            <div class="product__content content--center content--center">
                                                <h4><a href="{{route('home.shop.single_product',  ['language' => app()->getLocale(), 'slug'=>$product->slug])}}">{{$product->name}}</a></h4>
                                                <ul class="prize d-flex">
                                                    <li>{!! number_format($product->discount, 0, ',', '.') . __('currency_unit') !!}</li>
                                                    <li class="old_prize">{!! number_format($product->price, 0, ',', '.' ).  __('currency_unit') !!}</li>
                                                </ul>
                                                <div class="action">
                                                    <div class="actions_inner" data-review="{{__('reviews_count', ['number' => $product->customerReviews()->count()])}}" data-url="{{route('home.shop.single_product', ['language' => app()->getLocale(), 'slug' => $product['slug']])}}" data-image="{{$product['featured_img']}}" data-author="{{$product['author']}}" data-discount="{!! number_format($product['discount'], 0, ',', '.') . __('currency_unit') !!}" data-title="{{$product['title']}}" data-price="{!! number_format($product['price'], 0, ',', '.').  __('currency_unit') !!}"  data-name="{{$product['name']}}" data-id="{{$product['id']}}">
                                                        <ul class="add_to_links">
                                                            <li><a class="cart" data-action="checkout-single" href="{{route('home.checkout', ['language' => app()->getLocale(), 'slug'=>$product['slug']])}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                                            <li><a class="wishlist" data-name="{{$product['name']}}" data-id="{{$product['id']}}" data-action="add_to_cart"  href="{{route('home.cart.store', ['language' => app()->getLocale()])}}"><i class="bi bi-shopping-cart-full"></i></a></li>
                                                            <li><a class="compare"  data-action="add_to_wishlist" data-exist="{{__('exist_in_wishlist',['name' => $product['name']])}}" data-add="{{__('add_to_wishlist',['name' => $product['name']])}}" href="{{route('home.wish_list', ['language' => app()->getLocale()])}}"><i class="bi bi-heart-beat"></i></a></li>
                                                            <li><a data-toggle="modal" data-action="quick_view" data-url="{{route('home.cart.store', ['language' => app()->getLocale()])}}" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"><i class="bi bi-search"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product__hover--content">
                                                    <ul class="rating d-flex">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($product->getRate($product->id) == 0)
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @elseif($product->getRate($product->id) > 0 && $i <= $product->getRate($product->id))
                                                                <li class="on"><i class="fa fa-star-o"></i></li>
                                                            @else
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @endif
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Start Single Tab Content -->
                <div class="row single__tab tab-pane fade" id="nav-cook" role="tabpanel">
                    <div class="product__indicator--4 arrows_style owl-carousel owl-theme">
                        @foreach($cookProducts as $products)
                            <div class="single__product">
                                @foreach($products as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                        <div class="product product__style--3">
                                            <div class="product__thumb">
                                                <a class="first__img" href="{{route('home.shop.single_product',  ['language' => app()->getLocale(), 'slug'=>$product->slug])}}"><img src="{{$product->featured_img}}" alt="product image"></a>
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
                                            <div class="product__content content--center content--center">
                                                <h4><a href="{{route('home.shop.single_product',  ['language' => app()->getLocale(), 'slug'=>$product->slug])}}">{{$product->name}}</a></h4>
                                                <ul class="prize d-flex">
                                                    <li>{!! number_format($product->discount, 0, ',', '.') . __('currency_unit') !!}</li>
                                                    <li class="old_prize">{!! number_format($product->price , 0, ',', '.').  __('currency_unit') !!}</li>
                                                </ul>
                                                <div class="action">
                                                    <div class="actions_inner" data-review="{{__('reviews_count', ['number' => $product->customerReviews()->count()])}}" data-url="{{route('home.shop.single_product', ['language' => app()->getLocale(), 'slug' => $product['slug']])}}" data-image="{{$product['featured_img']}}" data-author="{{$product['author']}}" data-discount="{!! number_format($product['discount'], 0, ',', '.') . __('currency_unit') !!}" data-title="{{$product['title']}}" data-price="{!! number_format($product['price'], 0, ',', '.').  __('currency_unit') !!}"  data-name="{{$product['name']}}" data-id="{{$product['id']}}">
                                                        <ul class="add_to_links">
                                                            <li><a class="cart" data-action="checkout-single" href="{{route('home.checkout', ['language' => app()->getLocale(), 'slug'=>$product['slug']])}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                                            <li><a class="wishlist" data-name="{{$product['name']}}" data-id="{{$product['id']}}" data-action="add_to_cart"  href="{{route('home.cart.store', ['language' => app()->getLocale()])}}"><i class="bi bi-shopping-cart-full"></i></a></li>
                                                            <li><a class="compare"  data-action="add_to_wishlist" data-exist="{{__('exist_in_wishlist',['name' => $product['name']])}}" data-add="{{__('add_to_wishlist',['name' => $product['name']])}}" href="{{route('home.wish_list', ['language' => app()->getLocale()])}}"><i class="bi bi-heart-beat"></i></a></li>
                                                            <li><a data-toggle="modal" data-action="quick_view" data-url="{{route('home.cart.store', ['language' => app()->getLocale()])}}" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"><i class="bi bi-search"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product__hover--content">
                                                    <ul class="rating d-flex">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($product->getRate($product->id) == 0)
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @elseif($product->getRate($product->id) > 0 && $i <= $product->getRate($product->id))
                                                                <li class="on"><i class="fa fa-star-o"></i></li>
                                                            @else
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @endif
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- End Single Tab Content -->
            </div>
        </div>
    </section>
    <!-- Start BEst Seller Area -->
    <!-- Best Sale Area -->
    <section id="best-sell"  class="best-seel-area pt--80 pb--60">
        <div class="container">
            <div class="row" >
                <div class="col-lg-12">
                    <div class="section__title text-center pb--50">
                        <h2 class="title__be--2">{!! __('best_sell_product_header') !!}</h2>
                        <p>{!! __('best_sell_product_detail') !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider center">
            @foreach($bestSellProducts as $product)
                <div class="product product__style--3">
                    <div class="product__thumb">
                        <a class="first__img" href="{{route('home.shop.single_product',  ['language' => app()->getLocale(), 'slug'=>$product->slug])}}"><img src="{{$product->featured_img}}" alt="product image"></a>
                    </div>
                    <div class="product__content content--center">
                        <div class="action">
                            <div class="actions_inner" data-review="{{__('reviews_count', ['number' => $product->customerReviews()->count()])}}" data-url="{{route('home.shop.single_product', ['language' => app()->getLocale(), 'slug' => $product['slug']])}}" data-image="{{$product['featured_img']}}" data-author="{{$product['author']}}" data-discount="{!! number_format($product['discount'], 0, ',', '.') . __('currency_unit') !!}" data-title="{{$product['title']}}" data-price="{!! number_format($product['price'], 0, ',', '.').  __('currency_unit') !!}"  data-name="{{$product['name']}}" data-id="{{$product['id']}}">
                                <ul class="add_to_links">
                                    <li><a class="cart" data-action="checkout-single" href="{{route('home.checkout', ['language' => app()->getLocale(), 'slug'=>$product['slug']])}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                    <li><a class="wishlist" data-name="{{$product['name']}}" data-id="{{$product['id']}}" data-action="add_to_cart"  href="{{route('home.cart.store', ['language' => app()->getLocale()])}}"><i class="bi bi-shopping-cart-full"></i></a></li>
                                    <li><a class="compare"  data-action="add_to_wishlist" data-exist="{{__('exist_in_wishlist',['name' => $product['name']])}}" data-add="{{__('add_to_wishlist',['name' => $product['name']])}}" href="{{route('home.wish_list', ['language' => app()->getLocale()])}}"><i class="bi bi-heart-beat"></i></a></li>
                                    <li><a data-toggle="modal"  data-action="quick_view" data-url="{{route('home.cart.store', ['language' => app()->getLocale()])}}" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"><i class="bi bi-search"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product__hover--content">
                            <ul class="rating d-flex">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($product['rate'] == 0)
                                        <li><i class="fa fa-star-o"></i></li>
                                    @elseif($product['rate'] > 0 && $i <= $product['rate'])
                                        <li class="on"><i class="fa fa-star-o"></i></li>
                                    @else
                                        <li><i class="fa fa-star-o"></i></li>
                                    @endif
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <!-- Best Sale Area Area -->
    <!--  quick view -->
    @include('fontend.quick_view')

@endsection

