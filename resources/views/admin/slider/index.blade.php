@extends('layouts.admin')

@section('title')
    <title>Slider</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />

@endsection


@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{asset('backend/common/slider/list.js')}}"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'sliders'])

    <!-- Main content -->
        <section class="content">
        @if($sliders)
            <!-- Default box -->
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Slider</h3>
                    @if(session('message') && session('type'))
                        <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
                    @endif

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a href="{{route('sliders.create')}}" class="btn btn-success">
                           Add
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th class="border-right text-center" style="width: 1%">
                                #
                            </th>
                            <th style="width: 20%">
                                Tên slider
                            </th>

                            <th  style="width: 20%; text-align: center">
                                Hình ảnh
                            </th>

                            <th class="border-left" style="float: right; margin-right: 10px">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($sliders as $slider)
                                <tr>
                                    <td>
                                        {{$slider->id}}
                                    </td>
                                    <td>
                                        {{$slider->name}}
                                    </td>
                                    <td>
                                        <img class="product-image" src="{{$slider->image_path}}">
                                    </td>


                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm" href="{{route('sliders.edit', ['id' => $slider->id])}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                        <a class="btn btn-danger btn-sm" data-action="btnDelete" data-name="{{$slider->name}}" data-url="{{route('sliders.destroy', ['id'=> $slider->id])}}" >
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="col-md-5 mt-3">
                    {{$sliders->links()}}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        @endif

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


