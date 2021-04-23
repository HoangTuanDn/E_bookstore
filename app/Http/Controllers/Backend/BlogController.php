<?php

namespace App\Http\Controllers\Backend;

use App\Components\Message;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Traits\Notifiable;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use StorageImageTrait;
    use Notifiable;

    private $blog;
    private $blogCategory;

    /**
     * BlogController constructor.
     * @param $blog
     * @param $blogCategory
     */
    public function __construct(Blog $blog, BlogCategory $blogCategory)
    {
        $this->blog = $blog;
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

        $data['blogs'] = [];

        $dataFilter = [
            'name'      => $filterName,
            'sort'      => $sort,
            'order'     => $order,
            'page'      => $page,
            'limit'     => $limit
        ];

        $blogs = $this->blog->filterBlog($dataFilter);
        $blog_total = $blogs->total();
        $data['blogs'] = $blogs;
        $url = $this->_getUrlFilter([
            'name',
            'page'
        ]);


        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_name'] = qs_url('/admin/blogs/index', array_merge($url, ['sort' => 'name']));
        $data['sort_view'] = qs_url('/admin/blogs/index', array_merge($url, ['sort' => 'view']));
        $data['sort_default'] = qs_url('/admin/blogs/index', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'name',
            'sort',
            'order',
        ]);

        $data['sort'] = $sort;
        $data['order'] = $order;

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'name',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url('/admin/blogs/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.blog.inc.list_blog', $data)->render();
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
            $data['inc_list'] = view('admin.blog.inc.list_blog', $data);
            return view('admin.blog.index', $data);
        }
    }

    public function create(Request $request)
    {
        $blogCategories = $this->blogCategory->get(['id', 'name']);
        return view('admin.blog.create', compact('blogCategories'));
    }

    public function store(Request $request)
    {
        $data = $this->getData($request);

        try {
            $isCreated = true;
            $dataInsert = [
                'name'        => $data['name'],
                'slug'        => $data['slug'],
                'title'       => $data['title'],
                'content'     => $data['content'],
                'category_id' => $data['category_id'],
                'user_id'     => auth()->guard('admin')->user()->id,
            ];

            if ($request->hasFile('featured_img')) {
                $data = $this->storageTraitUploadResize(
                    $request->featured_img,
                    $dataInsert['name']['vn'],
                    config('custom.folder_blog'),
                    auth()->guard('admin')->user()->id,
                    $size = [
                        'width'  => config('custom.blog_img_w'),
                        'height' => config('custom.blog_img_h')
                    ],
                );

                $dataInsert['featured_img'] = $data['file_path'];
            }

           $this->blog->create($dataInsert);

        } catch (\Exception $e) {
            $isCreated = false;
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'create', __('blog'));

        if (!$isCreated) {
            $message = $this->getMessage('error', 'create', __('blog'));

            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('blogs.index')
            ->with('message', $message)
            ->with('type', __('type_success'));

    }

    public function edit(Request $request, $id)
    {
        $blog = $this->blog->find($id);
        $blogCategories = $this->blogCategory->get(['id', 'name']);

        return view('admin.blog.edit', compact('blog', 'blogCategories'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->getData($request);
        $blog = $this->blog->find($id);
        if ($blog->user_id !== auth()->guard('admin')->user()->id) {
            return abort('401');
        }

        try {
            $dataUpdate = [
                'name'        => $data['name'],
                'slug'        => $data['slug'],
                'title'       => $data['title'],
                'content'     => $data['content'],
                'category_id' => $data['category_id'],
            ];


            if ($request->hasFile('featured_img')) {
                $data = $this->storageTraitUploadResize(
                    $request->featured_img,
                    $dataUpdate['name']['vn'],
                    config('custom.folder_blog'),
                    auth()->guard('admin')->user()->id,
                    $size = [
                        'width'  => config('custom.blog_img_w'),
                        'height' => config('custom.blog_img_h')
                    ],
                );

                $dataUpdate['featured_img'] = $data['file_path'];
            }

            $isUpdate = $blog->update($dataUpdate);

        } catch (\Exception $e) {
            $isUpdate = false;
            Log::error('message: ' . $e->getMessage() . '--Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'update', __('blog'));

        if (!$isUpdate) {
            $message = $this->getMessage('error', 'update', __('blog'));

            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('blogs.index')
            ->with('message', $message)
            ->with('type', __('type_info'));
    }

    public function destroy(Request $request, $id)
    {
        try {
            $blog = $this->blog->find($id);
            $isDelete = $blog->delete();

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete', __('blog'));

        if (!$isDelete) {
            $message = $this->getMessage('error', 'delete', __('blog'));

            return response()->json([
                'success' => false,
                'data'    => [
                    'type'    => 'error',
                    'message' => $message,
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'type'    => __('type_info'),
                'message' => $message,
            ]
        ]);

    }

    private function getData(Request $request)
    {
        $data = [];
        $input = $request->only([
            'name_vn',
            'name_en',
            'category_id',
            'title_vn',
            'title_en',
            'content_vn',
            'content_en'
        ]);
        $data['category_id'] = $input['category_id'];

        if (isset($input['name_vn'])
            && isset($input['title_vn'])
            && isset($input['content_vn'])) {

            $data['name']['vn'] = $input['name_vn'];
            $data['slug']['vn'] = Str::slug($input['name_vn']);
            $data['title']['vn'] = $input['title_vn'];
            $data['content']['vn'] = $input['content_vn'];
        }

        if (isset($input['name_en'])
            && isset($input['title_en'])
            && isset($input['content_en'])) {
            $data['name']['en'] = $input['name_en'];
            $data['slug']['en'] = Str::slug($input['name_en']);
            $data['title']['en'] = $input['title_en'];
            $data['content']['en'] = $input['content_en'];
        }

        return $data;
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
