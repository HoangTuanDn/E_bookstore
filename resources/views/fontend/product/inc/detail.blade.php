<div class="wn__single__product">
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="wn__fotorama__wrapper">
                <div class="fotorama wn__fotorama__action" data-nav="thumbs">
                    @foreach($product->images as $detailImage)
                        <a href="{{$detailImage->image_path}}"><img src="{{$detailImage->image_path}}" alt=""></a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="product__info__main">
                <h1>{{$product->name}}</h1>
                <div class="product-reviews-summary d-flex">
                    <ul class="rating-summary d-flex">
                        <li><i class="zmdi zmdi-star-outline"></i></li>
                        <li><i class="zmdi zmdi-star-outline"></i></li>
                        <li><i class="zmdi zmdi-star-outline"></i></li>
                        <li class="off"><i class="zmdi zmdi-star-outline"></i></li>
                        <li class="off"><i class="zmdi zmdi-star-outline"></i></li>
                    </ul>
                </div>
                <div class="price-box">
                    <span>{!! number_format($product->discount, 0, ',', '.') . __('currency_unit') !!}</span>
                </div>
                <div class="product__overview">
                    <p>{!! $product->title !!}</p>
                </div>
                <div class="box-tocart d-flex">
                    <span>Qty</span>
                    <input id="qty" class="input-text qty" name="qty" max="{{$product->quantity}}" min="1" value="1" title="Qty" type="number">
                    <div class="addtocart__actions">
                        <button class="tocart" data-name="{{$product['name']}}" data-id="{{$product['id']}}" data-action="add_to_cart"  data-url="{{route('home.cart.store', ['language' => app()->getLocale()])}}" type="button" title="Add to Cart">{{__('add_to_cart_1')}}</button>
                    </div>
                    <div class="product-addto-links clearfix">
                        {{--<a class="wishlist" href="{{route('home.wish_list')}}"></a>--}}
                        <a class="wishlist"  data-action="add_to_wishlist" data-exist="{{__('exist_in_wishlist',['name' => $product['name']])}}" data-add="{{__('add_to_wishlist',['name' => $product['name']])}}" href="{{route('home.wish_list', ['language' => app()->getLocale()])}}"></a>
                    </div>
                </div>
                <div class="product_meta">
					<span class="posted_in">{{__('categories_lc')}}:
                        {!! $textCategory!!}
					</span>
                </div>
                <div class="product-share">
                    <ul>
                        <li class="categories-title">{{__('share')}} :</li>
                        <li>
                            <a href="#">
                                <i class="icon-social-twitter icons"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-social-tumblr icons"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-social-facebook icons"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-social-linkedin icons"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product__info__detailed">
    <div class="pro_details_nav nav justify-content-start" role="tablist">
        <a class="nav-item nav-link active" data-toggle="tab" href="#nav-details" role="tab">{{__('details')}}</a>
        <a class="nav-item nav-link" data-toggle="tab" href="#nav-review" role="tab">{{__('reviews', ['number' => $product->customerReviews()->count()])}}</a>
    </div>
    <div class="tab__container">
        <!-- Start Single Tab Content -->
        <div class="pro__tab_label tab-pane fade show active" id="nav-details" role="tabpanel">
            <div class="description__attribute">
                <p>{!! $product->content !!}</p>
                <ul>
                    <li>• {!!__('author', ['name' => $product->author])!!}.</li>
                    <li>• {!!__('publisher_and_publis_date', ['publisher'=> $product->publisher, 'publish_date' => $product->publish_date])!!}.</li>
                    <li>• {!!__('page_and_dimensions', ['page'=> $product->page, 'dimensions' => $product->dimensions])!!}.</li>
                </ul>
            </div>
        </div>
        <!-- End Single Tab Content -->
        <!-- Start Single Tab Content -->
        <div class="pro__tab_label tab-pane fade" id="nav-review" role="tabpanel">
            <div class="review__attribute">
                {!! $inc_review !!}
            </div>
            {{--custom review--}}
            <div class="review-fieldset">
                <h2>{{__('you_reviewing')}}</h2>
                <h3>{{$product->name}}</h3>
                <div class="review-field-ratings">
                    <div class="product-review-table">
                        <div class="review-field-rating d-flex" id="quantity">
                            <span>{{__('quality')}}</span>
                            <input type="radio" name="review-quantity" id="quantity-star-1">
                            <input type="radio" name="review-quantity" id="quantity-star-2">
                            <input type="radio" name="review-quantity" id="quantity-star-3">
                            <input type="radio" name="review-quantity" id="quantity-star-4">
                            <input type="radio" name="review-quantity" id="quantity-star-5">

                            <ul class="rating d-flex quantity-stars">
                                <label for="quantity-star-1" class="star-1" ><li class="off"><i class="zmdi zmdi-star"></i></li></label>
                                <label for="quantity-star-2" class="star-2" ><li class="off"><i class="zmdi zmdi-star"></i></li></label>
                                <label for="quantity-star-3" class="star-3" ><li class="off"><i class="zmdi zmdi-star"></i></li></label>
                                <label for="quantity-star-4" class="star-4" ><li class="off"><i class="zmdi zmdi-star"></i></li></label>
                                <label for="quantity-star-5" class="star-5" ><li class="off"><i class="zmdi zmdi-star"></i></li></label>

                            </ul>
                        </div>

                        <div class="review-field-rating d-flex" id="price">
                            <span>{{__('price')}}</span>
                            <input type="radio" name="review-price" id="price-star-1">
                            <input type="radio" name="review-price" id="price-star-2">
                            <input type="radio" name="review-price" id="price-star-3">
                            <input type="radio" name="review-price" id="price-star-4">
                            <input type="radio" name="review-price" id="price-star-5">

                            <ul class="rating d-flex price-stars">
                                <label for="price-star-1" class="star-1" ><li class="off"><i class="zmdi zmdi-star"></i></li></label>
                                <label for="price-star-2" class="star-2" ><li class="off"><i class="zmdi zmdi-star"></i></li></label>
                                <label for="price-star-3" class="star-3" ><li class="off"><i class="zmdi zmdi-star"></i></li></label>
                                <label for="price-star-4" class="star-4" ><li class="off"><i class="zmdi zmdi-star"></i></li></label>
                                <label for="price-star-5" class="star-5" ><li class="off"><i class="zmdi zmdi-star"></i></li></label>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="review_form_field">
                    <div class="input__box">
                        <span>{{__('nickname')}}</span>
                        @if(auth()->guard('customer')->guest())
                            <input id="nickname_field" type="text" name="nickname">
                        @else
                            <input id="nickname_field" type="text" value="{{auth()->guard('customer')->user()->name}}" name="nickname">
                        @endif

                    </div>
                    <div class="input__box">
                        <span>{{__('review')}}</span>
                        <textarea name="review_content"></textarea>
                    </div>
                    <div class="review-form-actions">
                        <button data-action="customer-review" data-id="{{{$product->id}}}" data-url="{{route('home.product.review', ['language'=>app()->getLocale(),'slug' => $product->slug])}}">{{__('submit_review')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Tab Content -->
    </div>
</div>