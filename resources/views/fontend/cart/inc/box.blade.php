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
        <a class="checkout__btn" href="{{route('home.checkout')}}">{{__('check_out')}}</a>
    </div>
    <div class="single__items">
        <div class="miniproduct">
            @foreach($data as $item)
                <div class="item01 d-flex mt--20">
                    <div class="thumb">
                        <a href="{{route('home.shop.single_product',['slug'=> $item['slug']])}}"><img src="{{$item['image']}}" alt="product images"></a>
                    </div>
                    <div class="content">
                        <h6><a href="{{route('home.shop.single_product',['slug'=> $item['slug']])}}">{{$item['name']}}</a></h6>
                        <span class="prize">{!! number_format($item['price'], 0, ',', '.') . __('currency_unit') !!}</span>
                        <div class="product_prize d-flex justify-content-between">
                            <span data-quantity="{{$item['quantity']}}" class="qun">Qty: {{strlen($item['quantity']) > 2 ? sprintf('%03d', $item['quantity']) : sprintf('%02d', $item['quantity'])}}</span>
                            <ul class="d-flex justify-content-end">
                                <li><a data-action="btnCartBoxUpdate" href="{{route('home.cart.update', ['id' => $item['id']])}}"><i class="zmdi zmdi-settings"></i></a></li>
                                <li><a data-action="remove-item-in-box" data-type="box" data-id="{{$item['id']}}" href="{{route('home.cart.destroy',['id' => $item['id']])}}"><i class="zmdi zmdi-delete"></i></a></li>
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