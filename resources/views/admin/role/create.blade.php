@extends('layouts.admin')

@section('title')
    <title>Role add</title>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('backend/common/role/role.css')}}" rel="stylesheet" />
@endsection

@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('backend/common/role/create.js')}}"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'roles', 'action' => 'add'])


    <!-- Main content -->
        <section class="content">
            <form action="{{route('roles.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thêm vai trò</h3>
                                @if($errors->any())
                                    <p id="error-message" data-message="{{$errors->first()}}"></p>
                                @endif
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="inputName">Tên vai trò</label>

                                    <input
                                            type="text"
                                            name="name"
                                            id="inputName"
                                            class="form-control"
                                            placeholder="Nhập tên"
                                    >

                                </div>

                                <div class="form-group">
                                    <label for="inputDisplayName">Mô tả vai trò</label>

                                    <textarea
                                            name="display_name"
                                            id="inputDisplayName"
                                            class="form-control"
                                            placeholder="Nhập mô tả"
                                    ></textarea>
                                </div>

                                @foreach($permissions as $permission)
                                    <div class="form-group">
                                        <div class="card bg-light mb-3" style="max-width: 100%;">
                                            <div class="card-header">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input check-warapper" name="permission_group" value="{{$permission->id}}" type="checkbox" id="inline{{$permission->key_code}}" >
                                                    <label class="form-check-label" for="inlineCheckbox1">{{$permission->name}}</label>
                                                </div>
                                            </div>
                                                <div class="card-body custom-body">
                                                    @foreach($permission->permissions as $ofPermission)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input check-children" value="{{$ofPermission->id}}" name="permission[]" type="checkbox" id="inlineCheckbox{{$ofPermission->key_code}}">
                                                        <label class="form-check-label" for="inlineCheckbox1">{{$ofPermission->name}}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2">
                        <input type="submit" value="Thêm" class="btn btn-success float-left">
                    </div>
                </div>
            </form>

        </section>
        <!-- /.content -->
    </div>
@endsection


