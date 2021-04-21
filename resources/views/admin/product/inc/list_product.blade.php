<section class="content">
@if($products)
    <!-- Default box -->
        <div class="card">
            <div class="card-header d-flex flex-row align-content-center" >
                <div class="card-tools mr-1">
                    <form action="{{route('products.index')}}" method="get">
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
                            <a href="{{$sort_default}}" class="dropdown-item">Mặc định</a>
                            <a href="{{$sort_name}}" class="dropdown-item">Tên sách</a>
                            <a href="{{$sort_price}}" class="dropdown-item">Giá sách</a>
                            <a href="{{$sort_date}}" class="dropdown-item">Ngày xuất bản</a>
                    </div>
                </div>

                @if(session('message') && session('type'))
                    <p id="session-message" data-message="{{session('message')}}" data-type="{{session('type')}}"></p>
                @endif

                <div class="card-tools d-flex flex-row">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <a href="{{route('products.create')}}" class="btn btn-success btn-sm m-1">
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
                        <th style="width: 16%">
                            Tên sản phẩm
                        </th>

                        <th style="width: 16%">
                            Tác giả
                        </th>

                        <th style="width: 10%; text-align: center">
                            Hình ảnh
                        </th>

                        <th style="width: 14%; text-align: center">
                            Giá
                        </th>

                        <th style="width: 14%; text-align: center">
                            SL bán/còn
                        </th>

                        <th style="width: 14%; text-align: center">
                            Danh mục
                        </th>

                        <th class="border-left" style="float: right; margin-right: 10px;">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                {{$product->id}}
                            </td>
                            <td>
                                {{$product->name}}
                            </td>

                            <td>
                                {{$product->author}}
                            </td>
                            <td>
                                <img class="product-image" width="75px" height="94px" src="{{$product->featured_img}}">
                            </td>

                            <td class="text-center">
                                <span>{{number_format($product->price)}}</span>
                            </td>

                            <td class="text-center">
                                <span>{{$product->quantity_sold .'/'. $product->quantity}}</span>
                            </td>

                            <td class="text-center">
                                @foreach($product->categories as $category)
                                    <span class="mt-1 bg-gradient-indigo p-1 bord rounded d-inline-block">{{$category->name}}</span>
                                @endforeach
                            </td>

                            <td class="project-actions text-center">
                                <a class="btn btn-outline-info btn-sm m-1" href="{{route('products.edit', ['id' => $product->id])}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>

                                </a>
                                <a class="btn btn-outline-danger btn-sm m-1" data-action="btnDelete" data-name="{{$product->name}}" data-url="{{route('products.destroy', ['id'=> $product->id])}}" >
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
                {{$products->appends(request()->query())->links()}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endif

</section>