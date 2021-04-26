<section class="content">

    <!-- Default box -->
    <div class="card ">
        <div class="card-header d-flex flex-row align-content-center">
            <div class="card-tools mr-1">
                <form action="{{route('blog_categories.index')}}" method="get">
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
                     <a href="{{$sort_name}}" class="dropdown-item">Tên</a>
                     <a href="{{$sort_default}}" class="dropdown-item">Mặc định</a>
                </div>
            </div>
            @if(session('message') && session('type'))
                <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
            @endif

            <div class="card-tools d-flex flex-row">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                @can('category-create')
                    <a href="{{route('blog_categories.create')}}" class="btn btn-success btn-sm m-1">
                        Add
                    </a>
                @endcan

            </div>
        </div>
        @can('category-viewAny')
            <div class="card-body p-0">
                <table class="table table-striped projectsexample1" >
                    <thead>
                    <tr>
                        <th class="border-right" style="width: 1%">
                            #
                        </th>
                        <th style="width: 89%; text-align: left">
                            Tên danh mục bài viết
                        </th>

                        <th class="border-left"style="float: right; margin-right: 10px">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($blogCategories )
                        @foreach($blogCategories as $category)
                            <tr>
                                <td>
                                    {{$category->id}}
                                </td>
                                <td class="text-left">
                                    <a>
                                        {{$category->name}}
                                    </a>
                                </td>

                                <td class="project-actions text-center">
                                    @can('category-update')
                                        <a class="btn btn-info btn-sm m-1" href="{{route('blog_categories.edit', ['id' => $category->id])}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                    @endcan
                                    @can('category-delete')
                                        <a class="btn btn-danger btn-sm m-1" data-action="btnDelete" data-name="{{$category->name}}" data-url="{{route('blog_categories.destroy', ['id'=> $category->id])}}" >
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    @endcan

                                </td>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>
            </div>
        @endcan
        <div class="col-md-5 mt-3">
            {{$blogCategories->appends(request()->query())->links()}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>