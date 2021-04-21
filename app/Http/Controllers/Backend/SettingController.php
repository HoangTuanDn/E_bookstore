<?php

namespace App\Http\Controllers\Backend;

use App\Components\Message;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{

    private $setting;

    /**
     * SettingController constructor.
     */
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function index(Request $request)
    {
       /* $settings = $this->setting->select('id', 'config_key', 'config_value')->paginate(config('custom.limit'));
        return view('admin.setting.index', compact('settings'));*/

        $data = [];
        $filterKey = $request->query('key');
        $sort = $request->query('sort', 'default');
        $order = $request->query('order', 'desc');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', config('custom.limit'));

        $data['latestCategories'] = [];

        $dataFilter = [
            'key'  => $filterKey,
            'sort'  => $sort,
            'order' => $order,
            'page'  => $page,
            'limit' => $limit
        ];

        $settings = $this->setting->filterSetting($dataFilter);
        $setting_total = $settings->total();

        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_key'] = qs_url('/admin/settings/index', array_merge($url, ['sort' => 'key']));
        $data['sort_default'] = qs_url('/admin/settings/index', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'key',
            'sort',
            'order',
        ]);


        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['settings'] = $settings;

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'key',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url('/admin/settings/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.setting.inc.list_setting', $data)->render();
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
            $data['inc_list'] = view('admin.setting.inc.list_setting', $data);
            return view('admin.setting.index', $data);
        }
    }

    public function create(Request $request)
    {
        $type = $request->query('type');
        return view('admin.setting.create', compact('type'));
    }

    public function store(SettingRequest $request)
    {
        $request->validated();
        try {
            $dataInsert = $request->only(['config_key', 'config_value', 'type',
            ]);
            $this->setting->create($dataInsert);
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'create', __('setting'));

        return redirect()->route('settings.index')
            ->with('message', $message)
            ->with('type', __('type_success'));

    }

    public function edit(Request $request, $id){
        $setting = $this->setting->find($id);
        return view('admin.setting.edit', compact('setting'));

    }

    public function update(SettingRequest $request, $id){
        $request->validated();

        try {
            $dataUpdate = $request->only(['config_key', 'config_value', 'type',
            ]);
            $this->setting->find($id)->update($dataUpdate);
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'update', __('setting'));

        return redirect()->route('settings.index')
            ->with('message', $message)
            ->with('type', __('type_success'));
    }

    private function getMessage($type, $action = '', $name = '', $text = '')
    {
        $message = new Message($type, $text);
        return $message->getText($action, $name);
    }

    public function destroy(Request $request, $id){

        try {
            $isDelete = $this->setting->find($id)->delete();

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete',  __('setting'));

        if (!$isDelete){
            $message = $this->getMessage('error', 'delete',  __('setting'));

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

    private function _getUrlFilter($list = [])
    {
        $url = [];

        call_user_func_array('preUrlFilter', [&$url, $list, [
            'name' => request()->query->has('name') ? urlencode(hed(request()->query('name'), ENT_QUOTES, 'UTF-8')) : '',
        ]]);

        return $url;
    }
}


