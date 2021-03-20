    @include('partials.breadcrumb',['module' => 'settings', 'action' => 'add'])


@section('title')
    <title>Settings</title>
@endsection

@section('css')
    <link href="{{asset('/common/toastr.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/backend/common/setting/setting.css')}}" rel='stylesheet' type='text/css' />
@endsection


@section('js_link')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{asset('common/toastr.min.js')}}"></script>
    <script src="{{asset('backend/common/setting/list.js')}}"></script>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
            @include('partials.breadcrumb',['module' => 'settings'])


        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header header-edit">
                    <h3 class="card-title">Danh sách cấu hình</h3>
                    @if(session('message') && session('type'))
                        <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
                    @endif
                        <div class="float-right flex-row custom-setting">
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <div class="dropdown">
                                    <button class="btn btn-outline-success dropdown-toggle mr-1" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <a href="{{route('settings.create',['type'=>'text'])}}" class="dropdown-item">Text</a>
                                        <a href="{{route('settings.create', ['type' => 'textarea'])}}" class="dropdown-item">Text area</a>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th class="border-right" style="width: 1%">
                                #
                            </th>
                            <th class="text-center" style="width: 20%">
                                Khóa
                            </th>

                            <th class="text-center" style="width: 20%">
                                Giá trị
                            </th>

                            <th class="border-left" style="float: right; margin-right: 10px">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($settings )
                            @foreach($settings as $setting)
                                <tr>
                                    <td>
                                        {{$setting->id}}
                                    </td>
                                    <td class="text-center">
                                        <a>
                                            {{$setting->config_key}}
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        <a>
                                            {{$setting->config_value}}
                                        </a>
                                    </td>

                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm" href="{{route('settings.edit', ['id' => $setting->id])}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                        <a class="btn btn-danger btn-sm" data-action="btnDelete" data-name="{{$setting->name}}" data-url="{{route('settings.destroy', ['id'=> $setting->id])}}" >
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
                    {{$settings->links()}}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


