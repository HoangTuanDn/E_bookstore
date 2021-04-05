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

    public function index()
    {
        $permissions = $this->permisson->select('id', 'name', 'display_name', 'key_code')->paginate(config('custom.limit'));
        return view('admin.permission.index', compact('permissions'));
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
            ->with('type', __('type_success'));
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

}
