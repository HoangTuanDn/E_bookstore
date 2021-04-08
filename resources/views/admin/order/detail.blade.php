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
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header text-center">
                                <h3 class="card-title ">Thông tin vận chuyển</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped projects">
                                    <thead>
                                    <tr>
                                        <th style="width: 16%">
                                           Tên
                                        </th>
                                        <th style="width: 15%">
                                            Tỉnh/Thành phố
                                        </th>

                                        <th style="width: 15%">
                                            Quận/huyện
                                        </th>

                                        <th style="width: 15%;">
                                            Phường/xã
                                        </th>

                                        <th style="width: 10%;">
                                            Địa chỉ
                                        </th>

                                        <th style="width: 10%;">
                                            Số ĐT
                                        </th>

                                        <th style="width: 10%;">
                                            Email
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{$order->full_name}}
                                            </td>
                                            <td>
                                                {{$order->ship->province->name}}
                                            </td>

                                            <td>
                                                {{$order->ship->district->name}}
                                            </td>

                                            <td>
                                                {{$order->ship->ward->name}}
                                            </td>

                                            <td>
                                                {{$order->address}}
                                            </td>

                                            <td>
                                                {{$order->phone}}
                                            </td>

                                            <td>
                                                {{$order->email}}
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary ">
                        <div class="card-header text-center">
                            <h3 class="card-title ">Chi tiết đơn hàng</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th style="width: 10%">
                                        Stt
                                    </th>
                                    <th style="width: 20%">
                                        Tên Sản phẩm
                                    </th>
                                    <th style="width: 20%">
                                        Số lượng
                                    </th>

                                    <th style="width: 20%">
                                        Giá
                                    </th>

                                    <th style="width: 20%;">
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
                    <!-- /.card -->

                </div>
            </div>

                <div class="row">
                <div class="col-md-12 ">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thanh Toán</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
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
                    <!-- /.card -->

                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection


