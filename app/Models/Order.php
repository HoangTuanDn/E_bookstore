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
            ->where('orders.status', 3);


        if (!empty($data['years'])) {
            $years = implode(',', $data['years']);
            $query->whereRaw('YEAR(orders.updated_at) IN (?)', $years);
        }

        return $query->get();
    }
}
