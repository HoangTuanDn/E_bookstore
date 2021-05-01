<?php

namespace App\Http\Controllers\Backend;

use App\Components\Message;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class SliderController extends Controller
{
    private $slider;
    use StorageImageTrait;

    /**
     * SliderController constructor.
     */
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function index(Request $request)
    {
       /* $sliders = $this->slider->paginate(config('custom.limit'));
        return view('admin.slider.index', compact('sliders'));
        */
        $data = [];
        $filterName = $request->query('name');
        $sort = $request->query('sort', 'default');
        $order = $request->query('order', 'desc');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', config('custom.limit'));

        $dataFilter = [
            'name'  => $filterName,
            'sort'  => $sort,
            'order' => $order,
            'page'  => $page,
            'limit' => $limit
        ];

        $sliders = $this->slider->filterSlider($dataFilter);
        $slider_total = $sliders->total();

        if (utf8_strtolower($order) == 'asc') {
            $url['order'] = 'desc';
        } else {
            $url['order'] = 'asc';
        }

        $data['sort_name'] = qs_url('/admin/sliders/index', array_merge($url, ['sort' => 'name']));
        $data['sort_default'] = qs_url('/admin/sliders/index', array_merge($url, ['sort' => 'default']));

        $url = $this->_getUrlFilter([
            'name',
            'sort',
            'order',
        ]);


        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['sliders'] = $sliders;

        if ($request->ajax()) {
            $url = $this->_getUrlFilter([
                'name',
                'sort',
                'order',
                'page'
            ]);

            $url = qs_url('/admin/sliders/index', $url);
            $url = urldecode(hed($url));
            $url = str_replace(' ', '+', $url);

            try {
                $htmlContent = view('admin.slider.inc.list_slider', $data)->render();
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
            $data['inc_list'] = view('admin.slider.inc.list_slider', $data);
            return view('admin.slider.index', $data);
        }
    }

    public function create(Request $request)
    {
        return view('admin.slider.create');
    }

    public function store(SliderRequest $request)
    {
        $request->validated();
        $image = ['3', '4', '5', '6', '8', '9'];

        try {
            $isCreated = true;
            $dataInsert = [
                'name'             => $request->name,
                'description'      => $request->description,
                'background_image' => in_array($request->bgImage, $image) ? $request->bgImage : ''

            ];

            if ($request->hasFile('image') && !empty($dataInsert['background_image'])) {

                $imageData = $this->storageTraitUpload(
                    $request->image,
                    $dataInsert['name'],
                    config('custom.folder_slider'),
                    auth()->guard('admin')->user()->id
                );

                $ext =  $request->image->getClientOriginalExtension();
                $fileName = $request->bgImage . '.' . $ext;
                $request->file('image')->move(public_path('fontend/images/bg'), $fileName);

                $dataInsert['image_path'] = $imageData['file_path'];
                $dataInsert['image'] = $imageData['file_name'];
            }

            $this->slider->create($dataInsert);

        } catch (\Exception $e) {
            $isCreated = false;
            Log::error('message: ' . $e->getMessage() . ' Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'create', __('slider'));

        if (!$isCreated) {
            $message = $this->getMessage('error', 'create', __('slider'));

            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('sliders.index')
            ->with('message', $message)
            ->with('type', __('type_success'));

    }

    public function edit(Request $request, $id)
    {
        $slider = $this->slider->find($id);

        return view('admin.slider.edit', compact('slider'));

    }

    public function update(SliderRequest $request, $id)
    {
        $request->validated();
        $image = ['3', '4', '5', '6', '8', '9'];
        try {

            $dataUpdate = [
                'name'             => $request->name,
                'description'      => $request->description,
                'background_image' => in_array($request->bgImage, $image) ? $request->bgImage : ''
            ];

            if ($request->hasFile('image') && !empty($dataUpdate)) {

                $imageData = $this->storageTraitUpload(
                    $request->image,
                    $dataUpdate['name'],
                    config('custom.folder_slider'),
                    auth()->guard('admin')->user()->id
                );

                $ext =  $request->image->getClientOriginalExtension();
                $fileName = $request->bgImage . '.' . $ext;
                $request->file('image')->move(public_path('fontend/images/bg'), $fileName);

                $dataUpdate['image_path'] = $imageData['file_path'];
                $dataUpdate['image'] = $imageData['file_name'];
            }

            $isUpdate = $this->slider->find($id)->update($dataUpdate);

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
        }

        $message = $this->getMessage('success', 'update', __('slider'));

        if (!$isUpdate) {
            $message = $this->getMessage('error', 'update', __('slider'));

            return redirect()->back()->withErrors([
                'error' => __('error_message'),
            ]);
        }

        return redirect()->route('sliders.index')
            ->with('message', $message)
            ->with('type', __('type_info'));


    }

    public function destroy(Request $request, $id)
    {

        try {
            $isDelete = $this->slider->find($id)->delete();

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete', __('slider'));

        if (!$isDelete) {
            $message = $this->getMessage('error', 'delete', __('slider'));

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

    private function _getUrlFilter($list = [])
    {
        $url = [];

        call_user_func_array('preUrlFilter', [&$url, $list, [
            'name' => request()->query->has('name') ? urlencode(hed(request()->query('name'), ENT_QUOTES, 'UTF-8')) : '',
        ]]);

        return $url;
    }

}
