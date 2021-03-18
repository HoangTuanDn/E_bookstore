@extends('layouts.admin')

@section('title')
    <title>Products</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('backend/common/product/product.css')}}" rel="stylesheet" />

@endsection


@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{asset('backend/common/product/list.js')}}"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Products</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
        @if($products)
            <!-- Default box -->
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Sản phẩm</h3>
                    @if(session('message') && session('type'))
                        <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
                    @endif

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a href="{{route('products.create')}}" class="btn btn-success">
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
                                Tên sản phẩm
                            </th>

                            <th style="width: 25%">
                                Hình ảnh
                            </th>

                            <th style="width: 20%; text-align: center">
                                Giá
                            </th>

                            <th style="width: 15%; text-align: center">
                                Danh mục
                            </th>

                            <th style="float: right; margin-right: 10px">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        {{$product->id}}
                                    </td>
                                    <td>
                                        {{$product->name}}
                                    </td>
                                    <td>
                                        <img class="product-image" src="{{$product->featured_img}}">
                                    </td>

                                    <td class="text-center">
                                        <span>{{number_format($product->price)}}</span>
                                    </td>

                                    <td>
                                        @foreach($product->categories as $category)
                                            <span class="product-category">{{$category->name}}</span>

                                        @endforeach
                                    </td>

                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm" href="{{route('products.edit', ['id' => $product->id])}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                        <a class="btn btn-danger btn-sm" data-action="btnDelete" data-name="{{$product->name}}" data-url="{{route('products.destroy', ['id'=> $product->id])}}" >
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
                    {{$products->links()}}
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


