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

    public function index(){
        $coupons = $this->coupon->latest('id')->paginate(5);
        return view('admin.coupon.index', compact('coupons'));
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

}
