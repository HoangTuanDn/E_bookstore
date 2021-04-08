@extends('layouts.master')

@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">My Orders</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="index.html">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">My Orders</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- cart-main-area start -->
    <div class="cart-main-area section-padding--lg bg--white">
        <div class="container">
            <div class="row">
                @foreach($orders as $order)
                    <div class="col-md-12 col-sm-12 ol-lg-12 mt--20" id="order-detail">
                        <form action="#">
                            <div class="table-content wnro__table table-responsive">
                                <table>
                                    <thead>
                                    <tr class="title-top ">
                                        <th colspan="5" class="product-thumbnail">
                                            <span class="d-inline-block text-left col-md-12 col-sm-12 ol-lg-12  ">{{__('your_order_code') . ': '. $order->order_code}}</span>
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->products as $product)
                                        <tr>
                                            <td class="product-thumbnail"><a href="{{route('home.shop.single_product', ['slug' => $product->slug])}}"><img width="75px" src="{{$product->featured_img}}" alt="product img"></a></td>
                                            <td class="product-name"><a href="#">{{$product->name}}</a></td>
                                            <td class="product-price"><span class="amount">{{number_format($product->discount, 0, ',', '.')}}</span></td>
                                            <td class="product-quantity"><span class="amount">{{$product->pivot->quantity}}</span></td>
                                            <td class="product-subtotal">{{number_format(($product->pivot->quantity * $product->discount), 0, ',', '.')}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="cartbox__btn" style="padding: 10px 20px">

                            <ul class="cart__btn__list d-flex flex-wrap flex-md-nowrap flex-lg-nowrap justify-content-between">
                                @if($order->status === 0 )
                                    <li><span class="d-inline-block mt--20">{!!__('order_status', ['name' => __('order_pending')])!!}</span></li>
                                @elseif($order->status === 1)
                                    <li><span class="d-inline-block mt--20">{!!__('order_status', ['name' => __('order_confirm')])!!}</span></li>
                                @elseif($order->status === 2)
                                    <li><span class="d-inline-block mt--20">{!!__('order_status', ['name' => __('order_shipping')])!!}</span></li>
                                @elseif($order->status === 3)
                                    <li><span class="d-inline-block mt--20">{!!__('order_status', ['name' => __('order_shipped')])!!}</span></li>
                                @endif
                                <li><a data-action="destroy-order" data-success="{{__('success_text')}}" data-warning="{{__('warning_text')}}" data-cancel="{{__('text_cancel')}}" data-ok="{{__('text_ok')}}" data-title="{{__('order_data_title')}}" data-code="{{$order->order_code}}" href="{{route('order.destroy', ['id' => $order->id])}}">Hủy đơn hàng</a></li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{asset('fontend/common/order.js')}}"></script>

@endsection