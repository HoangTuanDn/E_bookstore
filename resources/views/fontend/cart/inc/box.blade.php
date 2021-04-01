<div class="minicart-content-wrapper">
    <div class="micart__close">
        <span>close</span>
    </div>
    <div class="items-total d-flex justify-content-between">
        <span class="total-text">{{$totalItem}} items</span>
        <span>Cart Subtotal</span>
    </div>
    <div class="total_amount text-right">
        <span>{!! number_format($totalPrice, 0, ',', '.') . __('currency_unit') !!}</span>
    </div>
    <div class="mini_action checkout">
        <a class="checkout__btn" href="cart.html">Go to Checkout</a>
    </div>
    <div class="single__items">
        <div class="miniproduct">
            @foreach($data as $item)
                <div class="item01 d-flex mt--20">
                    <div class="thumb">
                        <a href="product-details.html"><img src="{{$item['image']}}" alt="product images"></a>
                    </div>
                    <div class="content">
                        <h6><a href="product-details.html">{{$item['name']}}</a></h6>
                        <span class="prize">{!! number_format($item['price'], 0, ',', '.') . __('currency_unit') !!}</span>
                        <div class="product_prize d-flex justify-content-between">
                            <span class="qun">Qty: {{strlen($item['quantity']) > 2 ? sprintf('%03d', $item['quantity']) : sprintf('%02d', $item['quantity'])}}</span>
                            <ul class="d-flex justify-content-end">
                                <li><a data-action="item-quantity" href="{{route('home.cart.update')}}"><i class="zmdi zmdi-settings"></i></a></li>
                                <li><a data-action="remove-item-cart-box" data-id="{{$item['id']}}" href="{{route('home.cart.destroy')}}"><i class="zmdi zmdi-delete"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mini_action cart">
        <a class="cart__btn" href="{{route('home.cart')}}">{{__('view_cart')}}</a>
    </div>
</div>