@extends('layouts.admin')
@section('title')
    <title>Blog|categories edit</title>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'blog_categories', 'action' => 'edit'])


    <!-- Main content -->
        <section class="content">
            <form action="{{route('blog_categories.update', ['id'=> $blogCategory->id])}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Cập nhật danh mục</h3>
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
                                        <label for="inputName">Tên danh mục(vn)</label>
                                        <input type="text" name="name_vn" id="inputName" value="{{$blogCategory->getTranslation('name', 'vn')}}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputName">Category name(en)</label>
                                        <input type="text" name="name_en" id="inputName" value="{{$blogCategory->getTranslation('name', 'en')}}" class="form-control">
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


