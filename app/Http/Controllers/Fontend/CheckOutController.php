<?php

namespace App\Http\Controllers\fontend;


use App\Models\Coupon;
use App\Models\District;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Province;
use App\Models\Ship;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CheckOutController extends Controller
{
    private $province;
    private $district;
    private $ward;
    private $ship;
    private $coupon;
    private $payment;
    private $product;

    /**
     * ShipController constructor.
     * @param Province $province
     * @param District $district
     * @param Ward $ward
     * @param Ship $ship
     * @param Coupon $coupon
     * @param Payment $payment
     * @param Product $product
     */
    public function __construct(Province $province, District $district, Ward $ward, Ship $ship, Coupon $coupon, Payment $payment, Product $product)
    {
        $this->province = $province;
        $this->district = $district;
        $this->ward = $ward;
        $this->ship = $ship;
        $this->coupon = $coupon;
        $this->payment = $payment;
        $this->product = $product;
    }


    public function index(Request $request, $language, $slug = null)
    {
        /*    session()->flush();*/
        $idCountryRequest = $request->only(['province_id', 'district_id', 'ward_id']);
        $provinces = $this->province->all();
        $htmDistrictRender = '<option value="">' . __('select_district') . '</option>';
        $htmlRenderWard = '<option value="">' . __('select_ward') . '</option>';
        $couponData = [];
        $totalPrice = 0;
        $data = session('cart');
        $order = session('order');
        $couponCode = $request->input('coupon_code');

        if ($slug) {
            $data = $this->product->where('slug', $slug)->first();
            if (!$data){
                return view('fontend.error_404');
            }
        }


        if (isset($idCountryRequest['province_id'])
            && !isset($idCountryRequest['district_id'])
            && !isset($idCountryRequest['ward_id'])) {
            $districts = $this->district->where('province_id', $idCountryRequest['province_id'])->get();
            foreach ($districts as $district) {
                $htmDistrictRender .= '<option value="' . $district->id . '">' . $district->name . '</option>';

            }
            $json = [
                'success' => true,
                'data'    => [
                    'districtHtml' => $htmDistrictRender,
                ]
            ];
            if ($request->ajax()) {
                return response()->json($json);
            }

        }

        if (isset($idCountryRequest['district_id'])
            && !isset($idCountryRequest['province_id'])
            && !isset($idCountryRequest['ward_id'])) {
            $wards = $this->ward->where('district_id', $idCountryRequest['district_id'])->get();
            foreach ($wards as $ward) {
                $htmlRenderWard .= '<option value="' . $ward->id . '">' . $ward->name . '</option>';
            }

            $json = [
                'success' => true,
                'data'    => [
                    'wardHtml' => $htmlRenderWard,
                ]
            ];
            if ($request->ajax()) {
                return response()->json($json);
            }

        }

        if ($data) {
            if ($slug) {
                $totalPrice = $data->discount;
            } else {
                foreach ($data as $item) {
                    $data[$item['id']]['sub_price'] = $item['quantity'] * $item['price'];
                    $totalPrice += $item['quantity'] * $item['price'];
                }
            }

            if (!isset($order)) {
                $order['total_price'] = $totalPrice;
                $order['fee_ship'] = 0;
                $order['coupon_code'] = '';
            }
        }

        if (!empty($order['coupon_code'])) {
            $coupon = $this->coupon->where('code', $order['coupon_code'])->first();

            if ($coupon) {
                $couponData = [
                    'condition' => $coupon->condition,
                    'discount'  => $coupon->count,
                ];
            }

        }

        if (!empty($order['coupon_code']) && isset($couponCode) && $order['coupon_code'] != $couponCode) {
            $json = [
                'success' => true,
                'data'    => [
                    'type'    => __('type_warning'),
                    'message' => __('coupon_only', ['name' => $couponCode])
                ]
            ];

            if ($request->ajax()) {
                return response()->json($json);
            }
        }

        if (!empty($order['coupon_code']) && $order['coupon_code'] == $couponCode) {
            $json = [
                'success' => true,
                'data'    => [
                    'type'    => __('type_warning'),
                    'message' => __('coupon_warning', ['name' => $couponCode])
                ]
            ];

            if ($request->ajax()) {
                return response()->json($json);
            }

        }

        $coupon = $this->coupon->where('code', $couponCode)->first();

        if ($coupon) {
            $order['coupon_code'] = $couponCode;

            $couponData = [
                'condition' => $coupon->condition,
                'discount'  => $coupon->count,
            ];

            if ($coupon->condition === 1) {
                $order['total_price'] *= ($coupon->count / 100);
            }
            if ($coupon->condition === 2) {
                $order['total_price'] -= $coupon->count;
            }

            session()->put('order', $order);
            $inc_cart = view('fontend.checkout.inc.checkout', compact('data', 'slug', 'totalPrice', 'order', 'couponData'))->render();

            $json = [
                'success' => true,
                'data'    => [
                    'detailOrderHtml' => $inc_cart,
                    'type'            => __('type_success'),
                    'message'         => __('coupon_success', ['name' => $couponCode])
                ]
            ];
        } else {
            $json = [
                'success' => false,
                'message' => __('coupon_error', ['name' => $couponCode])
            ];
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
                $ship = $this->ship->where([
                    'province_id' => 0,
                    'district_id' => 0,
                    'ward_id'     => 0
                ])->first();
            }


            if ($order['fee_ship'] !== 0) {
                $order['total_price'] -= $order['fee_ship'];
            }
            $order['fee_ship'] = $ship->price;
            $order['total_price'] += $ship->price;

            session()->put('order', $order);

            $inc_cart = view('fontend.checkout.inc.checkout', compact('data', 'slug', 'totalPrice', 'order', 'couponData'))->render();

            $json = [
                'success' => true,
                'data'    => [
                    'type'            => __('type_success'),
                    'detailOrderHtml' => $inc_cart,
                    'message'         => __('fee_ship')
                ]
            ];
        }

        if ($request->ajax()) {
            return response()->json($json);
        }

        session()->put('order', $order);

        if ($data){
            $inc_cart = view('fontend.checkout.inc.checkout', compact('data', 'slug', 'totalPrice', 'order', 'couponData'))->render();
            return view('fontend.checkout.checkout', compact('provinces', 'slug', 'inc_cart', 'order'));
        }

    }

}
