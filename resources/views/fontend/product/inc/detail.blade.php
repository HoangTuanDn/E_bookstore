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
                    <span>{!! number_format($product->discount) . __('currency_unit') !!}</span>
                </div>
                <div class="product__overview">
                    <p>{!! $product->title !!}</p>
                </div>
                <div class="box-tocart d-flex">
                    <span>Qty</span>
                    <input id="qty" class="input-text qty" name="qty" min="1" value="1" title="Qty" type="number">
                    <div class="addtocart__actions">
                        <button class="tocart" type="submit" title="Add to Cart">{{__('add_to_cart')}}</button>
                    </div>
                    <div class="product-addto-links clearfix">
                        <a class="wishlist" href="{{route('home.wish_list')}}"></a>
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
        <a class="nav-item nav-link" data-toggle="tab" href="#nav-review" role="tab">{{__('reviews')}}</a>
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
                <h1>Customer Reviews</h1>
                <h2>Hastech</h2>
                <div class="review__ratings__type d-flex">
                    <div class="review-ratings">
                        <div class="rating-summary d-flex">
                            <span>Quality</span>
                            <ul class="rating d-flex">
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                            </ul>
                        </div>

                        <div class="rating-summary d-flex">
                            <span>Price</span>
                            <ul class="rating d-flex">
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                            </ul>
                        </div>
                        <div class="rating-summary d-flex">
                            <span>value</span>
                            <ul class="rating d-flex">
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="review-content">
                        <p>Hastech</p>
                        <p>Review by Hastech</p>
                        <p>Posted on 11/6/2018</p>
                    </div>
                </div>
            </div>
            <div class="review-fieldset">
                <h2>You're reviewing:</h2>
                <h3>Chaz Kangeroo Hoodie</h3>
                <div class="review-field-ratings">
                    <div class="product-review-table">
                        <div class="review-field-rating d-flex">
                            <span>Quality</span>
                            <ul class="rating d-flex">
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                            </ul>
                        </div>
                        <div class="review-field-rating d-flex">
                            <span>Price</span>
                            <ul class="rating d-flex">
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                            </ul>
                        </div>
                        <div class="review-field-rating d-flex">
                            <span>Value</span>
                            <ul class="rating d-flex">
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                                <li class="off"><i class="zmdi zmdi-star"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="review_form_field">
                    <div class="input__box">
                        <span>Nickname</span>
                        <input id="nickname_field" type="text" name="nickname">
                    </div>
                    <div class="input__box">
                        <span>Summary</span>
                        <input id="summery_field" type="text" name="summery">
                    </div>
                    <div class="input__box">
                        <span>Review</span>
                        <textarea name="review"></textarea>
                    </div>
                    <div class="review-form-actions">
                        <button>Submit Review</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Tab Content -->
    </div>
</div>