@extends('layouts.admin')

@section('title')
  <title>Trang chu</title>
@endsection

@section('css')
  <link href="{{asset('backend/common/dashboard/dashboard.css')}}" rel="stylesheet" />
@endsection

@section('js_link')
  <script src="{{asset('backend/plugins/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('backend/common/dashboard/dashboard.js')}}"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="{{asset('common/toastr.min.js')}}"></script>


  <script src="{{asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('backend/plugins/jszip/jszip.min.js')}}"></script>
  <script src="{{asset('backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
  <script src="{{asset('backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
  <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>

  <script>
    $(function () {
      $("#example1").DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "buttons": ["excel", "pdf"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

      $('#example1_wrapper').find('.dataTables_empty').text('Không có dữ liệu')
    });
  </script>
@endsection

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Doanh Thu</h3>
                  <a href="javascript:void(0);">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">{!! $totalYearSale !!}</span>
                    <span>Trong năm</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> {{ round($totalIncrement, 2, PHP_ROUND_HALF_UP) . '%' }}
                    </span>
                    <span class="text-muted">Tháng trước</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i>Năm {{$yearsNow}}
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i>Năm {{$lastYear}}
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card">
              {!! $inc_list !!}

            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
  </div>
@endsection
