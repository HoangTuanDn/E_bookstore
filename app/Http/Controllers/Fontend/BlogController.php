<?php

namespace App\Http\Controllers\fontend;


use App\Components\Pagination;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    private $blog;
    private $blogCategory;
    private $comment;

    /**
     * BlogController constructor.
     * @param $blog
     * @param $category
     * @param $comment
     */
    public function __construct(Blog $blog, BlogCategory $category, Comment $comment)
    {
        $this->blog = $blog;
        $this->blogCategory = $category;
        $this->comment = $comment;
    }

    public function index(Request $request)
    {
        return $this->_getList($request);
    }

    public function show(Request $request, $language, $slug)
    {

        if (app()->getLocale() === 'vn') {
            $blog = $this->blog->where('slug->vn', $slug)->first();
        }else{
            $blog = $this->blog->where('slug->en', $slug)->first();
        }

        $sessionPost = session('recent_posts');
        if (!isset($sessionPost[$blog->id])) {
            $blog->increment('view');
            $sessionPost[$blog->id] = 1;
            session()->put('recent_posts', $sessionPost);
        }
        $comments = $this->comment
            ->where('blog_id', $blog->id)
            ->where('parent_id', 0)
            ->latest()
            ->get(['id', 'comment', 'parent_id', 'blog_id', 'customer_id', 'created_at']);

        if (app()->getLocale() === 'en') {
            $blog = $this->blog->where('slug->en', $slug)->first();
        }

        if (!$blog) {
            return view('fontend.error_404');
        }
        $inc_comment = view('fontend.blog.inc.blog_comment', compact('comments', 'blog'));

        return view('fontend.blog.blog_detail', compact('blog', 'inc_comment'));
    }

    public function comment(Request $request, $languge)
    {
        $input = $request->only(['comment', 'blog_id', 'parent_id']);
        $blog = $this->blog->find($input['blog_id']);
        if (!$blog) {
            return view('fontend.error_404');
        }

        if ( auth()->guard('customer')->guest()) {
            $json = [
                'success' => false,
                'errors'  => [
                    [__('customer_error')]
                ],
                'code'    => Response::HTTP_UNAUTHORIZED
            ];

            return response()->json($json, $json['code']);
        }

        try {
            $this->comment->create([
                'blog_id'   => $input['blog_id'],
                'parent_id' => $input['parent_id'],
                'comment'   => $input['comment'],
                'customer_id' => auth()->guard('customer')->user()->id,
            ]);
        } catch (\Exception $e) {
            $isCreate = false;
            Log::error('message: ' . $e->getMessage() . '--Line : ' . $e->getLine());
        }

        if (isset($isCreate)) {
            $json = [
                'success' => false,
                'data'    => [
                    'type'    => __('type_error'),
                    'message' => __('error_message')
                ],
            ];
        } else {
            $comments = $this->comment
                ->where('blog_id', $input['blog_id'])
                ->where('parent_id', 0)
                ->latest()
                ->get(['id', 'comment', 'parent_id', 'blog_id', 'customer_id', 'created_at']);

            $inc_comment = view('fontend.blog.inc.blog_comment', compact('comments', 'blog'))->render();

            $json = [
                'success' => true,
                'data'    => [
                    'html_comment' => $inc_comment
                ],
            ];
        }

        return response()->json($json);
    }

    private function _getList(Request $request)
    {
        $data = [];
        $filterName = $request->query('name');
        $filterCategory = $request->query('category');
        $filterArchives['month'] = $request->query('month');
        $filterArchives['year'] = $request->query('year');

        $sort = $request->query('sort', 'default');
        $order = $request->query('order', 'desc');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', config('custom.blog_limit'));

        $data['blogs'] = [];
        if (app()->getLocale() === 'vn') {
            $category = $this->blogCategory->where('slug->vn', $filterCategory)->select('id', 'name')->first();
        }else{
            $category = $this->blogCategory->where('slug->en', $filterCategory)->select('id', 'name')->first();
        }

        $dataFilter = [
            'name'     => $filterName,
            'category' => $category ? $category->id : '',
            'archives' => $filterArchives,
            'sort'     => $sort,
            'order'    => $order,
            'page'     => $page,
            'limit'    => $limit
        ];

        $dbResults = $this->blog->filterBlog($dataFilter);
        $blog_total = $dbResults->total();

        foreach ($dbResults as $blog) {
            $data['blogs'] [] = [
                'id'           => $blog->id,
                'slug'         => $blog->slug,
                'name'         => $blog->name,
                'title'        => $blog->title,
                'author'       => $blog->author->name,
                'featured_img' => $blog->featured_img,
                'created_at'   => [
                    'vn' => date('d-m-Y', strtotime($blog->created_at)),
                    'en' => date('M d Y', strtotime($blog->created_at))
                ],
            ];
        }

        $url = $this->_getUrlFilter([
            'name',
            'category',
            'month',
            'year',
            'page'
        ]);


        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_view'] = qs_url(app()->getLocale() . '/home/blog', array_merge($url, ['sort' => 'view']));
        $data['sort_default'] = qs_url(app()->getLocale() . '/home/blog', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'name',
            'category',
            'month',
            'year',
            'sort',
            'order',
        ]);

        $pagination = new Pagination();
        $pagination->total = $blog_total;
        $pagination->limit = $limit;
        $pagination->page = $page;
        $pagination->url = qs_url(app()->getLocale() . '/home/blog', array_merge($url, ['page' => '{page}']));
        $data['pagination'] = $pagination->render();
        $data['result'] = $pagination->getResult(__('text_pagination'));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['categoryName'] = $category ? $category->name : __('all_lc');

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'name',
                'category',
                'month',
                'year',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url(app()->getLocale() . '/home/blog', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('fontend.blog.inc.list_blog', $data)->render();
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
            $data['inc_list'] = view('fontend.blog.inc.list_blog', $data);
            return view('fontend.blog.blog', $data);
        }
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
