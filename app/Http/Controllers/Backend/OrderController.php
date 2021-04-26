<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    private Order $order;
    private Product $product;

    /**
     * OrderController constructor.
     * @param Order $order
     * @param Product $product
     */
    public function __construct(Order $order, Product $product)
    {
        $this->order = $order;
        $this->product = $product;
    }

    public function index(Request $request)
    {
        $data = [];
        $filterCode = $request->query('code');
        $sort = $request->query('sort', 'default');
        $order = $request->query('order', 'desc');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', config('custom.limit'));

        $data['orders'] = [];

        $dataFilter = [
            'order_code' => $filterCode,
            'sort'       => $sort,
            'order'      => $order,
            'page'       => $page,
            'limit'      => $limit
        ];

        $orders = $this->order->filterOrder($dataFilter);
        $order_total = $orders->total();

        $url = $this->_getUrlFilter([
            'code',
            'page'
        ]);

        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_status'] = qs_url('/admin/orders/index', array_merge($url, ['sort' => 'status']));
        $data['sort_date'] = qs_url('/admin/orders/index', array_merge($url, ['sort' => 'date']));
        $data['sort_default'] = qs_url('/admin/orders/index', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'code',
            'sort',
            'order',
        ]);

        $data['sort'] = $sort;
        $data['orders'] = $orders;

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'code',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url('/admin/orders/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.order.inc.list_order', $data)->render();
            } catch (\Exception $e) {
                $htmlContent = null;
            }

            return response()->json([
                'success' => true,
                'data'    => [
                    'url' => $url
                ],
                'html'    => [
                    'result'  => $data['result'],
                    'content' => $htmlContent
                ]
            ]);
        } else {
            $data['inc_list'] = view('admin.order.inc.list_order', $data);
            return view('admin.order.index', $data);
        }
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
        if ($request->status < $order->status) {
            $json = [
                'success' => false,
                'data'    => [
                    'type'    => __('type_warning'),
                    'message' => __('error_update_order_message')
                ]
            ];
            return response()->json($json);
        }
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
                'success' => false,
                'data'    => [
                    'updated_at' => date('Y-m-d H:i:s', strtotime($order->updated_at)),
                    'type'       => __('type_success'),
                    'message'    => __('update_order_success')
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

            if ($order->status < 2) {
                $productsInOrder = $order->products;
                $order_code = $order->order_code;

                foreach ($productsInOrder as $item) {
                    $product = $this->product->find($item->pivot->product_id);
                    $product->update([
                        'quantity'      => $product->quantity + $item->pivot->quantity,
                        'quantity_sold' => $product->quantity_sold - $item->pivot->quantity
                    ]);
                }
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

    private function _getUrlFilter($list = [])
    {
        $url = [];

        call_user_func_array('preUrlFilter', [&$url, $list, [
            'name' => request()->query->has('name') ? urlencode(hed(request()->query('name'), ENT_QUOTES, 'UTF-8')) : '',
        ]]);

        return $url;
    }
}
