<?php

namespace App\Http\Controllers;

use App\Components\Message;
use App\Components\Recursive;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Type;

class CategoryController extends Controller
{
    private Category $category;
    private Recursive $recursive;

    public function __construct(Category $category, Recursive $recursive)
    {
        $this->category = $category;
        $this->recursive = $recursive;
    }

    public function index()
    {
        $latestCategories = $this->category->select('id', 'name', 'parent_id')
            ->oldest('id')->paginate(config('custom.limit'));

        return view('admin.category.index', compact('latestCategories'));
    }


    public function create()
    {
        $htmlOption = $this->getHtmlOption();
        return view('admin.category.create', compact('htmlOption'));
    }


    public function store(Request $request)
    {
        $input = $request->only(['name', 'parent_id']);
        $collection = collect($input);
        $collection->put('slug', Str::slug($input['name']));

        $this->category->create($collection->all());

        return redirect()->route('categories.index');
    }


    public function edit(Request $request, $id)
    {

        $category = $this->category->select('id', 'name', 'parent_id')->find($id);
        $htmlOption = $this->getHtmlOption($category->parent_id);

        return view('admin.category.edit', compact('category', 'htmlOption'));
    }


    public function update(Request $request, $id)
    {
        $input = $request->only(['name', 'parent_id']);
        $collection = collect($input);
        $collection->put('slug', Str::slug($input['name']));

        try {
            $isUpdate = $this->category->find($id)->update($collection->all());

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isUpdate = false;
        }

        $message = $this->getMessage('success', 'update', __('category'));

        if (!$isUpdate){
            $message = $this->getMessage('error', 'update', __('category'));
        }

        return redirect()->route('categories.index')
                         ->with('message', $message)
                         ->with('type', $isUpdate);

    }


    public function destroy(Request $request, $id)
    {

        try {
            $isDelete = $this->category->find($id)->delete();

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete',  __('category'));

        if (!$isDelete){
            $message = $this->getMessage('error', 'delete',  __('category'));

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

    private function getHtmlOption(int $paren_id = 0)
    {
        $categories = $this->category->get(['id', 'name', 'parent_id']);
        $this->recursive->setData($categories);

        $htmlOption = $this->recursive->categoryRecursive($paren_id);

        return $htmlOption;
    }

}
