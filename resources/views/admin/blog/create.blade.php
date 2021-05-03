@extends('layouts.admin')

@section('title')
    <title>Blog| add</title>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
@endsection

@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/tinymce.min.js"></script>
    <script src="{{asset('backend/common/product/create.js')}}"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'blogs', 'action' => 'add'])


    <!-- Main content -->
        <section class="content">
            <form action="{{route('blogs.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thêm bài viết</h3>
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
                                        <label for="inputName">Tên bài viết</label>
                                        <div class="input-group">
                                            <input type="text"
                                                   name="name_vn"
                                                   id="inputName"
                                                   class="form-control mr-1"
                                                   placeholder="Nhập tiêu đề bài viết"
                                                   class="form-control"
                                            >

                                            <input type="text"
                                                   name="name_en"
                                                   id="inputName2"
                                                   class="form-control ml-1"
                                                   placeholder="Enter post name"
                                                   class="form-control"
                                            >

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="inputFile">Hình ảnh mô tả</label>

                                        <input
                                                type="file"
                                                name="featured_img"
                                                id="inputFile"
                                                class="form-control-file"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label for="inputStatus">Chọn danh mục bài viết</label>
                                        <select
                                                id="inputBlogCategory"
                                                name="category_id"
                                                class="form-control custom-select"
                                        >
                                            <option value="">Chọn danh mục bài viết</option>
                                            @foreach($blogCategories as $blogCategory)
                                                <option value="{{$blogCategory->id}}">{{$blogCategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputTitle">Tiêu đề</label>
                                        <textarea
                                                id="inputTitle"
                                                name="title_vn"
                                                class="form-control tiny-editor"
                                                rows="3">
                                            </textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputTitle2">Title(en)</label>
                                        <textarea
                                                id="inputTitle2"
                                                name="title_en"
                                                class="form-control tiny-editor"
                                                rows="3">
                                                </textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputDescription">Nội dung</label>
                                        <textarea

                                                id="inputDescription"
                                                name="content_vn"
                                                class="form-control tiny-editor"
                                                rows="6">

                                        </textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputDescription2">Content(en)</label>
                                        <textarea
                                                id="inputDescription2"
                                                name="content_en"
                                                class="form-control tiny-editor"
                                                rows="6">
                                            </textarea>
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


