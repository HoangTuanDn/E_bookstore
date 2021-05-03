<?php

namespace App\Http\Controllers\Fontend;


use App\Http\Requests\PaypalOrderRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Ship;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\ExpressCheckout;
use Vinkla\Hashids\HashidsManager;

class PaypalController extends Controller
{
    private $provider;
    private $order;
    private $product;
    private $ship;
    private $coupon;
    private $payment;
    private $hashids;
    private $slug;
    private $orderCode;

    /**
     * PaypalController constructor.
     * @param $product
     * @param $ship
     * @param $coupon
     * @param $hashids
     * @param Order $order
     */
    public function __construct(Order $order, Product $product, Ship $ship, Coupon $coupon, Payment $payment, HashidsManager $hashids)
    {
        $this->provider = new ExpressCheckout();
        $this->order = $order;
        $this->product = $product;
        $this->ship = $ship;
        $this->coupon = $coupon;
        $this->payment = $payment;
        $this->hashids = $hashids;
    }


    public function payment(PaypalOrderRequest $request, $language, $slug = null)
    {
        if (auth()->guard('customer')->guest()) {
            $json = [
                'success' => false,
                'errors'  => [
                    [__('customer_error')]
                ],
                'code'    => Response::HTTP_UNAUTHORIZED
            ];
            return response()->json($json, $json['code']);
        }

        $unixTime = strtotime('now');
        $this->orderCode = $this->hashids->encode($unixTime);
        $this->slug = $slug;
        $orderData['slug'] = $this->slug;
        $orderData['province_id'] = $request->input('province_id');
        $orderData['district_id'] = $request->input('district_id');
        $orderData['ward_id'] = $request->input('ward_id');
        $orderData['customer_id'] = auth()->guard('customer')->user()->id;
        $orderData['order_code'] = $this->orderCode;
        $orderData = array_merge($orderData, $request->only(['full_name', 'address', 'phone', 'email']));
        session()->put('orderData', $orderData);

        $cart = $this->getCheckoutData($request, $slug);

        try {
            $options = [
                /*'PAYMENTREQUEST_0_AMT' => '21.00',
                'PAYMENTREQUEST_0_SHIPPINGAMT' => '1.00',*/
                /*'EMAIL' => 'toilaai99dn@gmail.com'*/
                /*'PAYMENTREQUEST_0_SHIPPINGAMT' => 4.00*/

            ];

            $response = $this->provider->addOptions($options)->setExpressCheckout($cart);
            return response()->json([
                'success' => true,
                'data'    => [
                    'url_redirect' => $response['paypal_link']
                ]
            ]);
        } catch (\Exception $e) {
            session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order {$this->orderCode}!"]);
        }
    }

    public function success(Request $request)
    {
        $recurring = false;
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');
        $orderData = session('orderData');
        $cart = $this->getCheckoutData($request, $this->slug);

        // Verify Express Checkout Token
        $response = $this->provider->getExpressCheckoutDetails($token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
            $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
            $isOrderStored = $this->storeOrder($orderData, $status);
            $request->session()->forget(['cart', 'order']);

            if ($isOrderStored) {
                $payPalCode = 'success';
                $payPalMessage = __('paypal_message_success', ['name' => $this->orderCode]);
            } else {
                $payPalCode = 'warning';
                $payPalMessage = __('paypal_message_error', ['name' => $this->orderCode]);
            }

            return redirect()->route('home', ['language' => app()->getLocale()])->with([
                'payPalCode' => $payPalCode,
                'payPalMessage' => $payPalMessage
            ]);
        }
    }

