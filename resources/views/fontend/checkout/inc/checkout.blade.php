
<h3 class="onder__title">{{__('your_order')}}</h3>
<ul class="order__total">
    <li>{{__('product')}}</li>
    <li>{{__('total')}}</li>
</ul>
<ul class="order_product">
    @if($slug)
        <li class="detail_item">

            <p class="product_name">{{$data->name}} </p>
            <p class="product_quantity">x {{1}}</p>
            <span class="product_price">{!! number_format($data->discount, 0, ',', '.') . __('currency_unit') !!}</span>
        </li>
    @else
        @foreach($data as $item)
            {{--            <li>{{$item['name'] .' x '. $item['quantity']}} <span>$48.00</span></li>--}}
            <li class="detail_item">

                <p class="product_name">{{$item['name']}} </p>
                <p class="product_quantity">x {{$item['quantity']}}</p>
                <span class="product_price">{!! number_format($item['sub_price'], 0, ',', '.') . __('currency_unit') !!}</span>
            </li>
        @endforeach
    @endif

</ul>
<ul class="shipping__method">
    <li>{{__('grand_total_cart')}} <span>{!! number_format($totalPrice, 0, ',', '.') . __('currency_unit') !!}</span></li>

    @if($couponData)
        <li>{{__('coupon_code')}}
            <ul>
                <li>
                    <label>{!! $couponData['condition'] === 1 ? "-{$couponData['discount']}%" : '-'.number_format($couponData['discount'], 0, ',', '.') . __('currency_unit') !!}</label>
                </li>
            </ul>
        </li>
    @endif

    <li>{{__('fee_Shipping')}}
        <ul>
            <li>
                <label>{!! number_format($order['fee_ship'], 0, ',', '.') . __('currency_unit') !!}</label>
            </li>
        </ul>
    </li>
</ul>
<ul class="total__amount">
    <li>{{__('order_total')}} <span>{!! number_format($order['total_price'], 0, ',', '.') . __('currency_unit') !!}</span></li>
</ul>
