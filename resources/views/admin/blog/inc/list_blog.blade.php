<section class="content">
@if($blogs)
    <!-- Default box -->
        <div class="card">
            <div class="card-header d-flex flex-row align-content-center" >
                <div class="card-tools mr-1">
                    <form action="{{route('blogs.index')}}" method="get">
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
                    <button style="margin-top: 5px" class="btn btn-default btn-sm dropdown-toggle mr-1" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sắp xếp
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @if($order === 'asc')
                            <a href="{{$sort_default}}" class="dropdown-item">Mặc định <i class="fas fa-sort-down"></i></a>
                            <a href="{{$sort_name}}" class="dropdown-item">Tên bài viết <i class="fas fa-sort-down"></i></a>
                            <a href="{{$sort_view}}" class="dropdown-item">Lượt xem <i class="fas fa-sort-down"></i></a>
                        @else
                            <a href="{{$sort_default}}" class="dropdown-item">Mặc định <i class="fas fa-sort-up"></i></a>
                            <a href="{{$sort_name}}" class="dropdown-item">Tên bài viết <i class="fas fa-sort-up"></i></a>
                            <a href="{{$sort_view}}" class="dropdown-item">Lượt xem <i class="fas fa-sort-up"></i></a>
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
                    <a href="{{route('blogs.create')}}" class="btn btn-success btn-sm m-1">
                        Add
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects" id="example1">
                    <thead>
                    <tr>
                        <th class="border-right" style="width: 1%">
                            #
                        </th>
                        <th style="width: 19%">
                            Tên bài viết
                        </th>

                        <th style="width: 15%">
                            Tác giả
                        </th>

                        <th style="width: 17%; text-align: center">
                            Hình ảnh
                        </th>

                        <th style="width: 17%; text-align: center">
                            Lượt xem
                        </th>

                        <th style="width: 17%; text-align: center">
                            Danh mục
                        </th>

                        <th class="border-left" style="float: right; margin-right: 10px;">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($blogs as $blog)
                        <tr>
                            <td>
                                {{$blog->id}}
                            </td>
                            <td>
                                {{$blog->name}}
                            </td>

                            <td>
                                {{$blog->author->name}}
                            </td>
                            <td>
                                <img class="product-image" src="{{$blog->featured_img}}">
                            </td>


                            <td class="text-center">
                                {{number_format($blog->view, 0, '.', ',')}}
                            </td>

                            <td class="text-center">
                                <span class="mt-1 bg-gradient-indigo p-1 bord rounded d-inline-block">{{$blog->category->name}}</span>
                            </td>

                            <td class="project-actions text-center">
                                <a class="btn btn-outline-info btn-sm m-1" href="{{route('blogs.edit', ['id' => $blog->id])}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>

                                </a>
                                <a class="btn btn-outline-danger btn-sm m-1" data-action="btnDelete" data-name="{{$blog->name}}" data-url="{{route('blogs.destroy', ['id'=> $blog->id])}}" >
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
                {{$blogs->appends(request()->query())->links()}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endif

</section>