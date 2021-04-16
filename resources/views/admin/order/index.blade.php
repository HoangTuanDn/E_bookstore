@extends('layouts.admin')

@section('title')
    <title>Orders</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
    {{--<link href="{{asset('backend/common/product/product.css')}}" rel="stylesheet" />--}}

@endsection


@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{asset('backend/common/order/order.js')}}"></script>
    <script src="{{asset('backend/common/Mail/confirmEmail.js')}}"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'orders'])

    <!-- Main content -->
        <section class="content">
        @if($orders)
            <!-- Default box -->
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Đơn hàng</h3>
                        @if(session('message') && session('type'))
                            <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
                        @endif

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
                                <th class="border-right" style="width: 1%">
                                    #
                                </th>
                                <th style="width: 15%">
                                    Mã đơn hàng
                                </th>

                                <th style="width: 20%">
                                    Ngày đặt hàng
                                </th>

                                <th style="width: 20%">
                                    Ngày cập nhật
                                </th>

                                <th style="width: 15%;">
                                    Tình trạng
                                </th>

                                <th style="width: 10%;">
                                    Gửi mail
                                </th>

                                <th class="border-left" style="float: right; margin-right: 10px">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        {{$order->id}}
                                    </td>
                                    <td>
                                        {{$order->order_code}}
                                    </td>

                                    <td>
                                        {{$order->created_at}}
                                    </td>

                                    <td class="date-update">
                                        {{$order->updated_at}}
                                    </td>

                                    <td>
                                        <select data-url="{{route('orders.update', ['id'=> $order->id])}}" id="order_status" name="status"  data-action="change-status" class="form-control custom-select">
                                            <option {{$order->status === 0 ? 'selected' : ''}} value="0">Đang chờ xác nhận</option>
                                            <option {{$order->status === 1 ? 'selected' : ''}} value="1">Đã xác nhận</option>
                                            <option {{$order->status === 2 ? 'selected' : ''}} value="2">Đang giao hàng</option>
                                            <option {{$order->status === 3 ? 'selected' : ''}} value="3">Đã giao hàng</option>
                                        </select>
                                    </td>

                                    <td class="confirm-email text-center">
                                        <a class="btn btn-outline-info btn-sm" data-action="btnSendMail" data-name="{{$order->order_code}}" href="{{route('mails.send_mail', ['id'=> $order->id])}}">
                                            <i class="fas fa-paper-plane">
                                            </i>
                                        </a>
                                    </td>

                                    <td class="project-actions text-right">
                                        <a class="btn btn-outline-info btn-sm" href="{{route('orders.show', ['id' => $order->id])}}">
                                            <i class="fas fa-eye">
                                            </i>
                                        </a>
                                        <a class="btn btn-outline-danger btn-sm" data-action="btnDelete" data-name="{{$order->order_code}}" data-url="{{route('orders.destroy', ['id'=> $order->id])}}" >
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5 mt-3">
                        {{$orders->links()}}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            @endif

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


