<?php

namespace App\Http\Controllers\Backend;


use App\Jobs\SendCouponEmail;
use App\Mail\ConfirmMail;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\EmailContact;
use App\Models\Order;
use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    private $order;
    private $coupon;
    private $ship;
    private $emailContact;
    private $customer;

    /**
     * MailController constructor.
     * @param $order
     * @param $coupon
     * @param $ship
     * @param $emailContact
     * @param $customer
     */
    public function __construct(Order $order, Coupon $coupon, Ship $ship, Customer $customer, EmailContact $emailContact)
    {
        $this->order = $order;
        $this->coupon = $coupon;
        $this->ship = $ship;
        $this->customer = $customer;
        $this->emailContact = $emailContact;
    }

    public function confirm(Request $request, $id)
    {
        $order = $this->order->find($id);
        $coupon = $this->coupon->find($order->coupon_id);
        $ship = $this->ship->find($order->ship_id);

        if ($coupon) {
            $dataCoupon = [
                'coupon_code'      => $coupon->code,
                'coupon_discount'  => number_format($coupon->count, 0, ',', '.'),
            ];
        }

        if ($ship) {
            $dataShip = [
                'province' => $ship->province->name,
                'district' => $ship->district->name,
                'ward'     => $ship->ward->name,
                'price'    => number_format($ship->price, 0, ',', '.') . __('currency_unit')
            ];
        }

        $data = [
            'id'         => $order->id,
            'order_code' => $order->order_code,
            'full_name'  => $order->full_name,
            'phone'      => $order->phone,
            'email'      => $order->email,
            'status'     => $order->status,
            'created_at' => date('d/m/Y', strtotime($order->created_at)),
            'fee_ship'   => $ship ? $dataShip : null,
            'coupon'     => $coupon ? $dataCoupon : null,
            'payment'    => $order->payment->name,
            'payment_id'    => $order->payment->id,

        ];

        $subPrice = 0;
        foreach ($order->products as $product) {
            $subPrice += $product->discount * $product->pivot->quantity;
            $data['products'][] = [
                'name'     => $product->name,
                'quantity' => $product->pivot->quantity,
                'price'    => number_format($product->discount * $product->pivot->quantity, 0, ',', '.') . __('currency_unit')
            ];
        }

        $totalPrice = $subPrice;

        if (isset($order->coupon)) {

            if ($order->coupon->condition === 1) {
                $totalPrice *= ($order->coupon->count / 100);
            }
            if ($order->coupon->condition === 2) {
                $totalPrice -= $order->coupon->count;
            }
        }

        $totalPrice += $order->ship->price;
        $data['sub_price'] = $subPrice;
        $data['total_price'] = $totalPrice;

        try {
            Mail::to($order->email)
                ->send(new ConfirmMail($data, __('subject_detail'), 'fontend.Mail.confirm_mail'));
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'file : ' . $e->getFile() . 'Line : ' . $e->getLine());
            $isSuccess = false;
        }

        if (isset($isSuccess)) {
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
                'message' => __('message_confirm_success'),
            ]
        ]);
    }

    public function shareCoupon(Request $request, $id)
    {
       /*mail, subject, viewname  ,data['name'],  data['coupon_code'], data['coupon_discount']*/

        $customer = $this->customer->pluck('email')->toArray();
        $emailCustomerContact =  $this->emailContact->pluck('email')->toArray();
        $toEmails = array_unique(array_merge($customer, $emailCustomerContact));
        $coupon = $this->coupon->find($id);

        $details = [
            'emails' => $toEmails,
            'subject' => __('subject_coupon_detail'),
            'viewName' => 'fontend.Mail.share_coupon',
            'data' => [
                'coupon_code' => $coupon->code,
                'coupon_discount' => $coupon->condition === 1 ? $coupon->count . '%' : number_format($coupon->count, 0, ',', '.') . __('currency_unit')
            ]
        ];

        try {
            if ($coupon->is_publish === 1) {
                return response()->json([
                    'success' => true,
                    'data'    => [
                        'type'    => 'info',
                        'message' => __('message_coupon_info'),
                    ]
                ]);
            }

            SendCouponEmail::dispatch($details)->afterResponse();

            $coupon->update([
                'is_publish' => 1
            ]);

            exec('php artisan queue:work');

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'file : ' . $e->getFile() . 'Line : ' . $e->getLine());
            $isSuccess = false;
        }

        if (isset($isSuccess)) {
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
                'message' => __('message_coupon_success'),
            ]
        ]);
    }
}
