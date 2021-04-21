<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-header d-flex flex-row align-content-center">

            <div class="card-tools mr-1">
                <form action="{{route('permissions.index')}}" method="get">
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
                     @if($order === 'asc')
                         <a href="{{$sort_default}}" class="dropdown-item">Mặc định <i class="fas fa-sort-down"></i></a>
                         <a href="{{$sort_code}}" class="dropdown-item">Key code <i class="fas fa-sort-down"></i></a>
                     @else
                         <a href="{{$sort_default}}" class="dropdown-item">Mặc định <i class="fas fa-sort-up"></i></a>
                         <a href="{{$sort_code}}" class="dropdown-item">Key code <i class="fas fa-sort-up"></i></a>
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
                <a href="{{route('permissions.create')}}" class="btn btn-success btn-sm m-1">
                    Add
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects" id="example1">
                <thead>
                <tr>
                    <th class="border-right" style="width: 1%">
                        #
                    </th>
                    <th  style="width: 44%">
                        Tên quyền
                    </th>

                    <th  style="width: 44% ">
                        key code
                    </th>

                    <th class="border-left" style="float: right; margin-right: 10px">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @if($permissions )
                    @foreach($permissions as $permission)
                        <tr data-id="{{$permission->id}}">
                            <td>
                                {{$permission->id}}
                            </td>
                            <td class="text-left">
                                {{$permission->name}}
                            </td>

                            <td class="text-left">
                                {{$permission->key_code}}
                            </td>

                            <td class="project-actions text-center">
                                <a class="btn btn-outline-info btn-sm m-1" href="{{route('permissions.edit', ['id' => $permission->id])}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>

                                </a>
                                <a class="btn btn-outline-danger btn-sm m-1" data-action="btnDelete" data-name="{{$permission->name}}" data-url="{{route('permissions.destroy', ['id'=> $permission->id])}}" >
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
            {{$permissions->appends(request()->query())->links()}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>