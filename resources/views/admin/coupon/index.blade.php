@extends('layouts.admin')

@section('title')
    <title>Counpons</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
@endsection


@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
    <script src="{{asset('backend/common/coupon/coupon.js')}}"></script>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'menus'])


    <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách mã giảm giá</h3>
                    @if(session('message') && session('type'))
                        <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
                    @endif

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a href="{{route('coupons.create')}}" class="btn btn-success">
                           Add
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th class="border-right" style="width: 1%">
                                #
                            </th>
                            <th  style="width: 20%;">
                                Tên Mã giảm giá
                            </th>

                            <th  style="width: 15%;">
                                Mã giảm giá
                            </th>

                            <th  style="width: 15%;">
                                Số lượng giảm
                            </th>

                            <th  style="width: 20%;">
                                Loại giảm
                            </th>

                            <th  style="width: 20%;">
                                Số giảm
                            </th>

                            <th class="border-left" style="float: right; margin-right: 10px">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($coupons )
                            @foreach($coupons as $coupon)
                                <tr>
                                    <td>
                                        {{$coupon->id}}
                                    </td>
                                    <td>
                                        <a>
                                            {{$coupon->name}}
                                        </a>
                                    </td>

                                    <td >
                                        <a>
                                            {{$coupon->code}}
                                        </a>
                                    </td>

                                    <td >
                                        <a>
                                            {{$coupon->number}}
                                        </a>
                                    </td>

                                    <td >
                                        <a>
                                            {{$coupon->condition == 1 ? 'Giảm theo phần trăm' : 'Giảm theo tiền'}}
                                        </a>
                                    </td>

                                    <td >
                                        <a>
                                            @if($coupon->condition == 1)
                                                Giảm {{$coupon->count}} %
                                            @else
                                                Giảm {{number_format($coupon->count, 0, ',', '.')}} nVND
                                            @endif
                                        </a>
                                    </td>


                                    <td class="project-actions text-right">
                                        <a class="btn btn-danger btn-sm" data-action="btnDelete" data-name="{{$coupon->name}}" data-url="{{route('coupons.destroy', ['id'=> $coupon->id])}}" >
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
                <div class="col-md-5 mt-3">
                    {{$coupons->links()}}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


