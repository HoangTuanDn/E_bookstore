@extends('layouts.admin')
@section('title')
    <title>Order</title>
@endsection
@section('css')

@endsection

@section('js_link')

    {{--<script src="{{asset('backend/common/ship/ship.js')}}"></script>--}}
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'orders', 'action' => 'show'])

    <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    <h3 class="card-title p-1">Thông tin vận chuyển</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 20%; text-align: left">
                                Tên
                            </th>
                            <th style="width: 30%; text-align: left">
                                Địa chỉ giao hàng
                            </th>

                            <th style="width: 30%; text-align: left">
                                Số điện thoại
                            </th>

                            <th style="width: 30%; text-align: left">
                                Email
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <span>{{$order->full_name}}</span>
                            </td>
                            <td class="text-left">
                                {{$order->ship->province->name .', '. $order->ship->district->name .', '. $order->ship->ward->name .', '. $order->address}}
                            </td>
                            <td class="text-left">
                                <span>{{$order->email}}</span>
                            </td>

                            <td>
                                <span>{{$order->phone}}</span>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    <h3 class="card-title  p-1">Chi tiết đơn hàng</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 10%; text-align: left">
                                Stt
                            </th>
                            <th style="width: 30%; text-align: left">
                                Tên Sản phẩm
                            </th>

                            <th style="width: 10%; text-align: left">
                                Số lượng
                            </th>

                            <th style="width: 15%; text-align: left">
                                Giá
                            </th>

                            <th style="width: 15%; text-align: left">
                                Tổng tiền
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @php($i = 0)
                        @foreach($order->products as $product)
                            <tr>
                                <td>
                                    {{$i += 1}}
                                </td>

                                <td>
                                    {{$product->name}}
                                </td>

                                <td style="padding: 0 30px">
                                    {{$product->pivot->quantity}}
                                </td>

                                <td>
                                    {{number_format($product->discount, 0, ',', '.')}}
                                </td>

                                <td>
                                    {{number_format(($product->discount * $product->pivot->quantity) , 0, ',', '.')}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    <h3 class="card-title p-1">Thanh Toán</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 25%">
                                Phương thức
                            </th>
                            <th style="width: 20%">
                                Mã Giảm giá
                            </th>

                            <th style="width: 20%">
                                Giảm
                            </th>

                            <th style="width: 20%">
                                Phí giao hàng
                            </th>

                            <th style="width: 20%;">
                                Tổng tiền
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                {{$order->payment->name}}
                            </td>
                            @if(isset($order->coupon))
                                <td>
                                    {{$order->coupon->code}}
                                </td>

                                <td>
                                    {{$order->coupon->condition === 1 ? $order->coupon->count . '%' : number_format($order->coupon->count, 0, ',', '.')}}
                                </td>
                            @else
                                <td>
                                    Không có
                                </td>

                                <td>
                                    0
                                </td>
                            @endif
                            <td>
                                {{number_format($order->ship->price, 0, ',', '.')}}
                            </td>

                            <td>
                                {{number_format($totalPrice , 0, ',', '.')}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection


