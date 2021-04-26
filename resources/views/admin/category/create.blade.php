@extends('layouts.admin')
@section('title')
    <title>Categories add</title>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'categories', 'action' => 'add'])


    <!-- Main content -->
        <section class="content">
            <form action="{{route('categories.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thêm danh mục</h3>
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
                                        <label for="inputName">Tên danh mục</label>
                                        <input type="text" name="name" id="inputName" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputStatus">Chọn danh mục cha</label>
                                        <select id="inputStatus" name="parent_id" class="form-control custom-select">
                                            <option value="0">Chọn danh mục cha</option>
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
                        <input type="submit" value="Thêm" class="btn btn-success float-left">
                    </div>
                </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
@endsection


