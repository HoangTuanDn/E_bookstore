<section class="content">
@if($sliders)
    <!-- Default box -->
        <div class="card">

            <div class="card-header d-flex flex-row align-content-center">

                <div class="card-tools mr-1">
                    <form action="{{route('sliders.index')}}" method="get">
                        <div class="input-group input-group-sm" style="width: 150px; margin-top: 5px">
                            <input type="text" name="name" class="form-control float-right" placeholder="Tìm kiếm...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="dropdown flex-grow-1">
                    <button style="margin-top: 5px" class="btn btn-default btn-sm dropdown-toggle mr-1" type="button"
                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sắp xếp
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @if($order === 'asc')
                            <a href="{{$sort_name}}" class="dropdown-item">Tên <i class="fas fa-sort-down"></i></a>
                            <a href="{{$sort_default}}" class="dropdown-item">Mặc định <i class="fas fa-sort-down"></i></a>
                        @else
                            <a href="{{$sort_name}}" class="dropdown-item">Tên <i class="fas fa-sort-up"></i></a>
                            <a href="{{$sort_default}}" class="dropdown-item">Mặc định <i
                                        class="fas fa-sort-up"></i></a>
                        @endif

                    </div>
                </div>

                @if(session('message') && session('type'))
                    <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
                @endif

                <div class="card-tools d-flex flex-row">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    @can('slider-create')
                        <a href="{{route('sliders.create')}}" class="btn btn-success btn-sm m-1">
                            Add
                        </a>
                    @endcan
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects" id="example1">
                    <thead>
                    <tr>
                        <th class="border-right text-center" style="width: 1%">
                            #
                        </th>
                        <th style="width: 44%">
                            Tên slider
                        </th>

                        <th style="width: 44%; text-align: center">
                            Hình ảnh
                        </th>

                        <th class="border-left" style="float: right; margin-right: 10px">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sliders as $slider)
                        <tr>
                            <td>
                                {{$slider->id}}
                            </td>
                            <td>
                                {{$slider->name}}
                            </td>
                            <td>
                                <img class="product-image" src="{{$slider->image_path}}">
                            </td>


                            <td class="project-actions text-right">
                                @can('slider-update')
                                    <a class="btn btn-info btn-sm mb-1"
                                       href="{{route('sliders.edit', ['id' => $slider->id])}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>

                                    </a>
                                @endcan
                                @can('slider-delete')
                                    <a class="btn btn-danger btn-sm" data-action="btnDelete"
                                       data-name="{{$slider->name}}"
                                       data-url="{{route('sliders.destroy', ['id'=> $slider->id])}}">
                                        <i class="fas fa-trash">
                                        </i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col-md-5 mt-3">
                {{$sliders->appends(request()->query())->links()}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endif

</section>