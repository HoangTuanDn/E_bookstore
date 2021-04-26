<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header d-flex flex-row align-content-center">
            <div class="card-tools mr-1">
                <form action="{{route('coupons.index')}}" method="get">
                    <div class="input-group input-group-sm" style="width: 150px; margin-top: 5px">
                        <input type="text" name="name" class="form-control float-right" placeholder="Tên">
                        <input type="text" name="code" class="form-control float-right" placeholder="Mã">
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
                    @if($order === 'asc')
                        <a href="{{$sort_default}}" class="dropdown-item">Mặc định <i class="fas fa-sort-down"></i></a>
                        <a href="{{$sort_code}}" class="dropdown-item">Mã <i class="fas fa-sort-down"></i></a>
                        <a href="{{$sort_number}}" class="dropdown-item">Lần áp dụng <i class="fas fa-sort-down"></i></a>
                        <a href="{{$sort_condition}}" class="dropdown-item">Loại <i class="fas fa-sort-down"></i></a>
                    @else
                        <a href="{{$sort_default}}" class="dropdown-item">Mặc định <i class="fas fa-sort-up"></i></a>
                        <a href="{{$sort_code}}" class="dropdown-item">Mã <i class="fas fa-sort-up"></i></a>
                        <a href="{{$sort_number}}" class="dropdown-item">Lần áp dụng <i class="fas fa-sort-up"></i></a>
                        <a href="{{$sort_condition}}" class="dropdown-item">Loại <i class="fas fa-sort-up"></i></a>
                    @endif
                </div>
            </div>
            @if(session('message') && session('type'))
                <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
            @endif

            <div class="card-tools d-flex flex-row">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                @can('category-create')
                    <a href="{{route('coupons.create')}}" class="btn btn-success btn-sm m-1">
                        Add
                    </a>
                @endcan

            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects example1" >
                <thead>
                <tr>
                    <th class="border-right" style="width: 1%">
                        #
                    </th>
                    <th  style="width: 14%;">
                        Tên
                    </th>

                    <th  style="width: 14%;">
                        Mã giảm giá
                    </th>

                    <th  style="width: 14%;">
                        lần áp dụng
                    </th>

                    <th  style="width: 18%;">
                        Loại giảm
                    </th>

                    <th  style="width: 10%;">
                        Số giảm
                    </th>

                    <th  style="width: 14%; text-align: center">
                        Chia sẻ
                    </th>

                    <th class="border-left" style="float: right; margin-right: 10px">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @if($coupons )
                    @foreach($coupons as $coupon)
                        <tr>
                            <td>
                                {{$coupon->id}}
                            </td>
                            <td>
                                <a>
                                    {{$coupon->name}}
                                </a>
                            </td>

                            <td >
                                <a>
                                    {{$coupon->code}}
                                </a>
                            </td>

                            <td >
                                <a>
                                    {{$coupon->number}}
                                </a>
                            </td>

                            <td >
                                <a>
                                    {{$coupon->condition == 1 ? 'Giảm theo phần trăm' : 'Giảm theo tiền'}}
                                </a>
                            </td>

                            <td >
                                <a>
                                    @if($coupon->condition == 1)
                                        {{$coupon->count .'%'}}
                                    @else
                                        {{number_format($coupon->count, 0, ',', '.')}}
                                    @endif
                                </a>
                            </td>

                            <td class="project-actions text-center">
                                <a class="btn btn-outline-info btn-sm m-1" {{$coupon->is_publish == 1 ? 'style='."pointer-events:". "none".';'. "color:". "black" : ''}} data-action="btnShareCoupon" href="{{route('mails.share_coupon', ['id' => $coupon->id])}}" >
                                    <i class="fas fa-share-alt-square">
                                    </i>
                                </a>
                            </td>

                            <td class="project-actions text-center">
                                <a class="btn btn-outline-danger btn-sm m-1" data-action="btnDelete" data-name="{{$coupon->name}}" data-url="{{route('coupons.destroy', ['id'=> $coupon->id])}}" >
                                    <i class="fas fa-trash">
                                    </i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-5 mt-3">
            {{$coupons->appends(request()->query())->links()}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>