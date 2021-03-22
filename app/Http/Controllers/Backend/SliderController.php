<?php

namespace App\Http\Controllers\Backend;

use App\Components\Message;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
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
        $this->slider = $slider  ;
    }

    public function index()
    {
        $sliders = $this->slider->paginate(config('custom.limit'));
        return view('admin.slider.index', compact('sliders'));
    }

    public function create(Request $request)
    {
        return view('admin.slider.create');
    }

    public function store(SliderRequest $request)
    {
      //$request->validated();

        try {
            $isCreated = true;

            DB::beginTransaction();


            $dataInsert = [
                'name' => $request->name,
                'description'=> $request->description,

            ];

            if ($request->hasFile('image')){

                $imageData = $this->storageTraitUpload(
                    $request->image,
                    $dataInsert['name'],
                    config('custom.folder_slider'),
                    auth()->guard('admin')->user()->id
                );

                $dataInsert['image_path'] = $imageData['file_path'];
                $dataInsert['image'] = $imageData['file_name'];
            }

            $this->slider->create($dataInsert);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            $isCreated = false;
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
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
        try {
            DB::beginTransaction();

            $dataUpdate = [
                'name' => $request->name,
                'description'=> $request->description,

            ];

            if ($request->hasFile('image')){

                $imageData = $this->storageTraitUpload(
                    $request->image,
                    $dataUpdate['name'],
                    config('custom.folder_slider'),
                    auth()->guard('admin')->user()->id
                );

                $dataUpdate['image_path'] = $imageData['file_path'];
                $dataUpdate['image'] = $imageData['file_name'];
            }

            $isUpdate = $this->slider->find($id)->update($dataUpdate);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            $isUpdate = false;
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
            ->with('type', __('type_success'));


    }

    public function destroy(Request $request, $id){

        try {
            $isDelete = $this->slider->find($id)->delete();

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isDelete = false;
        }

        $message = $this->getMessage('success', 'delete',  __('slider'));

        if (!$isDelete){
            $message = $this->getMessage('error', 'delete',  __('slider'));

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


}
