<?php

namespace App\Http\Controllers\Backend;

use App\Components\Message;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    private $coupon;

    /**
     * CouponController constructor.
     * @param $coupon
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function index(Request $request){
        /*$coupons = $this->coupon->latest('id')->paginate(5);
        return view('admin.coupon.index', compact('coupons'));*/

        $data = [];
        $filterName = $request->query('name');
        $filterCode = $request->query('code');
        $sort = $request->query('sort', 'default');
        $order = $request->query('order', 'desc');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', config('custom.limit'));


        $dataFilter = [
            'name'  => $filterName,
            'code'  => $filterCode,
            'sort'  => $sort,
            'order' => $order,
            'page'  => $page,
            'limit' => $limit
        ];

        $coupons = $this->coupon->filterCoupon($dataFilter);
        $coupon_total = $coupons->total();

        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_code'] = qs_url('/admin/coupons/index', array_merge($url, ['sort' => 'code']));
        $data['sort_number'] = qs_url('/admin/coupons/index', array_merge($url, ['sort' => 'number_apply']));
        $data['sort_condition'] = qs_url('/admin/coupons/index', array_merge($url, ['sort' => 'condition']));
        $data['sort_default'] = qs_url('/admin/coupons/index', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'name',
            'code',
            'sort',
            'order',
        ]);


        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['coupons'] = $coupons;

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'name',
                'code',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url('/admin/coupons/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.coupon.inc.list_coupon', $data)->render();
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
            $data['inc_list'] = view('admin.coupon.inc.list_coupon', $data);
            return view('admin.coupon.index', $data);
        }
    }

    public function create(Request $request){
        return view('admin.coupon.create');
    }

    public function store(CouponRequest $request)
    {
        $request->validated();

        $dataUpdate = $request->only(['name', 'code', 'number', 'condition', 'count']);
        try {
            $this->coupon->create($dataUpdate);

        }catch (\Exception $e){
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'create', __('coupon'));

        return redirect()->route('coupons.index')
            ->with('message', $message)
            ->with('type', __('type_success'));
    }

    public function destroy(Request $request, $id){
        try {
            $coupon = $this->coupon->find($id);
            $isDelete = $coupon->delete();

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete', __('coupon'));

        if (!$isDelete) {
            $message = $this->getMessage('error', 'delete', __('coupon'));

            return response()->json([
                'check'   => $isDelete,
                'success' => false,
                'data'    => [
                    'type'    => 'error',
                    'message' => $message,
                ]
            ]);
        }

        return response()->json([
            'check'   => $isDelete,
            'success' => true,
            'data'    => [
                'type'    => 'success',
                'message' => $message,
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
