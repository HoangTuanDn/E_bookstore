@extends('layouts.admin')

@section('title')
    <title>Ships</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
@endsection


@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
    <script src="{{asset('backend/common/ship/ship.js')}}"></script>
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
                        <a href="{{route('ships.create')}}" class="btn btn-success">
                           Add
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table  class="table table-striped projects">
                        <thead>
                        <tr>
                            <th class="border-right" style="width: 1%  ">
                                #
                            </th>
                            <th  style=" width: 20%;">
                                Tỉnh/Thành phố
                            </th>

                            <th  style="width: 20%;">
                                Quận/Huyện
                            </th>

                            <th  style=" width: 20%; ">
                                Phường/Xã
                            </th>

                            <th  style=" width: 20%;">
                                Phí ship
                            </th>

                            <th class="border-left" style="float: right; margin-right: 10px">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($ships )
                            @foreach($ships as $ship)
                                <tr>
                                    <td>
                                        {{$ship->id}}
                                    </td>
                                    <td>
                                        <a>
                                            {{isset($ship->province->name)? $ship->province->name : 'Mặc định'}}
                                        </a>
                                    </td>

                                    <td >
                                        <a>
                                            {{isset($ship->district->name) ? $ship->district->name : 'Mặc định'}}
                                        </a>
                                    </td>

                                    <td >
                                        <a>
                                            {{isset($ship->ward->name) ? $ship->ward->name : 'Mặc định'}}
                                        </a>
                                    </td>

                                    <td  data-url="{{route('ships.update', ['id' => $ship->id])}}" contenteditable data-action="change-price">
                                        <a id="{{$ship->id}}-price">
                                            {{number_format($ship->price)}}
                                        </a>
                                    </td>

                                    <td class="project-actions text-right">
                                        <a class="btn btn-danger btn-sm" data-action="btnDelete" data-name="{{$ship->name}}" data-url="{{route('ships.destroy', ['id'=> $ship->id])}}" >
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
                    {{$ships->links()}}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


