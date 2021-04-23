<?php

namespace App\Http\Controllers\Backend;

use App\Components\Message;
use App\Components\Pagination;
use App\Components\Recursive;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Traits\Notifiable;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private $product;
    private $category;
    private $recursive;
    private $tag;

    use StorageImageTrait;
    use Notifiable;

    public function __construct(Product $product, Category $category, Tag $tag, Recursive $recursive)
    {
        $this->product = $product;
        $this->category = $category;
        $this->recursive = $recursive;
        $this->tag = $tag;
    }

    public function index(Request $request)
    {
        /*$products = $this->product->latest('id')->paginate(5);

        return view('admin.product.index', compact('products'));*/
        return $this->_getList($request);
    }

    public function create()
    {
        $htmlOption = $this->getHtmlOption();
        return view('admin.product.create', compact('htmlOption'));
    }

    public function store(ProductRequest $request)
    {
        $request->validated();

        try {

            DB::beginTransaction();

            $isCreated = true;

            $dataInsert = [
                'name'          => $request->name,
                'slug'          => Str::slug($request->name),
                'price'         => explode(' ', $request->price)[0],
                'author'        => $request->author,
                'discount'      => explode(' ', $request->discount)[0],
                'quantity'      => $request->quantity,
                'quantity_sold' => $request->quantity_sold,
                'publisher'     => $request->publisher,
                'publish_date'  => date('Y-m-d', strtotime($request->publish_date)),
                'page'          => $request->page,
                'type'          => $request->type,
                'title'         => $request->title,
                'dimensions'    => $request->dimensions,
                'content'       => $request->contents,
                'user_id'       => auth()->guard('admin')->user()->id,
            ];

            if ($request->hasFile('featured_img')) {

                $data = $this->storageTraitUploadResize(
                    $request->featured_img,
                    $dataInsert['name'],
                    config('custom.folder_store'),
                    auth()->guard('admin')->user()->id,
                    $size = [
                        'width'  => config('custom.image_w'),
                        'height' => config('custom.image_h')
                    ],
                );

                $dataInsert['featured_img'] = $data['file_path'];
                $dataInsert['image_name'] = $data['file_name'];

            }

            $product = $this->product->create($dataInsert);

            if ($request->hasFile('image_detail')) {
                $countImageDetail = count($request->image_detail);
                foreach ($request->image_detail as $file) {
                    $imageDataDetail = $this->storageTraitUploadResize(
                        $file,
                        $dataInsert['name'] . '-detail-' . $countImageDetail,
                        config('custom.folder_store'),
                        auth()->guard('admin')->user()->id,
                        $size = [
                            'width'  => config('custom.image_detail_w'),
                            'height' => config('custom.image_detail_h')
                        ],
                    );

                    $product->images()->create([
                        'image'      => $imageDataDetail['file_name'],
                        'image_path' => $imageDataDetail['file_path']
                    ]);

                    $countImageDetail -= 1;
                }
            }

            if ($request->has('tags')) {
                foreach ($request->tags as $tag) {
                    $tagInstance = $this->tag->firstOrCreate([
                        'name' => $tag,
                        'slug' => Str::slug($tag)
                    ]);

                    $tagIds [] = $tagInstance->id;
                }

                $product->tags()->sync($tagIds);
            }


            if ($request->has('category_id')) {
                $product->categories()->attach($request->category_id);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            $isCreated = false;
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'create', __('product'));

        if (!$isCreated) {
            $message = $this->getMessage('error', 'create', __('product'));

            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('products.index')
            ->with('message', $message)
            ->with('type', __('type_success'));

    }

    public function edit(Request $request, $id)
    {

        $product = $this->product->find($id);
        $arrID = [];
        foreach ($product->categories as $category) {
            $arrID [] = $category->pivot->category_id;
        }
        $htmlOption = $this->getHtmlMultipleOption($arrID);

        return view('admin.product.edit', compact('product', 'htmlOption'));
    }

    public function update(ProductRequest $request, $id)
    {
        $request->validated();

        try {
            DB::beginTransaction();

            $dataUpdate = [
                'name'          => $request->name,
                'slug'          => Str::slug($request->name),
                'price'         => explode(' ', $request->price)[0],
                'author'        => $request->author,
                'discount'      => explode(' ', $request->discount)[0],
                'quantity'      => $request->quantity,
                'quantity_sold' => $request->quantity_sold,
                'publisher'     => $request->publisher,
                'publish_date'  => date('Y-m-d', strtotime($request->publish_date)),
                'page'          => $request->page,
                'title'         => $request->title,
                'type'          => $request->type,
                'dimensions'    => $request->dimensions,
                'content'       => $request->contents,
                'user_id'       => auth()->guard('admin')->user()->id,
            ];


            if ($request->hasFile('featured_img')) {

                $data = $this->storageTraitUploadResize(
                    $request->featured_img,
                    $dataUpdate['name'],
                    config('custom.folder_store'),
                    auth()->guard('admin')->user()->id,
                    $size = [
                        'width'  => config('custom.image_w'),
                        'height' => config('custom.image_h')
                    ],
                );

                $dataUpdate['featured_img'] = $data['file_path'];
                $dataUpdate['image_name'] = $data['file_name'];

            }

            $isUpdate = $this->product->find($id)->update($dataUpdate);

            $product = $this->product->find($id);


            if ($request->hasFile('image_detail')) {
                $countImageDetail = count($request->image_detail);

                foreach ($request->image_detail as $file) {
                    $imageDataDetail = $this->storageTraitUpload(
                        $file,
                        $dataUpdate['name'] . '-detail-' . $countImageDetail,
                        config('custom.folder_store'),
                        auth()->guard('admin')->user()->id,
                        $size = [
                            'width'  => config('custom.image_detail_w'),
                            'height' => config('custom.image_detail_h')
                        ],
                    );
                    $product->images()->create([
                        'image'      => $imageDataDetail['file_name'],
                        'image_path' => $imageDataDetail['file_path']
                    ]);

                    $countImageDetail -= 1;
                }
            }

            if ($request->has('tags')) {
                foreach ($request->tags as $tag) {
                    $tagInstance = $this->tag->firstOrCreate([
                        'name' => $tag,
                        'slug' => Str::slug($tag)
                    ]);

                    $tagIds [] = $tagInstance->id;
                }

                $product->tags()->sync($tagIds);
            }

            if ($request->has('category_id')) {
                $product->categories()->sync($request->category_id);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            $isUpdate = false;
            Log::error('message: ' . $e->getMessage() . '--Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'update', __('product'));

        if (!$isUpdate) {
            $message = $this->getMessage('error', 'update', __('product'));

            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('products.index')
            ->with('message', $message)
            ->with('type', __('type_success'));

    }

    public function destroy(Request $request, $id)
    {
        try {
            $product = $this->product->find($id);
            $isDelete = $product->delete();
            $product->categories()->detach();
            $product->tags()->detach();


        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete', __('product'));

        if (!$isDelete) {
            $message = $this->getMessage('error', 'delete', __('product'));

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
                'type'    => 'success',
                'message' => $message,
            ]
        ]);
    }

    private function getHtmlMultipleOption($arrId)
    {
        $categories = $this->category->get(['id', 'name', 'parent_id']);
        $this->recursive->setData($categories);

        $htmlOption = $this->recursive->categoryMultipleSelectRecursive($arrId);

        return $htmlOption;
    }

    private function getHtmlOption(int $paren_id = 0)
    {
        $categories = $this->category->get(['id', 'name', 'parent_id']);
        $this->recursive->setData($categories);

        $htmlOption = $this->recursive->categoryRecursive($paren_id);

        return $htmlOption;
    }

    private function _getList(Request $request)
    {
        $data = [];
        $filterName = $request->query('name');
        $sort = $request->query('sort', 'default');
        $order = $request->query('order', 'desc');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', config('custom.limit'));

        $data['products'] = [];

        $dataFilter = [
            'name'      => $filterName,
            'sort'      => $sort,
            'order'     => $order,
            'page'      => $page,
            'limit'     => $limit
        ];

        $products = $this->product->filterProduct($dataFilter);
        $product_total = $products->total();
        $data['products'] = $products;
        $url = $this->_getUrlFilter([
            'name',
            'page'
        ]);


        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_name'] = qs_url('/admin/products/index', array_merge($url, ['sort' => 'name']));
        $data['sort_price'] = qs_url('/admin/products/index', array_merge($url, ['sort' => 'price']));
        $data['sort_date'] = qs_url('/admin/products/index', array_merge($url, ['sort' => 'date']));
        $data['sort_default'] = qs_url('/admin/products/index', array_merge($url, ['sort' => 'default']));

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

            $url = qs_url('/admin/products/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.product.inc.list_product', $data)->render();
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
            $data['inc_list'] = view('admin.product.inc.list_product', $data);
            return view('admin.product.index', $data);
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
