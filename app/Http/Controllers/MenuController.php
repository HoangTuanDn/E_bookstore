<?php

namespace App\Http\Controllers;

use App\Components\MenuRecursive;
use App\Components\Message;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MenuController extends Controller
{
    private $menu;
    private $recursive;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
        $this->recursive = new MenuRecursive($menu);
    }

    public function index()
    {
        $latestMenus= $this->menu->select('id', 'name', 'parent_id')
            ->oldest('id')->paginate(config('custom.limit'));

        return view('admin.menu.index', compact('latestMenus'));
    }


    public function create()
    {
        $htmlOption = $this->recursive->menuRecursiveAdd();

        return view('admin.menu.create', compact('htmlOption'));
    }




    public function store(Request $request)
    {
        $input = $request->only(['name', 'parent_id']);
        $collection = collect($input);

        try {
            $isCreated = $this->menu->create($collection->all());

        }catch (\Exception $e){
            $isCreated = false;
        }


        $message = $this->getMessage('success', 'create', __('menu'));

        if (!$isCreated){
            $message = $this->getMessage('error', 'create', __('menu'));
        }

        return redirect()->route('menus.index')
            ->with('message', $message)
            ->with('type', !$isCreated ? false : 1);

        return redirect()->route('menus.index');
    }


    public function edit(Request $request, $id)
    {

        $menu = $this->menu->select('id', 'name', 'parent_id')->find($id);

        $htmlOption = $this->recursive->menuRecursiveEdit($id);

        return view('admin.menu.edit', compact('menu', 'htmlOption'));
    }


    public function update(Request $request, $id)
    {
        $input = $request->only(['name', 'parent_id']);
        $collection = collect($input);

        try {
            $isUpdate = $this->menu->find($id)->update($collection->all());

        } catch (\Exception $e) {
            $isUpdate = false;
        }

        $message = $this->getMessage('success', 'update', __('menu'));

        if (!$isUpdate){
            $message = $this->getMessage('error', 'update', __('menu'));
        }

        return redirect()->route('menus.index')
            ->with('message', $message)
            ->with('type', $isUpdate);

    }


    public function destroy(Request $request, $id)
    {

        try {
            $isDelete = $this->menu->find($id)->delete();

        } catch (\Exception $e) {
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete',  __('menu'));

        if (!$isDelete){
            $message = $this->getMessage('error', 'delete',  __('menu'));

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
