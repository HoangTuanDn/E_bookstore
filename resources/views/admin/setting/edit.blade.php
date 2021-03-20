@extends('layouts.admin')

@section('title')
    <title>Slider edit</title>
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
    @include('partials.breadcrumb',['module' => 'settings', 'action' => 'edit'])


    <!-- Main content -->
        <section class="content">
            <form action="{{route('settings.update', ['id' => $setting->id])}}" method="post" >
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Cập nhật cấu hình</h3>
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
                                    <label for="inputName">Khóa (key)</label>

                                    <input
                                            type="text"
                                            name="config_key"
                                            id="inputName"
                                            value="{{$setting->config_key}}"
                                            class="form-control"
                                            placeholder="Nhập key"
                                    >

                                </div>


                                <div class="form-group">
                                    <label for="inputType">Loại</label>

                                    <input
                                            type="text"
                                            name="type"
                                            id="inputType"
                                            value="{{$setting->type}}"
                                            class="form-control"
                                            placeholder="Nhập type"
                                    >

                                </div>

                                @if($setting->type === 'text')

                                    <div class="form-group">
                                        <label for="inputValue">Giá trị</label>

                                        <input
                                                type="text"
                                                name="config_value"
                                                id="inputValue"
                                                class="form-control"
                                                value="{{$setting->config_value}}"
                                        >

                                    </div>

                                @elseif($setting->type === 'textarea')

                                    <div class="form-group">
                                        <label for="inputValue">Giá trị</label>
                                        <textarea

                                                id="inputValue"
                                                name="config_value"
                                                class="form-control"
                                                rows="3">{{$setting->config_value}}

                                        </textarea>
                                    </div>

                                @endif


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


