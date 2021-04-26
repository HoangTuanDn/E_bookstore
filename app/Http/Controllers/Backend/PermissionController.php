<?php

namespace App\Http\Controllers\Backend;

use App\Components\Message;
use App\Components\Recursive;
use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    private $permisson;

    /**
     * PermissionController constructor.
     * @param $permisson
     */
    public function __construct(Permission $permisson)
    {
        $this->permisson = $permisson;
    }

    public function index(Request $request)
    {
        $data = [];
        $filterName = $request->query('name');
        $sort = $request->query('sort', 'default');
        $order = $request->query('order', 'desc');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', config('custom.limit'));

        $data['latestCategories'] = [];

        $dataFilter = [
            'name'  => $filterName,
            'sort'  => $sort,
            'order' => $order,
            'page'  => $page,
            'limit' => $limit
        ];

        $permissions = $this->permisson->filterPermission($dataFilter);
        $permission_total = $permissions->total();

        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_code'] = qs_url('/admin/permissions/index', array_merge($url, ['sort' => 'code']));
        $data['sort_default'] = qs_url('/admin/permissions/index', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'name',
            'sort',
            'order',
        ]);


        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['permissions'] = $permissions;

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'name',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url('/admin/permissions/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.permission.inc.list_permission', $data)->render();
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
            $data['inc_list'] = view('admin.permission.inc.list_permission', $data);
            return view('admin.permission.index', $data);
        }
    }

    public function create(Request $request)
    {
        $groupPermissions = $this->permisson->where('parent_id', 0)->get(['id', 'name']);
        return view('admin.permission.create', compact('groupPermissions'));
    }

    public function store(PermissionRequest $request)
    {
        try {

            $dataInsert = $request->only(['name', 'display_name', 'parent_id', 'key_code']);
            $this->permisson->create($dataInsert);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('message: ' . $e->getMessage() . '--Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'create', __('permission'));


        return redirect()->route('permissions.index')
            ->with('message', $message)
            ->with('type', __('type_success'));
    }

    public function edit(Request $request, $id)
    {
        $permission = $this->permisson->find($id);
        $groupPermissions = $this->permisson->where('parent_id', 0)->get(['id', 'name']);

        return view('admin.permission.edit', compact('permission', 'groupPermissions'));
    }

    public function update(PermissionRequest $request, $id)
    {
        try {

            $dataUpdate = $request->only(['name', 'display_name', 'parent_id', 'key_code']);
            $this->permisson->find($id)->update($dataUpdate);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('message: ' . $e->getMessage() . '--Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'update', __('permission'));

        return redirect()->route('permissions.index')
            ->with('message', $message)
            ->with('type', __('type_info'));
    }

    public function destroy(Request $request, $id)
    {

        try {

            $groupPermissions = $this->permisson->where('parent_id', 0)->find($id);
            $allPermissions = $this->permisson->where('parent_id', '!=', 0)->get(['id', 'parent_id']);

            if ($groupPermissions) {
                $deletedIds = [];
                foreach ($allPermissions as $permission) {
                    if ($permission->parent_id === $groupPermissions->id) {
                        $deletedIds [] = $permission->id;
                    }
                }
                $deletedIds [] = $groupPermissions->id;

                $this->permisson->destroy($deletedIds);
            } else {
                $isDelete = $this->permisson->find($id)->delete();
            }

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete',  __('permission'));

        if (isset($isDelete)){
            $message = $this->getMessage('error', 'delete',  __('permission'));

            return response()->json([
                'success' => false,
                'data'    => [
                    'type'    => 'error',
                    'message' => $message,
                ]
            ]);
        }

        return response()->json([
            'id' => isset($deletedIds) ? $deletedIds : $id,
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
