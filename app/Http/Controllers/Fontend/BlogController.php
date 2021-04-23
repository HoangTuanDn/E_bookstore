<?php

namespace App\Http\Controllers\fontend;


use App\Components\Pagination;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BlogController extends Controller
{
    private $blog;
    private $blogCategory;

    /**
     * BlogController constructor.
     * @param $blog
     * @param $category
     */
    public function __construct(Blog $blog, BlogCategory $category)
    {
        $this->blog = $blog;
        $this->blogCategory = $category;
    }

    public function index(Request $request)
    {
        return $this->_getList($request);
    }

    public function show(Request $request, $language, $slug)
    {
        $blog = $this->blog->where('slug->vn', $slug)->first();

        if (app()->getLocale() === 'en') {
            $blog = $this->blog->where('slug->en', $slug)->first();
        }

        if (!$blog){
            return view('fontend.error_404');
        }

        return view('fontend.blog.blog_detail', compact('blog'));
    }

    private function _getList(Request $request)
    {
        $data = [];

        $filterName = $request->query('name');
        $filterCategory = $request->query('category');
        $filterArchives['month'] = $request->query('month') ? date('m', $request->query('month')) : '';
        $filterArchives['year'] = $request->query('year') ? date('Y', $request->query('year')) : '';

        $sort = $request->query('sort', 'default');
        $order = $request->query('order', 'desc');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', config('custom.blog_limit'));

        $data['blogs'] = [];

        $dataFilter = [
            'name'     => $filterName,
            'category' => $filterCategory,
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

        $data['category'] = $filterCategory ? $this->blogCategory->find($filterCategory) : __('all_lc');

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
