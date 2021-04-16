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
                    <p>Xin chào !.</p>
                    <h3>Trí tuệ book. Cảm ơn bạn đã tin tưởng và ủng hộ chúng tôi trong thời gian qua</h3 >
                    <div class="detail mt--20">
                        <h3>Đây là mã giảm giá ưu đãi dành cho bạn:</h3>
                        <h3><strong>{{$data['coupon_code']}}/Giảm {{$data['coupon_discount']}} cho đơn hàng</strong></h3>
                    </div>

                    <div class="detail mt--20">
                        <p>Xin cảm ơn. và chúng tôi mong chờ đơn hàng tiếp theo từ bạn</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>