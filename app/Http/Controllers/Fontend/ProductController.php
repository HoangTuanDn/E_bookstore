<?php

namespace App\Http\Controllers\fontend;


use App\Components\Pagination;
use App\Http\Requests\ReviewRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    private $product;
    private $category;
    private $tag;

    /**
     * ProductController constructor.
     * @param $product
     * @param $category
     * @param $tag
     */
    public function __construct(Product $product, Category $category, Tag $tag)
    {
        $this->product = $product;
        $this->category = $category;
        $this->tag = $tag;
    }


    public function index(Request $request)
    {
        return $this->_getList($request);
    }

    public function show(Request $request, $language, $slug)
    {
        $product = $this->product->where('slug', $slug)->first();
        if (!$product){
            return view('fontend.error_404');
        }
        $customerReviews = $product->customerReviews;
        $productTags = $product->tags;
        $collectionRelatedProducts = [];
        $categoryTranslate =  [
            'Danh nhân' => 'Biography',
            'Kinh doanh' => 'Business',
            'Sách dạy nấu ăn' => 'Cookbooks',
            'Sức khỏe & Thể hình' => 'Health & Fitness',
            'Lịch sử' => 'History',
            'Huyền bí' => 'Mystery',
            'Ma thuật' => 'Magic',
            'Tình cảm' => 'Romance',
            'Viễn tưởng' => 'Fiction',
            'Hài hước' => 'Humor',
            'Harry Potter' => 'Harry Potter',
            'Khoa học' => 'Science',
            'Cảm hứng' => 'Inspiration',
            'Phiêu lưu' => 'Adventure',
            'Bí ẩn' => 'Mystery'
        ];

        foreach ($productTags as $tag) {
            $collectionRelatedProducts [] = $tag->products;
        }

        $relatedProducts = [];
        foreach ($collectionRelatedProducts as $collectionRelatedProduct) {
            $relatedProducts = array_merge($relatedProducts, $collectionRelatedProduct->all());
        }

        $textCategory = [];
        foreach ($product->categories as $category) {
            if (app()->getLocale() === 'en') {
                $textCategory [] = '<a href="' . route('home.shop', ['language'=> app()->getLocale(),'category' => $category->slug]) . '">' . $categoryTranslate[$category->name] . '</a>';
            }else{
                $textCategory [] = '<a href="' . route('home.shop', ['language'=> app()->getLocale(),'category' => $category->slug]) . '">' . $category->name . '</a>';
            }
        }
        $textCategory = implode(',  ', $textCategory);

        $upsellProducts = $this->product->upsellProducts();

        $categories = $this->category->get(['id', 'name', 'slug']);
        $tags = $this->tag->get(['id', 'name', 'slug']);

        $inc_review = view('fontend.product.inc.review', compact('customerReviews'));
        $inc_list = view('fontend.product.inc.detail', compact('inc_review', 'product', 'textCategory'));

        return view('fontend.product.single_product', compact('inc_list', 'relatedProducts', 'upsellProducts', 'categories', 'tags', 'categoryTranslate'));
    }

    public function review(ReviewRequest $request,$language ,$slug)
    {
        $customer = auth()->guard('customer')->user();
        if (!$customer) {
            $json = [
                'success' => false,
                'errors'  => [
                    [__('customer_error')]
                ],
                'code'    => Response::HTTP_UNAUTHORIZED
            ];

            return response()->json($json, $json['code']);
        }

        $dataReview = $request->only('id', 'quality_rate', 'price_rate', 'nickname', 'review_content');

        $reviewProuduct = $customer->productReviews()->where('product_id', $dataReview['id'])->first();

        if ($reviewProuduct) {
            return response()->json([
                'success' => false,
                'data'    => [
                    'type'    => 'warning',
                    'message' => __('review_warning'),
                ]
            ]);
        }

        $product = $this->product->find($dataReview['id']);

        if (!$product) {
            $json = [
                'success' => false,
                'errors'  => [
                    [__('product_error')]
                ],
                'code'    => Response::HTTP_NOT_FOUND
            ];

            return response()->json($json, $json['code']);
        }
        try {
            $customer->productReviews()->attach($product->id, [
                'nickname'     => $dataReview['nickname'],
                'quality_rate' => $dataReview['quality_rate'],
                'price_rate'   => $dataReview['price_rate'],
                'content'      => $dataReview['review_content']
            ]);


        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isCreate = false;
        }

        if (isset($isCreate)) {
            return response()->json([
                'success' => false,
                'data'    => [
                    'type'    => 'error',
                    'message' => __('error_message'),
                ]
            ]);
        }

        $customerReviews = $product->customerReviews;
        $inc_review = view('fontend.product.inc.review', compact('customerReviews'))->render();

        return response()->json([
            'success' => true,
            'data'    => [
                'htmlView' => $inc_review
            ]
        ]);
    }

    private function _getList(Request $request)
    {
        $data = [];

        $filterName = $request->query('name');
        $filterCategory = $request->query('category');
        $filterTag = $request->query('tag');
        $filter_price_min = $request->query('price_min');
        $filter_price_max = $request->query('price_max');
        $sort = $request->query('sort', 'default');
        $order = $request->query('order', 'desc');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', config('custom.limit'));
        $categoryTranslate =  [
            'Danh nhân' => 'Biography',
            'Kinh doanh' => 'Business',
            'Sách dạy nấu ăn' => 'Cookbooks',
            'Sức khỏe & Thể hình' => 'Health & Fitness',
            'Lịch sử' => 'History',
            'Huyền bí' => 'Mystery',
            'Ma thuật' => 'Magic',
            'Tình cảm' => 'Romance',
            'Viễn tưởng' => 'Fiction',
            'Hài hước' => 'Humor',
            'Harry Potter' => 'Harry Potter',
            'Khoa học' => 'Science',
            'Cảm hứng' => 'Inspiration',
            'Phiêu lưu' => 'Adventure',
            'Bí ẩn' => 'Mystery'
        ];

        $data['products'] = [];

        $dataFilter = [
            'name'      => $filterName,
            'category'  => $filterCategory,
            'tag'       => $filterTag,
            'price_min' => $filter_price_min ? $filter_price_min . '000' : '',
            'price_max' => $filter_price_max ? $filter_price_max . '000' : '',
            'sort'      => $sort,
            'order'     => $order,
            'page'      => $page,
            'limit'     => $limit
        ];

        $dbResults = $this->product->filterProduct($dataFilter);
        $product_total = $dbResults->total();

        foreach ($dbResults as $product) {
            $data['products'] [] = [
                'id'            => $product->id,
                'slug'          => $product->slug,
                'name'          => $product->name,
                'title'         => $product->title,
                'author'        => $product->author,
                'price'         => $product->price,
                'featured_img'  => $product->featured_img,
                'discount'      => $product->discount,
                'quantity'      => $product->quantity,
                'quantity_sold' => $product->quantity_sold,
                'type'          => $product->type,
                'review_count'  => $product->customerReviews()->count(),
                'publish_date'  => $product->publish_date,
                'created_at'    => $product->created_at,
                'rate'          => $product->getRate($product->id),
            ];
        }

        $url = $this->_getUrlFilter([
            'name',
            'category',
            'tag',
            'price_min',
            'price_max',
            'page'
        ]);


        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_name'] = qs_url(app()->getLocale().'/home/shop', array_merge($url, ['sort' => 'name']));
        $data['sort_price'] = qs_url(app()->getLocale().'/home/shop', array_merge($url, ['sort' => 'price']));
        $data['sort_date'] = qs_url(app()->getLocale().'/home/shop', array_merge($url, ['sort' => 'date']));
        $data['sort_default'] = qs_url(app()->getLocale().'/home/shop', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'name',
            'category',
            'tag',
            'price_min',
            'price_max',
            'sort',
            'order',
        ]);

        $pagination = new Pagination();
        $pagination->total = $product_total;
        $pagination->limit = $limit;
        $pagination->page = $page;
        $pagination->url = qs_url(app()->getLocale().'/home/shop', array_merge($url, ['page' => '{page}']));
        $data['pagination'] = $pagination->render();
        $data['result'] = $pagination->getResult(__('text_pagination'));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['categories'] = $this->category->get(['id', 'name', 'slug']);
        $data['tags'] = $this->tag->get(['id', 'name', 'slug']);

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'name',
                'category',
                'tag',
                'price_min',
                'price_max',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url(app()->getLocale().'/home/shop', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('fontend.shop.inc.list_product', $data)->render();
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
            $data['inc_list'] = view('fontend.shop.inc.list_product', $data);
            $data['categoryTranslate'] = $categoryTranslate;
            return view('fontend.shop.shop', $data);
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
