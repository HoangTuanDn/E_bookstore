<?php

namespace App\Http\Controllers\Backend;

use App\Components\Message;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    private $blogCategory;

    /**
     * BlogCategoryController constructor.
     * @param $blogCategory
     */
    public function __construct(BlogCategory $blogCategory)
    {
        $this->blogCategory = $blogCategory;
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

        $blogCategories = $this->blogCategory->filterBlogCategory($dataFilter);
        $total_blogCategries = $blogCategories->total();

        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_name'] = qs_url('/admin/blog/categories/index', array_merge($url, ['sort' => 'name']));
        $data['sort_default'] = qs_url('/admin/blog/categories/index', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'name',
            'sort',
            'order',
        ]);


        $data['sort'] = $sort;
        $data['blogCategories'] = $blogCategories;

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'name',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url('/admin/blog/categories/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.blog_category.inc.list_category', $data)->render();
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
            $data['inc_list'] = view('admin.blog_category.inc.list_category', $data);
            return view('admin.blog_category.index', $data);
        }
    }

    public function create(Request $request)
    {
        return view('admin.blog_category.create');
    }

    public function store(BlogCategoryRequest $request)
    {
        $request->validated();

        $input = $request->only(['name_vn', 'name_en']);

        $dataInsert = [
            'name' => [
                'vn' => $input['name_vn'],
                'en' => $input['name_en']
            ],
            'slug' => [
                'vn' => Str::slug($input['name_vn']),
                'en' => Str::slug($input['name_en'])
            ]
        ];

        try {
            $this->blogCategory->create($dataInsert);
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isCreated = false;
        }


        $message = $this->getMessage('success', 'create', __('blog_category'));

        if (isset($isCreated)) {
            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('blog_categories.index')
            ->with('message', $message)
            ->with('type', __('type_success'));
    }

    public function edit(Request $request, $id)
    {
        $blogCategory = $this->blogCategory->select('id', 'name')->find($id);

        return view('admin.blog_category.edit', compact('blogCategory'));
    }

    public function update(BlogCategoryRequest $request, $id)
    {
        $input = $request->only(['name_vn', 'name_en']);

        $dataUpdate = [
            'name' => [
                'vn' => $input['name_vn'],
                'en' => $input['name_en']
            ],
            'slug' => [
                'vn' => Str::slug($input['name_vn']),
                'en' => Str::slug($input['name_en'])
            ]
        ];

        try {
            $isUpdate = $this->blogCategory->find($id)->update($dataUpdate);

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isUpdate = false;
        }

        $message = $this->getMessage('success', 'update', __('blog_category'));

        if (!$isUpdate){
            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('blog_categories.index')
            ->with('message', $message)
            ->with('type', __('type_info'));

    }

    public function destroy(Request $request, $id)
    {
        $blogCategory = $this->blogCategory->find($id);
        try {
            foreach ($blogCategory->blogs as $blog) {
                $blog->delete();
            }
            $isDelete = $blogCategory->delete();

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete',  __('blog_category'));

        if (!$isDelete){
            $message = $this->getMessage('error', 'delete',  __('blog_category'));

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

    private function _getUrlFilter($list = [])
    {
        $url = [];

        call_user_func_array('preUrlFilter', [&$url, $list, [
            'name' => request()->query->has('name') ? urlencode(hed(request()->query('name'), ENT_QUOTES, 'UTF-8')) : '',
        ]]);

        return $url;
    }
}
