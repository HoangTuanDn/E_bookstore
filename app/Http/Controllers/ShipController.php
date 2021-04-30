<?php

namespace App\Http\Controllers;

use App\Components\Message;
use App\Models\District;
use App\Models\Province;
use App\Models\Ship;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShipController extends Controller
{
    private $province;
    private $district;
    private $ward;
    private $ship;

    /**
     * ShipController constructor.
     * @param Province $province
     * @param District $district
     * @param Ward $ward
     * @param Ship $ship
     */
    public function __construct(Province $province, District $district, Ward $ward, Ship $ship)
    {
        $this->province = $province;
        $this->district = $district;
        $this->ward = $ward;
        $this->ship = $ship;
    }

    public function index(Request $request)
    {
        /* $ships = $this->ship->with(['province', 'district', 'ward'])->paginate(config('custom.limit'));
         return view('admin.ship.index', compact('ships'));*/
        $data = [];
        $filterProvinceName = $request->query('province_name');
        $filterDistrictName = $request->query('district_name');
        $filterWardName = $request->query('ward_name');
        $sort = $request->query('sort', 'default');
        $order = $request->query('order', 'desc');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', config('custom.limit'));

        $dataFilter = [
            'province_name' => $filterProvinceName,
            'district_name' => $filterDistrictName,
            'ward_name'     => $filterWardName,
            'sort'          => $sort,
            'order'         => $order,
            'page'          => $page,
            'limit'         => $limit
        ];

        $ships = $this->ship->filterShip($dataFilter);
        $ship_total = $ships->total();

        $url = $this->_getUrlFilter([
            'province_name',
            'district_name',
            'ward_name',
            'page'
        ]);

        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_province_name'] = qs_url('/admin/ships/index', array_merge($url, ['sort' => 'province_name']));
        $data['sort_district_name'] = qs_url('/admin/ships/index', array_merge($url, ['sort' => 'district_name']));
        $data['sort_ward_name'] = qs_url('/admin/ships/index', array_merge($url, ['sort' => 'ward_name']));
        $data['sort_price'] = qs_url('/admin/ships/index', array_merge($url, ['sort' => 'price']));
        $data['sort_default'] = qs_url('/admin/ships/index', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'province_name',
            'district_name',
            'ward_name',
            'sort',
            'order',
        ]);

        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['ships'] = $ships;

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'province_name',
                'district_name',
                'ward_name',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url('/admin/ships/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.ship.inc.list_ship', $data)->render();
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
            $data['inc_list'] = view('admin.ship.inc.list_ship', $data);
            return view('admin.ship.index', $data);
        }
    }

    public function create(Request $request)
    {
        $idCountryRequest = $request->only(['province_id', 'district_id']);

        $provinces = $this->province->all();
        $htmDistrictRender = '';
        $htmlRenderWard = '';

        if (isset($idCountryRequest['province_id'])) {
            $districts = $this->district->where('province_id', $idCountryRequest['province_id'])->get();
            foreach ($districts as $district) {
                $htmDistrictRender .= '<option value="' . $district->id . '">' . $district->name . '</option>';
            }
        }

        if (isset($idCountryRequest['district_id'])) {
            $wards = $this->ward->where('district_id', $idCountryRequest['district_id'])->get();
            foreach ($wards as $ward) {
                $htmlRenderWard .= '<option value="' . $ward->id . '">' . $ward->name . '</option>';
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data'    => [
                    'districtHtml' => $htmDistrictRender,
                    'wardHtml'     => $htmlRenderWard,
                ]
            ]);
        }

        return view('admin.ship.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $dataInsert = $request->only('province_id', 'district_id', 'ward_id', 'price');
        //dd($dataInsert);

        try {
            $isCreated = true;
            $this->ship->create($dataInsert);
        } catch (\Exception $e) {
            $isCreated = false;
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
        }


        $message = $this->getMessage('success', 'create', __('ship'));

        if (!$isCreated) {
            $message = $this->getMessage('error', 'create', __('ship'));

            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('ships.index')
            ->with('message', $message)
            ->with('type', __('type_success'));
    }

    public function update(Request $request, $id)
    {
        try {

            $newPrice = $request->new_price;
            $newPrice = trim(str_replace(',', '', $newPrice));
            $this->ship->find($id)->update([
                'price' => $newPrice
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('message: ' . $e->getMessage() . '--Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'update', __('ship'));

        return response()->json([
            'success' => true,
            'data'    => [
                'price'   => number_format($newPrice),
                'message' => $message,
                'type'    => __('type_success')
            ]
        ]);
    }

    private function getMessage($type, $action = '', $name = '', $text = '')
    {
        $message = new Message($type, $text);
        return $message->getText($action, $name);
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
