@extends('layouts.admin')

@section('title')
    <title>Roles</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
{{--    <link href="{{asset('backend/common/user/user.css')}}" rel="stylesheet" />--}}

@endsection


@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{asset('backend/common/role/list.js')}}"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'roles'])

        <!-- Main content -->
        <section class="content">
        @if($roles)
            <!-- Default box -->
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Vai trò hệ thống</h3>
                        @if(session('message') && session('type'))
                            <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
                        @endif

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <a href="{{route('roles.create')}}" class="btn btn-success">
                                Add
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th class="border-right" style="width: 2%">
                                    #
                                </th>
                                <th style="width: 20%; text-align: left">
                                    Tên
                                </th>


                                <th style="width: 30%; text-align: left">
                                    Mô tả vai trò
                                </th>

                                <th style="width: 30%; text-align: left">
                                    Quền
                                </th>

                                <th class="border-left" style="float: right; margin-right: 10px">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr >
                                    <td >
                                        <span data-id="{{$role->id}}">{{$role->id}}</span>
                                    </td>
                                    <td class="text-left" >
                                        {{$role->name}}
                                    </td>
                                    <td class="text-left">
                                        {{$role->display_name}}
                                    </td>

                                    <td class="text-left ">
                                       @if($role->permissions)
                                            @foreach($role->permissions as $permission)
                                                <span class="mr-1 mt-1 d-inline-block bg-gradient-indigo p-1 bord rounded">{{$permission->name}}</span>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm" href="{{route('roles.edit', ['id' => $role->id])}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                        <a class="btn btn-danger btn-sm" data-action="btnDelete" data-name="{{$role->name}}" data-url="{{route('roles.destroy', ['id'=> $role->id])}}" >
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
                        {{$roles->links()}}
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


