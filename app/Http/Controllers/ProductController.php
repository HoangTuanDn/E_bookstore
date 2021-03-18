<?php

namespace App\Http\Controllers;

use App\Components\Message;
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

    public function index()
    {
        $products = $this->product->paginate(5);
        return view('admin.product.index', compact('products'));
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
                'name'    => $request->name,
                'slug'    => Str::slug($request->name),
                'price'   => $request->price,
                'content' => $request->contents,
                'user_id' => auth()->guard('admin')->user()->id,
            ];

            if ($request->hasFile('featured_img')) {

                $data = $this->storageTraitUpload(
                    $request->featured_img,
                    $dataInsert['name'],
                    config('custom.folder_store'),
                    auth()->guard('admin')->user()->id
                );

                $dataInsert['featured_img'] = $data['file_path'];
                $dataInsert['image_name'] = $data['file_name'];

            }

            $product = $this->product->create($dataInsert);

            if ($request->hasFile('image_detail')) {
                foreach ($request->image_detail as $file) {
                    $imageDataDetail = $this->storageTraitUpload(
                        $file,
                        $dataInsert['name'],
                        config('custom.folder_store'),
                        auth()->guard('admin')->user()->id
                    );

                    $product->images()->create([
                        'image'      => $imageDataDetail['file_name'],
                        'image_path' => $imageDataDetail['file_path']
                    ]);
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

                $product->tags()->attach($tagIds);
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
                'name'    => $request->name,
                'slug'    => Str::slug($request->name),
                'price'   => $request->price,
                'content' => $request->contents,
                'user_id' => auth()->guard('admin')->user()->id,
            ];

            if ($request->hasFile('featured_img')) {

                $data = $this->storageTraitUpload(
                    $request->featured_img,
                    $dataUpdate['name'],
                    config('custom.folder_store'),
                    auth()->guard('admin')->user()->id
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
                        auth()->guard('admin')->user()->id
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
           // $isUpdate = false;
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

    public function destroy(Request $request, $id){
        try {
            $isDelete = $this->product->find($id)->delete();

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

    private function getMessage($type, $action = '', $name = '', $text = '')
    {
        $message = new Message($type, $text);
        return $message->getText($action, $name);
    }

}
