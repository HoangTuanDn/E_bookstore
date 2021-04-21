<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    protected $order;
    protected $product;

    /**
     * DashboardController constructor.
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
        $yearsNow = date('Y', strtotime('now'));
        $monthNow = date('n', strtotime('now'));
        $lastYear = strval($yearsNow - 1);
        $years = [$yearsNow, $lastYear];
        $data = [
            'years' => $years
        ];
        $sales = $this->order->filterSale($data);
        $chart = [];

        if ($sales) {
            foreach ($years as $year) {
                for ($i = 1; $i <= 12; $i++)
                    $chart[$year][$i] = 0;
            }

            foreach ($sales as $sale) {
                $chart[$sale->year][$sale->month] += $sale->total_sale;
            }
        }

        $totalYearSale = number_format(array_sum($chart[$yearsNow]), 0, ',', '.') . __('currency_unit');
        $totalIncrement = $this->caculateIncrementSale($chart[$yearsNow][$monthNow], $chart[$yearsNow][$monthNow - 1]);
        $products = $this->product->get(['id', 'name' , 'price','featured_img', 'quantity', 'quantity_sold']);

        if ($request->ajax()) {
            $json = [
                'success' => true,
                'data'    => [
                    'chart' => $chart
                ],
            ];
            return response()->json($json);
        }

        return view('admin.home', compact('totalYearSale', 'totalIncrement', 'yearsNow', 'lastYear', 'products'));
    }

    private function caculateIncrementSale($newSale, $oldSale)
    {
        if ($oldSale === 0) {
            return 100;
        }
        return ($newSale - $oldSale) / $oldSale * 100;
    }
}
