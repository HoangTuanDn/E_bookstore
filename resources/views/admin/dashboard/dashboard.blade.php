<div class="card-header border-0 d-flex flex-row">
    <div class="dropdown ">
        <button style="margin-top: 5px" class="btn btn-default btn-sm dropdown-toggle mr-1" type="button"
                id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Lựa chọn
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <a href="{{route('admin.home', ['filter_time' => 'dateNow'])}}" data-action="filter-report"
               data-filter="dateNow" class="dropdown-item">Ngày hôm nay<i class="fas fa-sort-down"></i></a>
            <a href="{{route('admin.home', ['filter_time' => 'weekNow'])}}" data-action="filter-report"
               data-filter="weekNow" class="dropdown-item">Tuần này <i class="fas fa-sort-down"></i></a>
            <a href="{{route('admin.home', ['filter_time' => 'lastWeek'])}}" data-action="filter-report"
               data-filter="lastWeek" class="dropdown-item">Tuần trước <i class="fas fa-sort-down"></i></a>
            <a href="{{route('admin.home', ['filter_time' => 'monthNow'])}}" data-action="filter-report"
               data-filter="monthNow" class="dropdown-item">Tháng này <i class="fas fa-sort-down"></i></a>
            <a href="{{route('admin.home', ['filter_time' => 'lastMonth'])}}" data-action="filter-report"
               data-filter="lastMonth" class="dropdown-item">Tháng trước <i class="fas fa-sort-down"></i></a>
        </div>
    </div>

    <form action="{{route('admin.home')}}" method="get" class="flex-grow-1">
        <div class="input-group input-group-sm mt-1 col-md-6">
            <input type="date"
                   name="time_from"
                   id="inputDateFrom"
                   class="form-control float-right"
                   placeholder="Từ"
                   value="{{old('time_from')}}"
                   class="form-control"

            >
            <input type="date"
                   name="time_to"
                   id="inputDateTo"
                   class="form-control float-right"
                   placeholder="Ngày tạo"
                   class="form-control"
                   value="{{old('time_to')}}"

            >
            <div class="input-group-append">
                <button type="submit" class="btn btn-default btn-sm">
                    <i class="fas fa-filter"></i>
                </button>
            </div>

        </div>
    </form>


    <div class="card-tools justify">
        <a href="#" data-action="excel-download" class="btn btn-tool btn-sm">
            <i class="fas fa-download"></i>
            excel
        </a>

        <a href="#" data-action="pdf-download" class="btn btn-tool btn-sm">
            <i class="fas fa-download"></i>
            pdf
        </a>
    </div>
</div>

<div class="card-body table-responsive p-0 custom-height report-content" id="report-content">
    <table class="table table-striped table-valign-middle" id="example1">
        <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th class="text-center">Đã bán</th>
            <th class="text-center">Tồn kho</th>
        </tr>
        </thead>
        <tbody>
        @if($dataRenders)
            @foreach($dataRenders as $product)
                <tr>
                    <td>
                        <img src="{{asset($product['featured_img'])}}" alt="Product 1"
                             class="img-circle img-size-32 mr-2">
                        {{$product['name']}}
                    </td>
                    <td>{!!  number_format($product['discount'], 0, ',', '.') . __('currency_unit') !!}</td>
                    <td class="text-center">
                        {{number_format($product['sold'], 0, ',', '.')}}
                    </td>
                    <td class="text-center">
                        {{number_format($product['quantity'], 0, ',', '.')}}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>
                    <p class="pl-3 font-weight-bold">Tổng đã bán:</p>
                </td>
                <td>

                </td>
                <td >


                </td>
                <td class="text-center">
                    {{$totalItem}} Sản phẩm
                </td>
            </tr>

            <tr>
                <td>
                    <p class="pl-3 font-weight-bold">Doanh Thu:</p>
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>
                    <p class="text-center">{!! number_format($totalPriceSale, 0, ',', '.') . __('currency_unit') !!}</p>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>