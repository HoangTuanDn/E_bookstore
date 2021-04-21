<?php

namespace App\Http\Controllers\Backend;

use App\Components\Message;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    private $role;
    private $permission;

    /**
     * RoleController constructor.
     */
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
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

        $roles = $this->role->filterRole($dataFilter);
        $role_total = $roles->total();
        $permissions = $this->permission->get(['id', 'name', 'parent_id']);
        $allNamePermission = [];
        $rolePermission = [];

        foreach ($permissions as $permission) {
            if ($permission->parent_id === 0) {
                $allNamePermission[$permission->id]['name'] = $permission->name;
            }
            if (array_key_exists($permission->parent_id, $allNamePermission)) {
                $allNamePermission[$permission->parent_id]['id'][] = $permission->id;
            }
        }

        foreach ($roles as $role) {
            foreach ($role->permissions as $permission) {
                $rolePermission[$role->id][$permission->parent_id] ['name'][] = $permission->name;
                if (count($rolePermission[$role->id][$permission->parent_id]['name']) == count($allNamePermission[$permission->parent_id]['id'])) {
                    $rolePermission[$role->id][$permission->parent_id] ['full_name'] = $allNamePermission[$permission->parent_id]['name'];
                }
            }
        }

        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_name'] = qs_url('/admin/roles/index', array_merge($url, ['sort' => 'name']));
        $data['sort_default'] = qs_url('/admin/roles/index', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'name',
            'sort',
            'order',
        ]);


        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['roles'] = $roles;
        $data['rolePermission'] = $rolePermission;

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'name',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url('/admin/roles/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.role.inc.list_role', $data)->render();
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
            $data['inc_list'] = view('admin.role.inc.list_role', $data);
            return view('admin.role.index', $data);
        }

    }

    public function create(Request $request)
    {
        $permissions = $this->permission->where('parent_id', 0)->get(['id', 'name', 'display_name', 'key_code']);
        return view('admin.role.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {

        try {
            DB::beginTransaction();

            $dataInsert = $request->only(['name', 'display_name']);
            $instanceRole = $this->role->create($dataInsert);


            if ($request->has('permission')) {
                $instanceRole->permissions()->attach($request->permission);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('message: ' . $e->getMessage() . '--Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'create', __('role'));


        return redirect()->route('roles.index')
            ->with('message', $message)
            ->with('type', __('type_success'));
    }

    public function edit(Request $request, $id)
    {
        $permissions = $this->permission->where('parent_id', 0)->get(['id', 'name', 'display_name', 'key_code']);
        $role = $this->role->find($id);

        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function update(RoleRequest $request, $id)
    {

        try {
            DB::beginTransaction();

            $dataUpdate = $request->only(['name', 'display_name']);
            $this->role->find($id)->update($dataUpdate);

            $instanceRole = $this->role->find($id);

            if ($request->has('permission')) {
                $instanceRole->permissions()->sync($request->permission);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('message: ' . $e->getMessage() . '--Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'update', __('role'));


        return redirect()->route('roles.index')
            ->with('message', $message)
            ->with('type', __('type_success'));
    }

    public function destroy(Request $request, $id)
    {
        try {
            $role = $this->role->find($id);
            $isDelete = $role->delete();
            $role->permissions()->detach();

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete', __('role'));

        if (!$isDelete) {
            $message = $this->getMessage('error', 'delete', __('role'));

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
