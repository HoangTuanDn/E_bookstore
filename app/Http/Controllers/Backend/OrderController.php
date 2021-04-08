<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    private $order;

    /**
     * OrderController constructor.
     * @param $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $orders = $this->order->select('id', 'order_code', 'status', 'created_at', 'updated_at')->paginate(config('custom.limit'));
        return view('admin.order.index', compact('orders'));
    }

    public function show(Request $request, $id)
    {
        $order = $this->order->find($id);
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

        return view('admin.order.detail', compact('order', 'totalPrice'));
    }

    public function update(Request $request, $id)
    {
        $order = $this->order->find($id);
        try {
            if ($order) {
                $isUpdate = $order->update([
                    'status' => $request->status
                ]);
            }
        } catch (\Exception $e) {
            $isUpdate = false;
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
        }

        if ($isUpdate) {
            $json = [
                'success' => true,
                'data'    => [
                    'updated_at' => date('Y-m-d H:i:s', strtotime($order->updated_at)),
                    'type'    => __('type_success'),
                    'message' => __('update_order_success')
                ]
            ];
        } else {
            $json = [
                'success' => true,
                'data'    => [
                    'type'    => __('type_error'),
                    'message' => __('error_message')
                ]
            ];
        }

        return response()->json($json);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $order = $this->order->find($id);
            $order_code = $order->order_code;
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
                'message' => __('deleted_order_success',['name' => $order_code]),
            ]
        ]);
    }
}
