<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-header d-flex flex-row align-content-center">
            <div class="card-tools mr-1">
                <form action="{{route('menus.index')}}" method="get">
                    <div class="input-group input-group-sm" style="width: 150px; margin-top: 5px">
                        <input type="text" name="name" class="form-control float-right" placeholder="Tìm kiếm...">
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
                    <a href="{{$sort_name}}" class="dropdown-item">Tên</a>
                    <a href="{{$sort_default}}" class="dropdown-item">Mặc định</a>
                </div>
            </div>

            @if(session('message') && session('type'))
                <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
            @endif

            <div class="card-tools d-flex flex-row">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <a href="{{route('menus.create')}}" class="btn btn-success btn-sm m-1">
                    Add
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects example1">
                <thead>
                <tr>
                    <th class="border-right" style="width: 1%">
                        #
                    </th>
                    <th  style="width: 89%; text-align: left">
                        Tên menu
                    </th>

                    <th class="border-left" style="float: right; margin-right: 10px">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @if($latestMenus )
                    @foreach($latestMenus as $menu)
                        <tr>
                            <td>
                                {{$menu->id}}
                            </td>
                            <td class="text-left">
                                <a>
                                    {{$menu->name}}
                                </a>
                            </td>

                            <td class="project-actions text-center">
                                <a class="btn btn-info btn-sm m-1" href="{{route('menus.edit', ['id' => $menu->id])}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>

                                </a>
                                <a class="btn btn-danger btn-sm m-1" data-action="btnDelete" data-name="{{$menu->name}}" data-url="{{route('menus.destroy', ['id'=> $menu->id])}}" >
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
            {{$latestMenus->appends(request()->query())->links()}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>