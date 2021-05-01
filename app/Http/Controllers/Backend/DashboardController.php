<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use http\Env\Response;
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

        if ($request->ajax()) {
            $json = [
                'success' => true,
                'data'    => [
                    'chart' => $chart
                ],
            ];
            return response()->json($json);
        }

        /*handle report table*/
        $filterReport = $request->input('filter_time');
        $customFilter = $request->only(['time_from', 'time_to']);


        if ($filterReport || $customFilter) {
            $timeNow = Carbon::now('Asia/Ho_Chi_Minh');
            $dateNow = $timeNow->format('Y-m-d');
            $firstWeekDay = $timeNow->startOfWeek()->format('Y-m-d');
            $firstLastWeekDay = new Carbon($firstWeekDay);
            $endLastWeekDay = $firstLastWeekDay->subDay()->format('Y-m-d');
            $firstLastWeekDay = $firstLastWeekDay->subDays(6)->format('Y-m-d');

            $arrayFilter = [
                'dateNow'    => $dateNow,
                'weekNow'    => [
                    'firstWeekDay' => $firstWeekDay,
                    'today'        => $dateNow,
                ],
                'lastWeek'   => [
                    'firstLastWeekDay' => $firstLastWeekDay,
                    'endLastWeekDay'   => $endLastWeekDay,
                ],
                'monthNow'   => date('Y-m', strtotime($dateNow)),
                'lastMonth'  => date('Y-m', strtotime($dateNow . ' - 1 month'))
            ];

            if (!empty($customFilter)) {
                $arrayFilter['dateToDate'] = [
                    'fromDate' => date('Y-m-d', strtotime($customFilter['time_from'])),
                    'toDate'   => date('Y-m-d', strtotime($customFilter['time_to'])),
                ];
            }

            $dataFilter = $filterReport ? [$filterReport => $arrayFilter[$filterReport]] : ['dateToDate' => $arrayFilter['dateToDate']];

            $orders = $this->order->filterReport($dataFilter);
            $data = $this->getReportData($orders);
        } else {
            $orders = $this->order->filterReport();
            $data = $this->getReportData($orders);
        }


        $dataRenders = $data ? $data['dataRenders'] : '';
        $totalPriceSale = $data ? $data['totalPriceSale'] : 0;
        $totalItem = $data ? $data['totalItem'] : 0;

        $inc_list = view('admin.dashboard.dashboard', compact('dataRenders', 'totalPriceSale', 'totalItem'));

        return view('admin.home', compact('totalYearSale', 'totalIncrement', 'yearsNow', 'lastYear', 'inc_list'));
    }

    private function getReportData($orders)
    {
        $dataRenders = [];
        $totalPriceSale = 0;
        $totalItem = 0;

        if (!$orders) {
            return [];
        }

        foreach ($orders as $order) {
            foreach ($order->products as $product) {
                $totalPriceSale += $product->pivot->quantity * $product->discount;
                $totalItem += $product->pivot->quantity;
                if (!isset($dataRenders[$product->id])) {
                    $dataRenders[$product->id] = [
                        'id'           => $product->id,
                        'name'         => $product->name,
                        'featured_img' => $product->featured_img,
                        'price'        => $product->price,
                        'discount'     => $product->discount,
                        'total_sold'   => $product->quantity_sold,
                        'sold'         => $product->pivot->quantity,
                        'quantity'     => $product->quantity
                    ];
                } else {
                    $dataRenders[$product->id]['sold'] += $product->pivot->quantity;
                }

            }
        }

        return ['dataRenders' => $dataRenders, 'totalPriceSale' => $totalPriceSale, 'totalItem' => $totalItem];

    }

    private function caculateIncrementSale($newSale, $oldSale)
    {
        if ($oldSale === 0) {
            return 100;
        }
        if ($newSale === 0) {
            return 0;
        }
        return ($newSale - $oldSale) / $oldSale * 100;
    }
}
