<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'orders';

    public function products()
    {
        return $this
            ->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function ship()
    {
        return $this
            ->belongsTo(Ship::class, 'ship_id');
    }

    public function coupon()
    {
        return $this
            ->belongsTo(Coupon::class, 'coupon_id');
    }

    public function payment()
    {
        return $this
            ->belongsTo(Payment::class, 'payment_id');
    }

    public function filterOrder($data)
    {
        $query = Order::select('id', 'order_code', 'status', 'created_at', 'updated_at');

        if (!empty($data['order_code'])) {
            $query->where('order_code', 'like', "%{$data['order_code']}%");
        }

        $sortData = [
            'code'       => 'order_code',
            'date'       => 'updated_at',
            'status'     => 'status',
            'created_at' => 'created_at'
        ];

        if (isset($data['sort']) && array_key_exists($data['sort'], $sortData)) {
            $sort = $sortData[$data['sort']];
        } else {
            $sort = $sortData['created_at'];
        }

        if (isset($data['order']) && (utf8_strtolower($data['order']) == 'desc')) {
            $order = "desc";
        } else {
            $order = "asc";
        }

        $query->orderBy($sort, $order);

        if (isset($data['limit'])) {
            if ($data['limit'] < 1) {
                $data['limit'] = config('custom.limit');
            }
        } else {
            $data['limit'] = config('custom.limit');
        }

        if (!isset($data['page'])) {
            $data['page'] = 1;
        }

        return $query->paginate($data['limit'], ['*'], 'page', $data['page']);
    }

    public function filterSale($data)
    {
        $query = Order::join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->select(DB::raw('orders.updated_at, YEAR(orders.updated_at) year, MONTH(orders.updated_at) month, (order_product.quantity * products.discount) as total_sale'))
            ->where('orders.status', 5);


        if (!empty($data['years'])) {
            $years = implode(',', $data['years']);
            $query->whereRaw('YEAR(orders.updated_at) IN (?)', [$years]);
        }

        return $query->get();
    }


    public function filterReport($data = [])
    {
        $query = Order::with(['payment', 'ship', 'products'])
            ->where('status', 5);

        if (isset($data['dateNow'])) {
            $query->whereDate('updated_at', '=', $data['dateNow']);

        }

        if (isset($data['monthNow'])) {
            $monthNow = explode('-', $data['monthNow']);
            $query->whereYear('updated_at', $monthNow[0])
                ->whereMonth('updated_at', $monthNow[1]);
        }

        if (isset($data['lastMonth'])) {
            $lastMonth = explode('-', $data['lastMonth']);
            $query->whereYear('updated_at', $lastMonth[0])
                ->whereMonth('updated_at', $lastMonth[1]);
        }

        if (isset($data['weekNow'])) {
            $firstWeekDay = $data['weekNow']['firstWeekDay'];
            $today = $data['weekNow']['today'];

            $query->whereBetween('updated_at', [$firstWeekDay, $today]);
        }

        if (isset($data['lastWeek'])) {
            $firstLastWeekDay = $data['lastWeek']['firstLastWeekDay'];
            $endLastWeekDay = $data['lastWeek']['endLastWeekDay'];

            $query->whereBetween('updated_at', [$firstLastWeekDay, $endLastWeekDay]);
        }

        if (isset($data['dateToDate'])) {
            $fromDate = $data['dateToDate']['fromDate'];
            $toDate = $data['dateToDate']['toDate'];
            $query->whereBetween('updated_at', [$fromDate, $toDate]);
        }

        return $query->get();
    }

    public function getOrderIsNotConfirm()
    {
        $query = Order::with(['payment', 'ship', 'products'])
            ->where('status', 0)
            ->orWhere(function ($query) {
                $query->where('payment_id', 3)
                    ->where('status', 4);
            })
            ->get();
        return $query;
    }
}
