@extends('layouts.admin')
@section('title')
    <title>Coupon add</title>
@endsection
@section('css')

@endsection

@section('js_link')

    <script src="{{asset('backend/common/coupon/coupon.js')}}"></script>
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'coupons', 'action' => 'add'])

    <!-- Main content -->
        <section class="content">
            <form action="{{route('coupons.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thêm Coupon</h3>
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
                                    <label for="inputName">Tên mã giảm giá</label>
                                    <input type="text" name="name" id="inputName" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="inputCode">Mã giảm giá</label>
                                    <input type="text" name="code" id="inputCode" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="inputCount">Số lượng mã</label>
                                    <input type="number" name="count" id="inputTime" class="form-control">
                                </div>


                                <div class="form-group">
                                    <label for="inputStatus">Loại giảm mã </label>
                                    <select id="inputStatus" name="condition" class="form-control custom-select">
                                        <option value="">---Chọn loại mã---</option>
                                        <option value="1">Giảm theo tiền</option>
                                        <option value="2">Giảm theo phần trăm</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="inputNumber">Nhập số % hoặc số tiền</label>
                                    <input type="number" name="number" id="inputNumber" class="form-control">
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


