<div class="row">
    <div class="col-lg-12">
        <div class="shop__list__wrapper d-flex flex-wrap flex-md-nowrap justify-content-between">
            <div class="shop__list nav justify-content-center" role="tablist">
                <a class="nav-item nav-link active" data-toggle="tab" href="#nav-grid" role="tab"><i
                            class="fa fa-th"></i></a>
                <a class="nav-item nav-link" data-toggle="tab" href="#nav-list" role="tab"><i
                            class="fa fa-list"></i></a>
            </div>
            <p class="text_result">{{$result}}</p>
            <div class="orderby__wrapper">
                <span>{{__('sort_by')}}</span>
                <select class="shot__byselect" data-action="sort_product">
                    <option {{$sort == 'default' ? 'selected' : ''}} value="{{$sort_default}}">{{__('sort_default_product')}}</option>
                    <option {{$sort == 'name' ? 'selected' : ''}} value="{{$sort_name}}">{{__('sort_name_product')}}</option>
                    <option {{$sort == 'price' ? 'selected' : ''}} value="{{$sort_price}}">{{__('sort_price_product')}}</option>
                    <option {{$sort == 'date' ? 'selected' : ''}} value="{{$sort_date}}">{{__('sort_date_product')}}</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="tab__container">
    <div class="shop-grid tab-pane fade show active" id="nav-grid" role="tabpanel">
        <div class="row">
            <!-- Start Single Product -->
            @foreach($products as $product)
                <div class="product product__style--3 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="product__thumb">
                        <a class="first__img" href="{{route('home.shop.single_product',['slug' => $product['slug']])}}"><img
                                    src="{{$product['featured_img']}}" alt="product image"></a>

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
                        <h4><a href="{{route('home.shop', ['slug' => $product['slug']])}}">{{$product['name']}}</a></h4>
                        <ul class="prize d-flex">
                            <li>{!! number_format($product['discount']) . __('currency_unit') !!}</li>
                            <li class="old_prize">{!! number_format($product['price']).  __('currency_unit') !!}</li>
                        </ul>
                        <div class="action">
                            <div class="actions_inner" data-discount="{{$product['discount']}}" data-title="{{$product['title']}}" data-price="{{$product['price']}}"  data-name="{{$product['name']}}" data-id="{{$product['id']}}" >
                                <ul class="add_to_links">
                                    <li><a class="cart" data-action="checkout" href="{{route('home.checkout',['id'=>$product['id']])}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                    <li><a class="wishlist" data-name="{{$product['name']}}" data-id="{{$product['id']}}" data-action="add_to_cart"  href="{{route('home.cart.store')}}"><i class="bi bi-shopping-cart-full"></i></a></li>
                                    <li><a class="compare" data-action="add_to_wishlist" href="{{route('home.wish_list')}}"><i class="bi bi-heart-beat"></i></a></li>
                                    <li><a data-toggle="modal" data-action="quick_view" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"><i class="bi bi-search"></i></a></li>
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
        {!! $pagination !!}
    </div>
    <div class="shop-grid tab-pane fade" id="nav-list" role="tabpanel">
        <div class="list__view__wrapper">
            @foreach($products as $product)
                <div class="list__view mt--40">
                    <div class="thumb">
                        <a class="first__img" href="{{route('home.shop.single_product',['slug' => $product['slug']])}}"><img src="{{$product['featured_img']}}" alt="product images"></a>
                    </div>
                    <div class="content">
                        <h2><a href="{{route('home.shop', ['slug' => $product['slug']])}}">{{$product['name']}}</a></h2>
                        <ul class="rating d-flex">
                            <li class="on"><i class="fa fa-star-o"></i></li>
                            <li class="on"><i class="fa fa-star-o"></i></li>
                            <li class="on"><i class="fa fa-star-o"></i></li>
                            <li class="on"><i class="fa fa-star-o"></i></li>
                            <li><i class="fa fa-star-o"></i></li>
                            <li><i class="fa fa-star-o"></i></li>
                        </ul>
                        <ul class="prize__box">
                            <li>{{number_format($product['discount']) . __('currency_unit')}}</li>
                            <li class="old__prize">{{number_format($product['price']).  __('currency_unit')}}</li>
                        </ul>
                        <div class="product_title">{!! $product['title'] !!}</div>
                        <ul class="cart__action d-flex">
                            <li class="cart"><a data-name="{{$product['name']}}" data-id="{{$product['id']}}" data-action="add_to_cart"  href="{{route('home.cart.store')}}">{{__('add_to_cart_1')}}</a></li>
                            <li class="wishlist"><a href={{route('home.wish_list')}}></a></li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
