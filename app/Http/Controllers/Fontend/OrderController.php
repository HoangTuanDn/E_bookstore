<?php

namespace App\Http\Controllers\fontend;


use App\Components\Message;
use App\Http\Requests\OrderRequest;
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
use Vinkla\Hashids\HashidsManager;

class OrderController extends Controller
{
    private $order;
    private $product;
    private $ship;
    private $coupon;
    private $payment;
    private $hashids;

    /**
     * OrderController constructor.
     * @param $order
     * @param $product
     * @param $ship
     * @param $coupon
     * @param $payment
     * @param $hashids
     */
    public function __construct(Order $order, Product $product, Ship $ship, Coupon $coupon, Payment $payment, HashidsManager $hashids)
    {
        $this->order = $order;
        $this->product = $product;
        $this->ship = $ship;
        $this->coupon = $coupon;
        $this->payment = $payment;
        $this->hashids = $hashids;
    }

    public function index()
    {
        $orders = $this->order->where('customer_id', auth()->guard('customer')->user()->id)->get();
        $orderTotalPrice = [];

        foreach ($orders as $order) {
            $totalPrice = 0;
            foreach ($order->products as $product) {
                $totalPrice += $product->discount * $product->pivot->quantity;
            }

            if (isset($order->coupon)) {

                if ($order->coupon->condition === 1) {
                    $totalPrice *= ($order->coupon->count / 100);
                }
                if ($order->coupon->condition === 2) {
                    $totalPrice -= $order->coupon->count;
                }
            }

            $totalPrice += $order->ship->price;

            $orderTotalPrice[$order->id] = $totalPrice;

        }

        return view('fontend.order.order', compact('orders', 'orderTotalPrice'));
    }

    public function store(OrderRequest $request, $language, $slug = null)
    {
        if ( auth()->guard('customer')->guest()) {
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
        $dataOrderInsert = [];
        $idCountryRequest = $request->only(['province_id', 'district_id', 'ward_id']);
        $orderCode = $this->hashids->encode($unixTime);
        $cartData = session('cart');

        if ($request->input('coupon_code')) {
            $coupon = $this->coupon->where('code', $request->input('coupon_code'))->first();
            if ($coupon) {
                $dataOrderInsert ['coupon_id'] = $coupon->id;
            }
        }

        if (isset($idCountryRequest['province_id'])
            && isset($idCountryRequest['district_id'])
            && isset($idCountryRequest['ward_id'])) {
            $ship = $this->ship->where([
                'province_id' => $idCountryRequest['province_id'],
                'district_id' => $idCountryRequest['district_id'],
                'ward_id'     => $idCountryRequest['ward_id']
            ])->first();

            if (!$ship) {
                $defaultShip = $this->ship->where([
                    'province_id' => 0,
                    'district_id' => 0,
                    'ward_id'     => 0
                ])->first();

                $ship = $this->ship->create([
                    'province_id' => $idCountryRequest['province_id'],
                    'district_id' => $idCountryRequest['district_id'],
                    'ward_id'     => $idCountryRequest['ward_id'],
                    'price'       => $defaultShip->price
                ]);
            }

            $dataOrderInsert['ship_id'] = $ship->id;
        }

        if ($request->payment_id) {
            $payment = $this->payment->find($request->payment_id);
            if ($payment) {
                $dataOrderInsert['payment_id'] = $payment->id;
            } else {
                $json = [
                    'success' => false,
                    'errors'  => [
                        [__('payment_error')]
                    ],
                    'code'    => Response::HTTP_UNAUTHORIZED
                ];

                return response()->json($json, $json['code']);
            }
        }

        $dataOrderInsert['order_code'] = $orderCode;
        $dataOrderInsert['customer_id'] = auth()->guard('customer')->user()->id;
        $dataOrderInsert['status'] = 0;
        $dataOrderInsert = array_merge($dataOrderInsert, $request->only(['full_name', 'address', 'phone', 'email']));

        try {
            DB::beginTransaction();

            if ($slug) {
                $order = $this->order->create($dataOrderInsert);
                $product = $this->product->where('slug', $slug)->first();

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

            $request->session()->forget(['cart', 'order']);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            $isCreated = false;
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
        }

        if (!isset($isCreated)) {
            $json = [
                'success' => true,
                'data'    => [
                    'url_redirect' => route('order.index', ['language' => app()->getLocale()]),
                    'type'         => __('type_success'),
                    'message'      => __('your_order_success', ['name' => $orderCode])
                ],
            ];
        } else {
            $json = [
                'success' => false,
                'data'    => [
                    'type'    => __('type_error'),
                    'message' => __('error_message')
                ],
            ];
        }

        return response()->json($json);
    }

    public function destroy(Request $request, $language, $id)
    {
        $order = $this->order->find($id);
        $productsInOrder = $order->products;
        if ($order) {
            $order_code = $order->order_code;

            if ($order->status > 1) {
                return response()->json([
                    'success' => false,
                    'data'    => [
                        'type'    => __('type_warning'),
                        'message' => __('deleted_order_warning', ['name' => $order_code]),
                    ]
                ]);
            }
        }

        try {
            foreach ($productsInOrder as $item) {

                $product = $this->product->find($item->pivot->product_id);;
                $product->update([
                    'quantity'      => $product->quantity + $item->pivot->quantity,
                    'quantity_sold' => $product->quantity_sold - $item->pivot->quantity
                ]);
            }
            $order->products()->detach();
            $isDelete = $order->delete();
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        if (!$isDelete) {
            return response()->json([
                'success' => false,
                'data'    => [
                    'type'    => 'error',
                    'message' => __('error_message'),
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'type'    => 'success',
                'message' => __('deleted_order_success', ['name' => $order_code]),
            ]
        ]);
    }

}
