@extends('layouts.admin')

@section('title')
    <title>User update</title>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
@endsection

@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        @include('partials.breadcrumb',['module' => 'users', 'action' => 'edit'])
        <!-- Main content -->
        <section class="content">
            <form action="{{route('users.update', ['id'=> $user->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Cập nhật quản trị viên</h3>
                                @if($errors->any())
                                    <p id="error-message" data-message="{{$errors->first()}}"></p>
                                @endif
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="inputName">Username</label>

                                    <input
                                            type="text"
                                            name="name"
                                            id="inputName"
                                            class="form-control"
                                            value="{{$user->name}}"
                                            placeholder="Nhập tên"
                                    >

                                </div>

                                <div class="form-group">
                                    <label for="inputEmail">Email</label>

                                    <input
                                            type="text"
                                            name="email"
                                            id="inputEmail"
                                            class="form-control"
                                            value="{{$user->email}}"
                                            placeholder="Nhập email"
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword">Password</label>

                                    <input
                                            type="text"
                                            name="password"
                                            id="inputPassword"
                                            class="form-control"
                                            placeholder="Nhập password"
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="inputFile">Hình ảnh đại diện</label>

                                    <input
                                            type="file"
                                            name="image_user"
                                            id="inputFile"
                                            class="form-control-file"
                                    >
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="col-md-3 user-img">
                                        <img style="width: 100%; margin-left: -15px ; margin-right: 25px"
                                             src="{{$user->image_path}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputRoles">Chọn vai trò</label>
                                    <select
                                            id="inputRoles"
                                            name="roles[]"
                                            class="form-control custom-select"
                                            multiple="multiple"

                                    >
                                        <option value="">Chọn vai trò</option>
                                        @foreach($roles as $role)


                                            <option
                                                    {{$roleOfUser->contains('id', $role->id) ? 'selected' : ''}}        value="{{$role->id}}">
                                                {{$role->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2">
                        <input type="submit" value="Cập nhật" class="btn btn-success float-left">
                    </div>
                </div>
            </form>

        </section>
        <!-- /.content -->
    </div>
@endsection


