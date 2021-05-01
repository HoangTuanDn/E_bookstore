@extends('layouts.admin')

@section('title')
    <title>Slider add</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
@endsection

@section('js_link')
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('partials.breadcrumb',['module' => 'sliders', 'action' => 'add'])

        <!-- Main content -->
        <section class="content">
            <form action="{{route('sliders.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thêm slider</h3>
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
                                        <label for="inputName">Tên slider</label>

                                        <input
                                                type="text"
                                                name="name"
                                                id="inputName"
                                                class="form-control"
                                                placeholder="Nhập tên sản phẩm"
                                        >

                                    </div>


                                    <div class="form-group">
                                        <label for="inputFile">Hình ảnh</label>

                                        <input
                                                type="file"
                                                name="image"
                                                id="inputFile"
                                                class="form-control-file"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label for="inputDescription">Mô tả nội dung</label>
                                        <textarea

                                                id="inputDescription"
                                                name="description"
                                                class="form-control"
                                                rows="2">

                                        </textarea>
                                    </div>

                                <div class="form-group">
                                    <div class="card bg-light mb-3" style="max-width: 100%;">
                                        <div class="card-header">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="checkPage">Background image</label>
                                            </div>
                                        </div>
                                        <div class="card-body custom-body">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input check-children" value="3" name="bgImage" type="radio" id="inlineCheckbox" value="option1">
                                                    <label class="form-check-label" for="inlineCheckbox1">Img 3 - shop single</label>
                                                </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input check-children" value="4" name="bgImage" type="radio" id="inlineCheckbox" value="option1">
                                                <label class="form-check-label" for="inlineCheckbox1">Img 4 - blog</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input check-children" value="5" name="bgImage" type="radio" id="inlineCheckbox" value="option1">
                                                <label class="form-check-label" for="inlineCheckbox1">Img 5 - shop</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input check-children" value="6" name="bgImage" type="radio" id="inlineCheckbox" value="option1">
                                                <label class="form-check-label" for="inlineCheckbox1">Img 6 - contact</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input check-children" value="8" name="bgImage" type="radio" id="inlineCheckbox" value="option1">
                                                <label class="form-check-label" for="inlineCheckbox1">Img 8 - home 1</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input check-children" value="9" name="bgImage" type="radio" id="inlineCheckbox" value="option1">
                                                <label class="form-check-label" for="inlineCheckbox1">Img 9 - home 2</label>
                                            </div>

                                        </div>
                                    </div>
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


