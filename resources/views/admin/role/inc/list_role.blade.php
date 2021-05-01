<section class="content">
@if($roles)
    <!-- Default box -->
        <div class="card">
            <div class="card-header d-flex flex-row align-content-center">

                <div class="card-tools mr-1">
                    <form action="{{route('roles.index')}}" method="get">
                        <div class="input-group input-group-sm" style="width: 150px; margin-top: 5px">
                            <input type="text" name="name" class="form-control float-right"
                                   placeholder="Tên vai trò...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="dropdown flex-grow-1">
                    <button style="margin-top: 5px" class="btn btn-default btn-sm dropdown-toggle mr-1" type="button"
                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sắp xếp
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @if($order === 'asc')
                            <a href="{{$sort_default}}" class="dropdown-item">Mặc định <i class="fas fa-sort-down"></i></a>
                            <a href="{{$sort_name}}" class="dropdown-item">Tên <i class="fas fa-sort-down"></i></a>
                        @else
                            <a href="{{$sort_default}}" class="dropdown-item">Mặc định <i
                                        class="fas fa-sort-up"></i></a>
                            <a href="{{$sort_name}}" class="dropdown-item">Tên <i class="fas fa-sort-up"></i></a>
                        @endif
                    </div>
                </div>

                @if(session('message') && session('type'))
                    <p id="session-message" data-message="{{session('message')}}"
                       data-type="{{session('type')}}"></p>
                @endif

                <div class="card-tools d-flex flex-row">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    @can('role-create')
                        <a href="{{route('roles.create')}}" class="btn btn-success btn-sm m-1">
                            Add
                        </a>
                    @endcan
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects example1">
                    <thead>
                    <tr>
                        <th class="border-right" style="width: 2%">
                            #
                        </th>
                        <th style="width: 25%; text-align: left">
                            Tên
                        </th>


                        <th style="width: 29%; text-align: left">
                            Mô tả vai trò
                        </th>

                        <th style="width: 33%; text-align: left">
                            Quền
                        </th>

                        <th class="border-left" style="float: right; margin-right: 10px">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>
                                <span data-id="{{$role->id}}">{{$role->id}}</span>
                            </td>
                            <td class="text-left">
                                {{$role->name}}
                            </td>
                            <td class="text-left">
                                {{$role->display_name}}
                            </td>

                            <td class="text-left ">
                                @if(isset($rolePermission[$role->id]))
                                    @foreach($rolePermission[$role->id] as $permission)
                                        @if(isset($permission['full_name']))
                                            <span class="mr-1 mt-1 d-inline-block bg-gradient-indigo p-1 bord rounded">{{$permission['full_name']}}</span>
                                        @else
                                            @foreach($permission['name'] as $name)
                                                <span class="mr-1 mt-1 d-inline-block bg-gradient-indigo p-1 bord rounded">{{$name}}</span>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </td>

                            <td class="project-actions text-center">
                                @can('role-update')
                                    <a class="btn btn-outline-info btn-sm m-1"
                                       href="{{route('roles.edit', ['id' => $role->id])}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>

                                    </a>
                                @endcan
                                @can('role-delete')
                                    <a class="btn btn-outline-danger btn-sm m-1" data-action="btnDelete"
                                       data-name="{{$role->name}}"
                                       data-url="{{route('roles.destroy', ['id'=> $role->id])}}">
                                        <i class="fas fa-trash">
                                        </i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col-md-5 mt-3">
                {{$roles->appends(request()->query())->links()}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endif

</section>