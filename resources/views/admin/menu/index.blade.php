@extends('layouts.admin')

@section('title')
    <title>Menus</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
@endsection


@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
    <script src="{{asset('backend/common/menu/menu.js')}}"></script>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Menus</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Menus</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách menu</h3>
                    @if(session('message') && session('type'))
                        <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
                    @endif

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a href="{{route('menus.create')}}" class="btn btn-success">
                           Add
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 1%">
                                #
                            </th>
                            <th style="width: 20%">
                                Tên menu
                            </th>

                            <th style="float: right; margin-right: 10px">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($latestMenus )
                            @foreach($latestMenus as $menu)
                                <tr>
                                    <td>
                                        {{$menu->id}}
                                    </td>
                                    <td>
                                        <a>
                                            {{$menu->name}}
                                        </a>
                                    </td>

                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm" href="{{route('menus.edit', ['id' => $menu->id])}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                        <a class="btn btn-danger btn-sm" data-action="btnDelete" data-name="{{$menu->name}}" data-url="{{route('menus.destroy', ['id'=> $menu->id])}}" >
                                            <i class="fas fa-trash">
                                            </i>

                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif


                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


