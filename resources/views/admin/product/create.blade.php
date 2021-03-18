@extends('layouts.admin')

@section('title')
    <title>Product add</title>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('backend/common/product/product.css')}}" rel="stylesheet" />
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
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product add</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">product add</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thêm sản phẩm</h3>
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

                                        <input
                                                type="text"
                                                name="name"
                                                id="inputName"
                                                class="form-control"
                                                placeholder="Nhập tên sản phẩm"
                                        >

                                    </div>

                                    <div class="form-group">
                                        <label for="inputPrice">Giá sản phẩm</label>

                                        <input
                                                type="text"
                                                name="price"
                                                id="inputPrice"
                                                class="form-control"
                                                placeholder="Nhập giá sản phẩm"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label for="inputFile">Hình ảnh đại diện</label>

                                        <input
                                                type="file"
                                                name="featured_img"
                                                id="inputFile"
                                                class="form-control-file"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label for="inputFile">Hình ảnh chi tiết</label>

                                        <input
                                                multiple
                                                type="file"
                                                name="image_detail[]"
                                                id="inputFile"
                                                class="form-control-file"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label for="inputStatus">Chọn danh mục</label>
                                        <select
                                                id="inputStatus"
                                                name="category_id[]"
                                                class="form-control custom-select"
                                                multiple="multiple"
                                        >
                                            {!!$htmlOption !!}
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputTag">Nhập tags cho sản phẩm</label>
                                        <select
                                                id="inputTag"
                                                name="tags[]"
                                                class="form-control"
                                                multiple="multiple"
                                        >
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputDescription">Mô tả nội dung</label>
                                        <textarea

                                                id="inputDescription"
                                                name="contents"
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


