@extends('layouts.admin')

@section('title')
    <title>Orders</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
    {{--<link href="{{asset('backend/common/product/product.css')}}" rel="stylesheet" />--}}

@endsection


@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{asset('backend/common/order/order.js')}}"></script>
    <script src="{{asset('backend/common/Mail/confirmEmail.js')}}"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'orders'])

        <!-- Main content -->
        {!! $inc_list !!}
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


