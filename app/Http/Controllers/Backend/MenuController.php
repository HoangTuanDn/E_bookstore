<?php

namespace App\Http\Controllers\Backend;

use App\Components\MenuRecursive;
use App\Components\Message;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    private $menu;
    private $recursive;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
        $this->recursive = new MenuRecursive($menu);
    }

    public function index(Request $request)
    {
        $data = [];
        $filterName = $request->query('name');
        $sort = $request->query('sort', 'default');
        $order = $request->query('order', 'desc');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', config('custom.limit'));

        $data['latestMenus'] = [];

        $dataFilter = [
            'name'  => $filterName,
            'sort'  => $sort,
            'order' => $order,
            'page'  => $page,
            'limit' => $limit
        ];

        $latestMenus = $this->menu->filterMenu($dataFilter);
        $menu_total = $latestMenus->total();

        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_name'] = qs_url('/admin/menus/index', array_merge($url, ['sort' => 'name']));
        $data['sort_default'] = qs_url('/admin/menus/index', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'name',
            'sort',
            'order',
        ]);


        $data['sort'] = $sort;
        $data['latestMenus'] = $latestMenus;

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'name',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url('/admin/menus/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.menu.inc.list_menu', $data)->render();
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
            $data['inc_list'] = view('admin.menu.inc.list_menu', $data);
            return view('admin.menu.index', $data);
        }
    }


    public function create()
    {
        $htmlOption = $this->recursive->menuRecursiveAdd();

        return view('admin.menu.create', compact('htmlOption'));
    }


    public function store(MenuRequest $request)
    {
        $input = $request->only(['name', 'parent_id']);
        $collection = collect($input);

        try {
            $this->menu->create($collection->all());

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isCreated = false;
        }


        $message = $this->getMessage('success', 'create', __('menu'));

        if (isset($isCreated)) {
            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('menus.index')
            ->with('message', $message)
            ->with('type', __('type_success'));
    }


    public function edit(Request $request, $id)
    {

        $menu = $this->menu->select('id', 'name', 'parent_id')->find($id);

        $htmlOption = $this->recursive->menuRecursiveEdit($id);

        return view('admin.menu.edit', compact('menu', 'htmlOption'));
    }


    public function update(MenuRequest $request, $id)
    {
        $input = $request->only(['name', 'parent_id']);
        $collection = collect($input);

        try {
            $isUpdate = $this->menu->find($id)->update($collection->all());

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isUpdate = false;
        }

        $message = $this->getMessage('success', 'update', __('menu'));

        if (!$isUpdate) {
            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('menus.index')
            ->with('message', $message)
            ->with('type', __('type_info'));

    }


    public function destroy(Request $request, $id)
    {

        try {
            $isDelete = $this->menu->find($id)->delete();

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete', __('menu'));

        if (!$isDelete) {
            $message = $this->getMessage('error', 'delete', __('menu'));

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
