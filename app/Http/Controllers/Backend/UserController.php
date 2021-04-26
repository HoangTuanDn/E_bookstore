<?php

namespace App\Http\Controllers\Backend;

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

    public function index(Request $request){

        $data = [];
        $filterName = $request->query('username');
        $sort = $request->query('sort', 'default');
        $order = $request->query('order', 'desc');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', config('custom.limit'));


        $dataFilter = [
            'name'  => $filterName,
            'sort'  => $sort,
            'order' => $order,
            'page'  => $page,
            'limit' => $limit
        ];

        $users = $this->user->filterUser($dataFilter);
        $total_user = $users->total();

        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_name'] = qs_url('/admin/users/index', array_merge($url, ['sort' => 'username']));
        $data['sort_default'] = qs_url('/admin/users/index', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'name',
            'sort',
            'order',
        ]);


        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['users'] = $users;

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'name',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url('/admin/users/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.user.inc.list_user', $data)->render();
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
            $data['inc_list'] = view('admin.user.inc.list_user', $data);
            return view('admin.user.index2', $data);
        }

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
            ->with('type', __('type_info'));
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

    private function _getUrlFilter($list = [])
    {
        $url = [];

        call_user_func_array('preUrlFilter', [&$url, $list, [
            'name' => request()->query->has('name') ? urlencode(hed(request()->query('name'), ENT_QUOTES, 'UTF-8')) : '',
        ]]);

        return $url;
    }
}
