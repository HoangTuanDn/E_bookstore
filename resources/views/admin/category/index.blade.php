@extends('layouts.admin')

@section('title')
    <title>Categories</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
@endsection


@section('js_link')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{asset('backend/common/category/category.js')}}"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'categories'])


    <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh mục sản phẩm</h3>
                    @if(session('message') && session('type'))
                        <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
                    @endif

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        @can('category-create')
                            <a href="{{route('categories.create')}}" class="btn btn-success">
                                Add
                            </a>
                        @endcan

                    </div>
                </div>
                @can('category-viewAny')
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th class="border-right" style="width: 1%">
                                #
                            </th>
                            <th style="width: 20%; text-align: center">
                                Tên danh mục
                            </th>

                            <th class="border-left"style="float: right; margin-right: 10px">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($latestCategories )
                            @foreach($latestCategories as $category)
                                <tr>
                                    <td>
                                        {{$category->id}}
                                    </td>
                                    <td class="text-center">
                                        <a>
                                            {{$category->name}}
                                        </a>
                                    </td>

                                    <td class="project-actions text-right">
                                        @can('category-update')
                                            <a class="btn btn-info btn-sm" href="{{route('categories.edit', ['id' => $category->id])}}">
                                                <i class="fas fa-pencil-alt">
                                                </i>

                                            </a>
                                        @endcan
                                        @can('category-delete')
                                                <a class="btn btn-danger btn-sm" data-action="btnDelete" data-name="{{$category->name}}" data-url="{{route('categories.destroy', ['id'=> $category->id])}}" >
                                                    <i class="fas fa-trash">
                                                    </i>
                                                </a>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
                @endcan
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


