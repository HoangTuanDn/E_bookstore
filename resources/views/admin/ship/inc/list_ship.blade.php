<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-header d-flex flex-row align-content-center flex-wrap">
            <div class="card-tools mr-1">
                <form action="{{route('ships.index')}}" method="get">
                    <div class="input-group input-group-sm" style="width: 250px; margin-top: 5px">
                        <input type="text" name="province_name" class="form-control float-right" placeholder="Tỉnh...">
                        <input type="text" name="district_name" class="form-control float-right" placeholder="Quận...">
                        <input type="text" name="ward_name" class="form-control float-right" placeholder="Xã...">
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
                    <a href="{{$sort_price}}" class="dropdown-item">Phí giao hàng</a>
                    <a href="{{$sort_province_name}}" class="dropdown-item">Tỉnh/thành</a>
                    <a href="{{$sort_district_name}}" class="dropdown-item">Quận/Huyện</a>
                    <a href="{{$sort_ward_name}}" class="dropdown-item">Phường/Xã</a>
                </div>
            </div>

            @if(session('message') && session('type'))
                <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
            @endif

            <div class="card-tools d-flex flex-row">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <a href="{{route('ships.create')}}" class="btn btn-success btn-sm m-1">
                    Add
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table  class="table table-striped projects example1">
                <thead>
                <tr>
                    <th class="border-right" style="width: 1%  ">
                        #
                    </th>
                    <th  style=" width: 20%;">
                        Tỉnh/Thành phố
                    </th>

                    <th  style="width: 20%;">
                        Quận/Huyện
                    </th>

                    <th  style=" width: 20%; ">
                        Phường/Xã
                    </th>

                    <th  style=" width: 20%;">
                        Phí ship
                    </th>

                    <th class="border-left" style="float: right; margin-right: 10px">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @if($ships )
                    @foreach($ships as $ship)
                        <tr>
                            <td>
                                {{$ship->id}}
                            </td>
                            <td>
                                <a>
                                    {{isset($ship->province->name)? $ship->province->name : 'Mặc định'}}
                                </a>
                            </td>

                            <td >
                                <a>
                                    {{isset($ship->district->name) ? $ship->district->name : 'Mặc định'}}
                                </a>
                            </td>

                            <td >
                                <a>
                                    {{isset($ship->ward->name) ? $ship->ward->name : 'Mặc định'}}
                                </a>
                            </td>

                            <td  data-url="{{route('ships.update', ['id' => $ship->id])}}" contenteditable data-action="change-price">
                                <a id="{{$ship->id}}-price">
                                    {{number_format($ship->price)}}
                                </a>
                            </td>

                            <td class="project-actions text-right">
                                <a class="btn btn-outline-danger btn-sm m-1" data-action="btnDelete" data-name="{{$ship->name}}" data-url="{{route('ships.destroy', ['id'=> $ship->id])}}" >
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
            {{$ships->appends(request()->query())->links()}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>