<?php

namespace App\Http\Controllers;

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
    private $permisson;
    /**
     * RoleController constructor.
     */
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permisson = $permission;
    }

    public function index(){
        $roles = $this->role->select('id', 'name','display_name')->paginate(config('custom.limit'));
            return view('admin.role.index', compact('roles'));
    }

    public function create(Request $request){
        $permissions = $this->permisson->where('parent_id', 0)->get(['id', 'name', 'display_name', 'key_code']);
        return view('admin.role.create',compact('permissions'));
    }

    public function store(RoleRequest $request){

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

    public function edit(Request $request, $id){
        $permissions = $this->permisson->where('parent_id', 0)->get(['id', 'name', 'display_name', 'key_code']);
        $role = $this->role->find($id);

        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function update(RoleRequest $request, $id){

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

    public function destroy(Request $request, $id){
        try {
            $role =  $this->role->find($id);
            $isDelete = $role->delete();
            $role->permissions()->detach();

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete',  __('role'));

        if (!$isDelete){
            $message = $this->getMessage('error', 'delete',  __('role'));

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
