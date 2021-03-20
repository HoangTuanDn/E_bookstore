@extends('layouts.admin')

@section('title')
    <title>setting add</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
@endsection

@section('js_link')
{{--    <script src="{{asset('backend/common/slider/create.js')}}"></script>--}}
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection

@section('content')
    @include('partials.breadcrumb',['module' => 'settings', 'action' => 'add'])

    <!-- Main content -->
        <section class="content">
            <form action="{{route('settings.store')}}" method="post" >
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thêm cấu hình</h3>
{{--                                @if($errors->any())--}}
{{--                                    <p id="error-message" data-message="{{$errors->first()}}"></p>--}}
{{--                                @endif--}}
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">

                                    <div class="form-group">
                                        <label for="inputName">khóa (key)</label>

                                        <input
                                                type="text"
                                                name="config_key"
                                                id="inputName"
                                                class="form-control"
                                                placeholder="Nhập tên sản phẩm"
                                        >

                                    </div>

                                <div class="form-group">
                                    <input
                                            type="hidden"
                                            name="type"
                                            value="{{$type}}"
                                    >
                                </div>

                                @if(request()->type === 'text')

                                    <div class="form-group">
                                        <label for="inputValue">Giá trị</label>

                                        <input
                                                type="text"
                                                name="config_value"
                                                id="inputValue"
                                                class="form-control"
                                        >

                                    </div>

                                    @elseif(request()->type === 'textarea')

                                    <div class="form-group">
                                        <label for="inputValue">Giá trị</label>
                                        <textarea

                                                id="inputValue"
                                                name="config_value"
                                                class="form-control"
                                                rows="3">

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
                        <input type="submit" value="Thêm" class="btn btn-success float-left">
                    </div>
                </div>
            </form>

        </section>
        <!-- /.content -->
    </div>
@endsection


