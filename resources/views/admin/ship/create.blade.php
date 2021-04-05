@extends('layouts.admin')
@section('title')
    <title>Ships</title>
@endsection
@section('css')

@endsection

@section('js_link')

    <script src="{{asset('backend/common/ship/ship.js')}}"></script>
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.breadcrumb',['module' => 'ships', 'action' => 'add'])

    <!-- Main content -->
        <section class="content">
            <form action="{{route('ships.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <div class="card card-primary col-md-10">
                            <div class="card-header">
                                <h3 class="card-title">Thêm phí vận chuyển</h3>
                                @if($errors->any())
                                    <p id="error-message" data-message="{{$errors->first()}}"></p>
                                @endif
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" data-action="store-data" data-url="{{route('ships.create')}}">

                                <div class="form-group">
                                    <label for="province">Tỉnh/Thành phố </label>
                                    <select id="province" name="province_id" data-type="province" data-action="select-address" class="form-control custom-select">
                                        <option value="">---Chọn tỉnh hoặc thành phố---</option>
                                        @foreach($provinces as $province)
                                            <option value="{{$province->id}}">{{$province->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="district">Quận/Huyện </label>
                                    <select id="district" name="district_id" data-type="district" data-action="select-address" class="form-control custom-select">
                                        <option value="">---Chọn quận hoặc huyện---</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="ward">Phường/Xã </label>
                                    <select id="ward" name="ward_id" data-type="ward" data-action="select-address" class="form-control custom-select">
                                        <option value="">---Chọn Phường hoặc xã---</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="inputNumber">Phí giao</label>
                                    <input type="number" name="price" id="inputNumber" placeholder="Nhập phí giao hàng" class="form-control">
                                </div>

                                <div class="row">
                                    <div class="col-3 mb-2">
                                        <input type="submit" value="Thêm" class="btn btn-success float-left">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
@endsection


