@extends('layouts.admin')

@section('title')
    <title>Blog| edit</title>
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
    @include('partials.breadcrumb',['module' => 'blogs', 'action' => 'edit'])

        <!-- Main content -->
        <section class="content">
            <form action="{{route('blogs.update', ['id' => $blog->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Cập nhật bài viết</h3>
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
                                    <label for="inputName">Tên sản phẩm</label>

                                    <div class="input-group">
                                        <input type="text"
                                               name="name_vn"
                                               id="inputName"
                                               class="form-control mr-1"
                                               placeholder="Nhập tiêu đề bài viết"
                                               class="form-control"
                                               value="{{$blog->getTranslation('name', 'vn')}}"
                                        >

                                        <input type="text"
                                               name="name_en"
                                               id="inputName"
                                               class="form-control ml-1"
                                               placeholder="Enter post name"
                                               class="form-control"
                                               value="{{$blog->getTranslation('name', 'en')}}"
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

                                <div class="col-md-12 mb-3">
                                    <div class="col-md-3 featured-img">
                                        <img style="width: 100%; margin-left: -15px ; margin-right: 25px" src="{{$blog->featured_img}}">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="inputStatus">Chọn danh mục</label>
                                    <select
                                            id="inputStatus"
                                            name="category_id"
                                            class="form-control custom-select"
                                    >
                                        <option value="">Chọn danh mục bài viết</option>
                                        @foreach($blogCategories as $blogCategory)
                                            <option {{$blogCategory->id === $blog->category_id ? 'selected' : ''}} value="{{$blogCategory->id}}">{{$blogCategory->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="inputTitle">Tiêu đề</label>
                                    <textarea
                                            id="inputTitle"
                                            name="title_vn"
                                            class="form-control tiny-editor"
                                            rows="3">{{$blog->getTranslation('title', 'vn')}}
                                            </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="inputTitle2">Title(en)</label>
                                    <textarea
                                            id="inputTitle"
                                            name="title_en"
                                            class="form-control tiny-editor"
                                            rows="3">{{$blog->getTranslation('title', 'en')}}
                                                </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="inputDescription">Nội dung</label>
                                    <textarea

                                            id="inputDescription"
                                            name="content_vn"
                                            class="form-control tiny-editor"
                                            rows="6">{{$blog->getTranslation('content', 'vn')}}

                                        </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="inputDescription2">Content(en)</label>
                                    <textarea
                                            id="inputDescription2"
                                            name="content_en"
                                            class="form-control tiny-editor"
                                            rows="6">{{$blog->getTranslation('content', 'en')}}
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
                        <input type="submit" value="Cập nhật" class="btn btn-success float-left">
                    </div>
                </div>
            </form>

        </section>
        <!-- /.content -->
    </div>
@endsection


