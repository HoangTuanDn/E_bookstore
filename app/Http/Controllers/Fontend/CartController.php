<?php

namespace App\Http\Controllers\fontend;


use App\Components\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    private $product;

    /**
     * CartController constructor.
     * @param $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
        $data = session('cart');
        $totalPrice = 0;
        $totalItem = 0;
        if ($data) {
            foreach ($data as $item) {
                $totalPrice += $item['quantity'] * $item['price'];
            }
            $totalItem = count($data);

            if ($request->ajax()) {
                $boxCartHtml = view('fontend.cart.inc.box', compact('data', 'totalPrice', 'totalItem'))->render();
                return response()->json([
                    'success' => true,
                    'data'    => [
                        'html'       => $boxCartHtml,
                        'totalItem' => $totalItem,
                    ],
                ]);
            }

            $inc_list = view('fontend.cart.inc.list', compact('data'));
            return view('fontend.cart.cart', compact('inc_list', 'totalPrice'));
        }
    }

    public function store(Request $request)
    {
        $id = $request->id;

        try {

            $product = $this->product
                ->select('id', 'name', 'slug', 'discount', 'quantity', 'quantity_sold', 'featured_img')
                ->find($id);

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            return response()->json([
                'success' => false,
                'message' => $this->getMessage(__('error_message'))
            ]);
        }
        $cart = session('cart');

        $type = __('type_info');
        $message = $this->getMessage('', '', $product->name, __('exist_in_cart'));


        if (!isset($cart[$id])) {
            $cart[$id] = [
                'id'            => $product->id,
                'name'          => $product->name,
                'slug'          => $product->slug,
                'price'         => $product->discount,
                'total_product' => $product->quantity,
                'image'         => $product->featured_img,
                'quantity'      => 1
            ];

            $type = __('type_success');
            $message = $this->getMessage('', '', $product->name, __('add_to_cart'));

            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'totalItem' =>  count($cart),
                'type'    => $type,
                'message' => $message,
            ]
        ]);
    }

    public function destroy(Request $request)
    {

        $data = session('cart');
        $id = $request->id;
        $productName = '';
        if (isset($data[$id])) {
            $productName = $data[$id]['name'];
            unset($data[$id]);
        }

        $totalPrice = 0;
        $totalItem = 0;
        if ($data) {
            foreach ($data as $item) {
                $totalPrice += $item['quantity'] * $item['price'];
            }
            $totalItem =  count($data);
        }

        session()->put('cart', $data);

        $inc_list = view('fontend.cart.inc.list', compact('data'))->render();
        return response()->json([
            'success' => true,
            'data'    => [
                'type'    => __('type_info'),
                'content' => [
                    'html'       => $inc_list,
                    'totalPrice' => number_format($totalPrice, 0, ',', '.') . __('currency_unit'),
                    'totalItem'  => $totalItem,
                ],
                'message' => $this->getMessage('', '', $productName, __('deleted_product_in_cart'))
            ]
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $product = $this->product
            ->select('id', 'name', 'discount', 'quantity', 'quantity_sold')
            ->find($id);

        $data = session('cart');

        $quantityUpdate = $request->quantity;

        if ($quantityUpdate > $product->quantity) {
            return response()->json([
                'success' => true,
                'data'    => [
                    'type'    => __('type_warning'),
                    'message' => $this->getMessage('', '', $product->name, __('larger_than_total_quantity'))
                ]
            ]);
        }

        if (isset($data[$id]) && $product) {
            $data[$id]['quantity'] = $quantityUpdate;
            $data[$id]['price'] = $data[$id]['quantity'] * $product->discount;
        }

        $totalPrice = 0;
        if ($data) {
            foreach ($data as $item) {
                $totalPrice += $item['quantity'] * $item['price'];
            }
        }

        session()->put('cart', $data);

        $inc_list = view('fontend.cart.inc.list', compact('data'))->render();
        return response()->json([
            'success' => true,
            'data'    => [
                'type'    => __('type_info'),
                'content' => [
                    'html'       => $inc_list,
                    'totalPrice' => number_format($totalPrice) . __('currency_unit'),
                ],
                'message' => $this->getMessage('', '', '', __('increase_product_in_cart'))
            ]
        ]);

    }

    private function getMessage($type = '', $action = '', $name = '', $text = '')
    {
        $message = new Message($type, $text);
        return $message->getText($action, $name);
    }
}
