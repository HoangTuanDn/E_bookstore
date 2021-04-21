<section class="content">
@if($users)
    <!-- Default box -->
        <div class="card">

            <div class="card-header d-flex flex-row align-content-center">

                <div class="card-tools mr-1">
                    <form action="{{route('users.index')}}" method="get">
                        <div class="input-group input-group-sm" style="width: 150px; margin-top: 5px">
                            <input type="text" name="username" class="form-control float-right" placeholder="Tên user...">
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
                             <a href="{{$sort_name}}" class="dropdown-item">username <i class="fas fa-sort-down"></i></a>
                         @else
                             <a href="{{$sort_default}}" class="dropdown-item">Mặc định <i class="fas fa-sort-up"></i></a>
                             <a href="{{$sort_name}}" class="dropdown-item">username <i class="fas fa-sort-up"></i></a>
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
                    <a href="{{route('users.create')}}" class="btn btn-success btn-sm m-1">
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
                        <th style="width: 22%">
                            User name
                        </th>

                        <th style="width: 10%; text-align: center">
                            Hình ảnh
                        </th>

                        <th style="width: 27%; text-align: center">
                            Email

                        </th>

                        <th style="width: 27%; text-align: center">
                            Vai trò
                        </th>

                        <th class="border-left" style="float: right; margin-right: 10px">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                {{$user->id}}
                            </td>
                            <td>
                                {{$user->name}}
                            </td>
                            <td>
                                <img src="{{$user->image_path}}"  class="img-circle img-size-64 mr-2">
                            </td>

                            <td class="text-center">
                                {{$user->email}}
                            </td>

                            <td class="text-center">
                                @foreach($user->roles as $role)
                                    <span class="mt-1 bg-gradient-indigo p-1 bord rounded d-inline-block">{{$role->name}}</span>
                                @endforeach
                            </td>

                            <td class="project-actions text-right">
                                <a class="btn btn-outline-info btn-sm m-1" href="{{route('users.edit', ['id' => $user->id])}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>

                                </a>
                                <a class="btn btn-outline-danger btn-sm m-1" data-action="btnDelete" data-name="{{$user->name}}" data-url="{{route('users.destroy', ['id'=> $user->id])}}" >
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
                {{$users->appends(request()->query())->links()}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endif

</section>