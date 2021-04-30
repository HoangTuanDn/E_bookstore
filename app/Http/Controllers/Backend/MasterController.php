<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class MasterController extends Controller
{
    private $order;

    /**
     * MasterController constructor.
     * @param $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index(View $view)
    {
        $orders = $this->order->getOrderIsNotConfirm();
        $data = [];
        $dateNow = Carbon::now('Asia/Ho_Chi_Minh');
        Carbon::setLocale('vi');
        if ($orders) {

            foreach ($orders as $order) {
                $order_time = new Carbon($order->created_at);
                $data[] = [
                    'id' => $order->id,
                    'status' => $order->status,
                    'payment_id' => $order->payment_id,
                    'payment_method' => $order->payment->name,
                    'order_code' => $order->order_code,
                    'created_at' => $order->created_at,
                    'time_ago' => $order_time->diffForHumans($dateNow),
            ];
            }
        }
        $view->with(['orders' => $data]);
    }
}