    protected function getCheckoutData($request, $slug)
    {

        $data = [];
        $checkoutData = [];
        $cartData = session('cart');
        $order = session('order');
        $orderData = session('orderData');
        $slug = $orderData['slug'];

        if (isset($order['coupon_code'])) {
            $coupon = $this->coupon->where('code', $order['coupon_code'])->first();
            if ($coupon) {
                $checkoutData ['coupon_count'] = $coupon->count;
                $checkoutData ['coupon_condittion'] = $coupon->condition;
            }
        }

        $subPrice = 0;
        if ($slug) {
            $product = $this->product->where('slug', $slug)->first();
            if ($product) {
                $data['items'][] = [
                    'name'  => $product->name,
                    'price' => $this->getDollar($product->discount),
                    'qty'   => 1,
                ];
                $subPrice = $this->getDollar($product->discount);
            }
        } else {
            if ($cartData) {
                foreach ($cartData as $item) {
                    $data['items'][] = [
                        'name'  => $item['name'],
                        'price' => $this->getDollar($item['price']),
                        'qty'   => $item['quantity'],
                    ];
                    $subPrice += $item['quantity'] * $this->getDollar($item['price']);
                }
            }
        }

        $data['return_url'] = route('home.payment.success', ['language' => app()->getLocale()]);
        $data['invoice_id'] = $this->orderCode;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['cancel_url'] = route('home', ['language' => app()->getLocale()]);

        $data['subtotal'] = $subPrice;
        $data['shipping'] = $this->getDollar($order['fee_ship']);
        $data['total'] = $subPrice + $data['shipping'];

        if (isset($checkoutData ['coupon_condittion'])) {
            if ($checkoutData ['coupon_condittion'] === 1) {
                $data['shipping_discount'] = round(($checkoutData ['coupon_count'] / 100) * $totalPrice, 2);
            }
            if ($checkoutData ['coupon_condittion'] === 2) {
                $data['shipping_discount'] = $this->getDollar($checkoutData ['coupon_count']);
            }
        }

        return $data;
    }

    protected function storeOrder($orderData, $status)
    {
        $cartData = session('cart');
        $order = session('order');

        if ($order['coupon_code']) {
            $coupon = $this->coupon->where('code', $order['coupon_code'])->first();
            if ($coupon) {
                $dataOrderInsert ['coupon_id'] = $coupon->id;
            }
        }

        if (!empty($orderData['province_id'])
            && !empty($orderData['district_id'])
            && !empty($orderData['ward_id'])) {
            $ship = $this->ship->where([
                'province_id' => $orderData['province_id'],
                'district_id' => $orderData['district_id'],
                'ward_id'     => $orderData['ward_id']
            ])->first();

            if (!$ship) {
                $defaultShip = $this->ship->where([
                    'province_id' => 0,
                    'district_id' => 0,
                    'ward_id'     => 0
                ])->first();

                $ship = $this->ship->create([
                    'province_id' => $orderData['province_id'],
                    'district_id' => $orderData['district_id'],
                    'ward_id'     => $orderData['ward_id'],
                    'price'       => $defaultShip->price
                ]);
            }

            $dataOrderInsert['ship_id'] = $ship->id;
        }

        $dataOrderInsert['payment_id'] = config('custom.paypal_id');

        $dataOrderInsert['order_code'] = $orderData['order_code'];
        $dataOrderInsert['customer_id'] = $orderData['customer_id'];
        $dataOrderInsert['status'] = 4;
        $dataOrderInsert['full_name'] = $orderData['full_name'];
        $dataOrderInsert['address'] = $orderData['address'];
        $dataOrderInsert['phone'] = $orderData['phone'];
        $dataOrderInsert['email'] = $orderData['email'];

        if (!strcasecmp($status, 'Completed') || !strcasecmp($status, 'Processed') || !strcasecmp($status, 'Pending')) {
            try {
                DB::beginTransaction();
                if ($orderData['slug']) {
                    $order = $this->order->create($dataOrderInsert);
                    $product = $this->product->where('slug', $orderData['slug'])->first();

                    if ($product) {
                        $order->products()->attach($product->id, ['quantity' => 1]);
                        $product->update([
                            'quantity'      => $product->quantity - 1,
                            'quantity_sold' => $product->quantity_sold + 1,
                        ]);
                    }
                } else {
                    $order = $this->order->create($dataOrderInsert);

                    if ($cartData && $order) {
                        foreach ($cartData as $item) {
                            $order->products()->attach($item['id'], ['quantity' => $item['quantity']]);
                            $product = $this->product->find($item['id']);
                            $product->update([
                                'quantity'      => $product->quantity - $item['quantity'],
                                'quantity_sold' => $product->quantity_sold + $item['quantity'],
                            ]);
                        }
                    }
                }
                $isCreated = true;
                DB::commit();

            } catch (\Exception $e) {
                dd($e);
                DB::rollBack();
                $isCreated = false;
                Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            }
        } else {
            $isCreated = false;
        }

        return $isCreated;

    }

    private function getDollar($vnd)
    {
        return round($vnd / config('custom.dollar_vnd'), 2);
    }

}
