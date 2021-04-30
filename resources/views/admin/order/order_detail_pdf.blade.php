<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Invoice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

{{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">--}}
<!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{public_path('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
{{-- <link rel="stylesheet" href="{{public_path('backend/dist/css/adminlte.min.css')}}">--}}
<!-- custom css -->
    <style type="text/css">
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: normal;
            font-weight: normal;
            src: url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback) format('truetype');
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans;
        }

    </style>

</head>
<body class="login-page" style="background: white">
<div class="content" style="margin: auto; position: absolute; left: 100px; top:100px">
   <div style="border: 1px solid !important; width: 600px">
       <table style="width: 600px;border: 1px solid; border: none">
           <tr style="border-bottom: 1px solid #dee2e6;">
               <td style="  height: 80px ; border-bottom: 1px solid #dee2e6;">
                   <div
                           class="col-xs-5"
                           style="
                                float: left;
                                margin-top: 5px;
                                margin-bottom: 5px;
                                width: 50px;

                "
                   >
                       <img
                               src="{{public_path('fontend/images/logo/logo.png')}}"
                               alt="logo"
                       />
                   </div>
               </td>

               <td style="border-bottom: 1px solid #dee2e6;">
                   <div style="width: 150% ; border-left: 1px solid #dee2e6; margin-left: -120px">
                       <img
                               style=" margin-top: 5px; margin-left: -50px; padding-bottom: -15px"
                               height="30px"
                               src="{{public_path('fontend/images/brand/barcode.png')}}"
                       />
                       <div >
                           <p>
                               Mã đơn hàng: {{$order->order_code}}
                           </p>
                       </div>

                   </div>
               </td>
           </tr>

           <tr style="border-bottom: 1px solid #dee2e6; ">
               <td style="padding-left: 20px; border-bottom: 1px solid #dee2e6">
                   <div class="col-xl-6 border-right" style="border-right: 1px solid #dee2e6; width: 60%;">
                       <h5>Từ:</h5>
                       <p>Trí Tuệ Store.</p>
                       <span>{{$settingKeys['address_1']}}</span><br />
                       <span>SDT: {{$settingKeys['phone']}} </span><br />
                       <span>EMAIL: {{$settingKeys['email']}} </span><br />
                       <br />
                   </div>
               </td>
               <td style="border-bottom: 1px solid #dee2e6">
                   <div class="col-xl-6" style="width: 180%; transform: translateX(-130px); margin-top: -70px" >
                       <h5>Đến:</h5>
                       <address>
                           <p>{{$order->full_name}}</p>
                           <span>{{$order->address .','. $order->ship->ward->name}}</span> <br />
                           <span>{{$order->ship->district->name .','. $order->ship->province->name}}</span> <br />
                           <span>SDT: {{$order->phone}}</span>
                       </address>
                   </div>
               </td>
           </tr>
           <tr>
               <td style="height: 30px; border-bottom: 1px solid #dee2e6;" colspan="2"></td>
           </tr>

           <tr style="border-bottom: 1px solid #dee2e6;">
               <td style="border-bottom: 1px solid #dee2e6">
                   <div class="p-1" style=" border-right: 1px solid #dee2e6; padding-left: 20px; padding-bottom: 10px">
                       <p><strong>Nội dung hàng (Tổng SL sản phẩm: {{$order->products->count()}})</strong></p>
                       @php($i = 0)
                       @foreach($order->products as $product)
                           <p style="margin-bottom: 5px">
                               <strong>{{$i +=1}}.</strong> {{$product->name. '  ,SL:'. $product->pivot->quantity}}
                           </p>
                       @endforeach

                       <p style="font-style: italic; font-size: small; margin-top: 20px">
                           Kiểm tra tên sản phẩm và đối chiếu mã đơn hàng trên
                           trang web trước khi nhận hàng.(Lưu ý: Một số sản phẩm có
                           thể bị ấn do danh sách quá dài)
                       </p>
                   </div>
               </td>
               <td style="border-bottom: 1px solid #dee2e6">
                   <div class="border-left p-1 text-center" style="text-align: center;">
                       <p>Ngày đặ hàng:</p>
                       <p>{{date('d-m-Y H:i', strtotime($order->created_at))}}</p>
                   </div>
               </td>
           </tr>
           <tr>
               <td>
                   <div class="p-1" style="padding-left: 4%; width: 60%; margin-top: -50px">
                       <p style="">Tiền thu Người nhân:</p>
                       <h4 style="margin-top: 20px;">{{number_format($totalPrice, 0, '.', ',') . __('currency_unit')}}</h4>
                   </div>
               </td>
               <td>
                   <div style="width: 150%; text-align: center; margin-top: 20px; margin-bottom: 10px; padding-top: -30px; transform: translateX(-40%)">
                       <p >Khối lượng tối đa: 100g</p>
                       <div style="border: 1px solid; height: 120px; margin-top: 5px;">
                           <p><strong>Chữ ký người nhận:</strong></p>
                           <p>Xác nhận hàng nguyên vẹn, không móp/méo, bể vỡ</p>
                       </div>
                   </div>
               </td>
           </tr>
       </table>
   </div>
</div>
</body>
</html>
