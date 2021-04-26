<?php

namespace App\Http\Controllers\Backend;

use App\Components\Message;
use App\Components\Recursive;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    private Category $category;
    private Recursive $recursive;

    public function __construct(Category $category, Recursive $recursive)
    {
        $this->category = $category;
        $this->recursive = $recursive;
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

        $latestCategories = $this->category->filterCategory($dataFilter);
        $category_total = $latestCategories->total();

        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_name'] = qs_url('/admin/categories/index', array_merge($url, ['sort' => 'name']));
        $data['sort_default'] = qs_url('/admin/categories/index', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'name',
            'sort',
            'order',
        ]);


        $data['sort'] = $sort;
        $data['latestCategories'] = $latestCategories;

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'name',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url('/admin/categories/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.category.inc.list_category', $data)->render();
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
            $data['inc_list'] = view('admin.category.inc.list_category', $data);
            return view('admin.category.index', $data);
        }
    }


    public function create()
    {
        $htmlOption = $this->getHtmlOption();
        return view('admin.category.create', compact('htmlOption'));
    }


    public function store(CategoryRequest $request)
    {
        $input = $request->only(['name', 'parent_id']);
        $collection = collect($input);
        $collection->put('slug', Str::slug($input['name']));

        try {
            $this->category->create($collection->all());
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isCreated = false;
        }

        $message = $this->getMessage('success', 'create', __('category'));

        if (isset($isCreated)) {
            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('categories.index')
            ->with('message', $message)
            ->with('type', __('type_success'));

    }


    public function edit(Request $request, $id)
    {
        $category = $this->category->select('id', 'name', 'parent_id')->find($id);
        $htmlOption = $this->getHtmlOption($category->parent_id);

        return view('admin.category.edit', compact('category', 'htmlOption'));
    }


    public function update(CategoryRequest $request, $id)
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
        if (!$isUpdate) {
            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('categories.index')
            ->with('message', $message)
            ->with('type', __('type_info'));

    }


    public function destroy(Request $request, $id)
    {
        try {
            $isDelete = $this->category->find($id)->delete();

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete', __('category'));

        if (!$isDelete) {
            $message = $this->getMessage('error', 'delete', __('category'));

            return response()->json([
                'check'   => $isDelete,
                'success' => false,
                'data'    => [
                    'type'    => __('type_error'),
                    'message' => $message,
                ]
            ]);
        }

        return response()->json([
            'check'   => $isDelete,
            'success' => true,
            'data'    => [
                'type'    => __('type_info'),
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

    private function _getUrlFilter($list = [])
    {
        $url = [];

        call_user_func_array('preUrlFilter', [&$url, $list, [
            'name' => request()->query->has('name') ? urlencode(hed(request()->query('name'), ENT_QUOTES, 'UTF-8')) : '',
        ]]);

        return $url;
    }

}
