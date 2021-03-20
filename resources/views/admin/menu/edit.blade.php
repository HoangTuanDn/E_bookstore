@extends('layouts.admin')
@section('title')
    <title>Menus edit</title>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'menus', 'action' => 'edit'])


    <!-- Main content -->
        <section class="content">
            <form action="{{route('menus.update', ['id'=> $menu->id])}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Cập nhật menu</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">

                                    <div class="form-group">
                                        <label for="inputName">Tên menu</label>
                                        <input type="text" name="name" id="inputName" value="{{$menu->name}}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputStatus">Chọn menu cha</label>
                                        <select id="inputStatus" name="parent_id" class="form-control custom-select">
                                            <option value="0">Chọn menu cha</option>
                                            {!!$htmlOption !!}
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


