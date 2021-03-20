@extends('layouts.admin')

@section('title')
    <title>Permission update</title>
@endsection

@section('css')
    {{--    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />--}}
@endsection

@section('js_link')
    <script src="{{asset('backend/common/permission/create.js')}}"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'permissions', 'action' => 'edit'])

    <!-- Main content -->
        <section class="content">
            <form action="{{route('permissions.update', ['id'=>$permission->id])}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Cập nhật quyền truy cập</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="inputName">Tên quyền</label>
                                    <input type="text" value="{{$permission->name}}" name="name" id="inputName" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="inputKeyCode">Key code</label>
                                    <input type="text" value="{{$permission->key_code}}" name="key_code" id="inputKeyCode" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="inputDescription">Tên hiển thị</label>
                                    <textarea type="text" name="display_name" id="inputDescription" class="form-control">{{$permission->display_name}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="inputParentId">Chọn nhóm quyền</label>
                                    <select id="inputParentId" name="parent_id" class="form-control custom-select">
                                        @foreach($groupPermissions as $gPermission)
                                                <option
                                                        value="{{$gPermission->id}}"
                                                        {{$permission->parent_id === $gPermission->id ? 'selected' : ''}}}
                                                >
                                                    {{$gPermission->name}}
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


