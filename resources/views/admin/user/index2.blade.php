@extends('layouts.admin')

@section('title')
    <title>Users</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('backend/common/product/product.css')}}" rel="stylesheet" />

@endsection


@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{asset('backend/common/user/list.js')}}"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'users'])


    <!-- Main content -->
        <section class="content">
        @if($users)
            <!-- Default box -->
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Quản trị viên</h3>
                        @if(session('message') && session('type'))
                            <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
                        @endif

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <a href="{{route('users.create')}}" class="btn btn-success">
                                Add
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th class="border-right" style="width: 1%">
                                    #
                                </th>
                                <th style="width: 20%">
                                    User name
                                </th>

                                <th style="width: 10%; text-align: center">
                                    Hình ảnh
                                </th>

                                <th style="width: 25%; text-align: center">
                                    Email

                                </th>

                                <th style="width: 20%; text-align: center">
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
                                        <img class="product-image" src="{{$user->image_path}}">
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
                                        <a class="btn btn-info btn-sm" href="{{route('users.edit', ['id' => $user->id])}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                        <a class="btn btn-danger btn-sm" data-action="btnDelete" data-name="{{$user->name}}" data-url="{{route('users.destroy', ['id'=> $user->id])}}" >
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
                        {{$users->links()}}
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


