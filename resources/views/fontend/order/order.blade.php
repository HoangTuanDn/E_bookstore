@extends('layouts.master')

@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--3">
        @include('fontend.breadcumb',['pageNameLC' => __('my_orders_lc')])
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
                                            <ul class="cart__btn__list d-flex flex-wrap flex-md-nowrap flex-lg-nowrap justify-content-between">
                                                <li><span class="d-inline-block">[{{__('your_order_code') . ': '. $order->order_code}}] ({!!date('d/m/Y', strtotime($order->created_at))!!})</span></li>

                                                <li><span class="d-inline-block">{!!__('order_total_price', ['price' => number_format($orderTotalPrice[$order->id], 0, ',', '.') . __('currency_unit')])!!}</span></li>
                                            </ul>
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->products as $product)
                                        <tr>
                                            <td class="product-thumbnail"><a href="{{route('home.shop.single_product', ['language' => app()->getLocale(),'slug' => $product->slug])}}"><img width="75px" src="{{$product->featured_img}}" alt="product img"></a></td>
                                            <td class="product-name"><a href="{{route('home.shop.single_product', ['language' => app()->getLocale(), 'slug' => $product->slug])}}">{{$product->name}}</a></td>
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
                                    <li><span class="d-inline-block mt--20" >{!!__('order_status', ['name' => __('order_pending')])!!}</span></li>
                                @elseif($order->status === 1)
                                    <li><span class="d-inline-block mt--20" >{!!__('order_status', ['name' => __('order_confirm')])!!}</span></li>
                                @elseif($order->status === 2)
                                    <li><span class="d-inline-block mt--20" >{!!__('order_status', ['name' => __('order_shipping')])!!}</span></li>
                                @elseif($order->status === 3)
                                    <li><span class="d-inline-block mt--20" >{!!__('order_status', ['name' => __('order_shipped')])!!}</span></li>
                                @elseif($order->status === 4)
                                    <li><span class="d-inline-block mt--20" >{!!__('order_status', ['name' => __('order_paid')])!!}</span></li>
                                @elseif($order->status === 5)
                                    <li><span class="d-inline-block mt--20" >{!!__('order_status', ['name' => __('order_completed')])!!}</span></li>
                                @endif


                                    @if($order->payment->id === 1 )
                                        <li><span class="d-inline-block mt--20">{!!__('order_payment', ['method' =>__('direct_bank_transfer')])!!}</span></li>
                                    @elseif($order->payment->id === 2)
                                        <li><span class="d-inline-block mt--20">{!!__('order_payment', ['method' => __('cash_on_delivery')])!!}</span></li>
                                    @elseif($order->payment->id === 3)
                                        <li><span class="d-inline-block mt--20">{!!__('order_payment', ['method' => __('paypal')])!!}</span></li>
                                    @endif

                                <li><a data-action="destroy-order" {{$order->status > 1 ? 'class=disabled' : ''}} data-success="{{__('success_text')}}" data-warning="{{__('warning_text')}}" data-cancel="{{__('text_cancel')}}" data-ok="{{__('text_ok')}}" data-title="{{__('order_data_title')}}" data-code="{{$order->order_code}}" href="{{route('order.destroy', ['language' => app()->getLocale(), 'id' => $order->id])}}">{{__('cancel_order')}}</a></li>
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