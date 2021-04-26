@extends('layouts.admin')
@section('title')
    <title>Blog categories add</title>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'blog_categories', 'action' => 'add'])


    <!-- Main content -->
        <section class="content">
            <form action="{{route('blog_categories.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thêm danh mục bài viết</h3>
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
                                        <label for="inputNameVn">Tên danh mục(vn)</label>
                                        <input type="text" name="name_vn" id="inputNameVn" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputNameEn">Category name(en)</label>
                                        <input type="text" name="name_en" id="inputNameEn" class="form-control">
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


