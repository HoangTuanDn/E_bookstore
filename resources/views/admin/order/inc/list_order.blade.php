<section class="content">
@if($orders)
    <!-- Default box -->
        <div class="card">

            <div class="card-header d-flex flex-row align-content-center">

                <div class="card-tools mr-1">
                    <form action="{{route('orders.index')}}" method="get">
                        <div class="input-group input-group-sm" style="width: 150px; margin-top: 5px">
                            <input type="text" name="code" class="form-control float-right" placeholder="Tìm kiếm...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="dropdown flex-grow-1">
                    <button style="margin-top: 5px" class="btn btn-default btn-sm dropdown-toggle mr-1" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sắp xếp
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <a href="{{$sort_default}}" class="dropdown-item">Mặc định</a>
                        <a href="{{$sort_status}}" class="dropdown-item">Trạng thái</a>
                        <a href="{{$sort_date}}" class="dropdown-item">Ngày cập nhật</a>
                    </div>
                </div>

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
                <table class="table table-striped projects" id="example1">
                    <thead>
                    <tr>
                        <th class="border-right" style="width: 1%">
                            #
                        </th>
                        <th style="width: 17%">
                            Mã đơn hàng
                        </th>

                        <th style="width: 17%">
                            Ngày đặt hàng
                        </th>

                        <th style="width: 17%">
                            Ngày cập nhật
                        </th>

                        <th style="width: 21%;">
                            Tình trạng
                        </th>

                        <th style="width: 12%; text-align: center">
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

                            <td class="project-actions text-center">
                                <a class="btn btn-outline-info btn-sm m-1" href="{{route('orders.show', ['id' => $order->id])}}">
                                    <i class="fas fa-eye">
                                    </i>
                                </a>
                                <a class="btn btn-outline-danger btn-sm m-1" data-action="btnDelete" data-name="{{$order->order_code}}" data-url="{{route('orders.destroy', ['id'=> $order->id])}}" >
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
                {{$orders->appends(request()->query())->links()}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endif

</section>