<div class="table-content wnro__table table-responsive">
    <table>
        <thead>
        <tr class="title-top">
            <th class="product-thumbnail">{{__('image')}}</th>
            <th class="product-name">{{__('product')}}</th>
            <th class="product-price">{{__('price')}}</th>
            <th class="product-quantity">{{__('quantity')}}</th>
            <th class="product-subtotal">{{__('total')}}</th>
            <th class="product-remove">{{__('remove')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                <td class="product-thumbnail"><a href="{{route('home.shop.single_product',['slug' => $item['slug']])}}"><img src="{{$item['image']}}" alt="product img"></a></td>
                <td class="product-name"><a href="{{route('home.shop.single_product',['slug' => $item['slug']])}}">{{$item['name']}}</a></td>
                <td class="product-price"><span class="amount">{{number_format($item['price']) . __('currency_unit')}}</span></td>
                <td class="product-quantity"><input data-id="{{$item['id']}}" data-url="{{route('home.cart.update')}}" data-action="item-quantity" min="1" type="number" value="{{$item['quantity']}}"></td>
                <td class="product-subtotal">{{number_format($item['price'] * $item['quantity']) . __('currency_unit')}}</td>
                <td class="product-remove"><a data-action="remove-item" data-id="{{$item['id']}}" href="{{route('home.cart.destroy')}}">X</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>