<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="wrapper" id="wrapper">
    <div class="cart-main-area section-padding--lg bg--white">
        <div class="container">
            <div class="row">
                <div class="content col-md-12 col-sm-12 ol-lg-12">
                    <h3>Cảm ơn bạn đã đặt hàng</h3 >
                    <p>xin chào {{$data['full_name']}}.</p>
                    <p>
                        Cảm ơn bạn đã đặt hàng.Đơn hàng của bạn sẽ tạm giữ
                        đến khi chúng tôi xác nhận thanh toán hoàn thành.
                        Trong thời gian chờ đợi đây là thông tin chi tiết
                        đơn hàng của bạn
                    </p>

                    @if($data['payment_id'] === 1)
                        <h3 class="mt--20">Thông tin chuyển khoản</h3>
                        <h3>Trí tuệ book shop:</h3>
                        <ul style="margin-left: 5%;">
                            <li>Ngân hàng thương mại: viettinbank</li>
                            <li>Số tài khoản: 191915338</li>
                        </ul>
                    @endif
                    <div class="detail mt--20">
                        <h3>[Đơn hàng: {{$data['order_code']}}] ({{$data['created_at']}})</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ol-lg-12">

                    <div
                            class="table-content wnro__table table-responsive"
                    >
                        <table>
                            <thead>
                            <tr class="title-top">
                                <th class="product-name">
                                    Sản phẩm
                                </th>
                                <th class="product-quantity">
                                    Số lượng
                                </th>
                                <th class="product-thumbnail">
                                    Giá
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @foreach($data['products'] as $product)
                                @endforeach
                                <td class="product-thumbnail text-left">
                                    <a
                                            href=""
                                    >{{$product['name']}}</a
                                    >
                                </td>
                                <td class="product-thumbnail  text-center">
                                    <a
                                            href=""
                                    >{{$product['quantity']}}</a
                                    >
                                </td>
                                <td class="product-thumbnail  text-left">{{$product['price']}}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="product-thumbnail  text-left">
                                    <a
                                            href=""
                                    >tổng số phụ:</a
                                    >
                                </td>
                                <td class="product-thumbnail  text-left">{{$data['sub_price']}}</td>
                            </tr>

                            <tr>
                                <td colspan="2" class="product-thumbnail  text-left">
                                    <a
                                            href=""
                                    >Phí ship:</a
                                    >
                                </td>
                                <td class="product-thumbnail  text-left">{{$data['fee_ship']['price']}}</td>
                            </tr>
                            @if($data['coupon'])
                                <tr>
                                    <td colspan="2" class="product-thumbnail  text-left">
                                        <a
                                                href=""
                                        >Mã giảm giá: {{$data['coupon']['coupon_code']}}</a
                                        >
                                    </td>
                                    <td class="product-thumbnail  text-left">{{$data['coupon']['coupon_discount']}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="2" class="product-thumbnail text-left">
                                    <a
                                            href=""
                                    >Phương thức thanh toán:</a
                                    >
                                </td>
                                <td class="product-thumbnail al text-left">{{$data['payment']}}</td>
                            </tr>

                            <tr>
                                <td colspan="2" class="product-thumbnail  text-left">
                                    <a
                                            href=""
                                    >Tổng cộng:</a
                                    >
                                </td>
                                <td class="product-thumbnail  text-left">{{$data['total_price']}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="row mt--20">
                <div class="col-md-6 col-sm-10 ol-lg-6">

                    <div
                            class="table-content wnro__table table-responsive"
                    >
                        <table>
                            <thead>
                            <tr class="title-top">
                                <th class="product-name text-left">
                                    Địa chỉ thanh toán
                                </th>
                                <th class="product-quantity text-left">
                                    Địa chỉ giao hàng
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td class="product-name text-left">
                                    <p
                                    >{{$data['fee_ship']['province']}}</p
                                    >
                                    <p
                                            href=""
                                    >{{$data['fee_ship']['district']}}</p
                                    >
                                    <p
                                            href=""
                                    >{{$data['fee_ship']['ward']}}</p
                                    >
                                    <p
                                            href=""
                                    >{{$data['email']}}</p
                                    >
                                    <p
                                            href=""
                                    >{{$data['phone']}}</p
                                    >
                                </td>
                                <td class="product-name text-left">
                                    <p
                                    >{{$data['fee_ship']['province']}}</p
                                    >
                                    <p
                                            href=""
                                    >{{$data['fee_ship']['district']}}</p
                                    >
                                    <p
                                            href=""
                                    >{{$data['fee_ship']['ward']}}</p
                                    >
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>