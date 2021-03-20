<?php

namespace App\Http\Controllers;

use App\Components\Message;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use StorageImageTrait;
    private $user;
    private $role;
    /**
     * UserController constructor.
     */
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index(){
        $users = $this->user->select('id', 'name', 'image_path', 'email')->paginate(config('custom.limit'));
        return view('admin.user.index2', compact('users'));

    }

    public function create(Request $request){
        $roles = $this->role->get(['id', 'name']);
        return view('admin.user.create', compact('roles'));
    }

    public function store(UserRequest $request){

        try {
            DB::beginTransaction();

            $dataInsert = [
                'name'    => $request->name,
                'email'   => $request->email,
                'password'=> Hash::make($request->password),
            ];

            if ($request->hasFile('image_user')) {

                $data = $this->storageTraitUpload(
                    $request->image_user,
                    $dataInsert['name'],
                    config('custom.folder_user'),
                    auth()->guard('admin')->user()->id
                );

                $dataInsert['image_path'] = $data['file_path'];

            }


            $user = $this->user->create($dataInsert);

            if ($request->has('roles')) {
                $user->roles()->attach($request->roles);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('message: ' . $e->getMessage() . '--Line : ' . $e->getLine());
        }



        $message = $this->getMessage('success', 'create', __('admin'));


        return redirect()->route('users.index')
            ->with('message', $message)
            ->with('type', __('type_success'));

    }

    public function edit(Request $request, $id){
        $roles = $this->role->get(['id', 'name']);
        $user = $this->user->select('id', 'name', 'email', 'image_path')->find($id);
        $roleOfUser = $user->roles;
        return view('admin.user.edit', compact('user','roles', 'roleOfUser'));
    }

    public function update(UserRequest $request, $id){

        try {
            DB::beginTransaction();

            $dataUpdate = [
                'name'    => $request->name,
                'email'   => $request->email,
                'password'=> Hash::make($request->password),
            ];

            if ($request->hasFile('image_user')) {

                $data = $this->storageTraitUpload(
                    $request->image_user,
                    $dataUpdate['name'],
                    config('custom.folder_user'),
                    auth()->guard('admin')->user()->id
                );

                $dataUpdate['image_path'] = $data['file_path'];
            }

            $this->user->find($id)->update($dataUpdate);
            $user = $this->user->find($id);

            if ($request->has('roles')) {
                $user->roles()->sync($request->roles);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('message: ' . $e->getMessage() . '--Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'update', __('admin'));


        return redirect()->route('users.index')
            ->with('message', $message)
            ->with('type', __('type_success'));
    }

    public function destroy(Request $request , $id){


        try {
            $user =  $this->user->find($id);
            $isDelete = $user->delete();
            $user->roles()->detach();

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete',  __('product'));

        if (!$isDelete){
            $message = $this->getMessage('error', 'delete',  __('product'));

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
