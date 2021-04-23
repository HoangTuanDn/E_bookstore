<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;


trait StorageImageTrait {

    public function storageTraitUpload($file, $imageName, $folderName, $id){
        $ext = $file->getClientOriginalExtension();
        $fileName = Str::slug($imageName).'.'. $ext;
        $filePath = $file->storeAs('public/'. $id .'/'. $folderName, $fileName);
        return [
            'file_name'=>$fileName,
            'file_path' => Storage::url($filePath)
        ];
    }

    public function storageTraitUploadResize($file, $imageName, $folderName, $id, $size){

        $ext = $file->getClientOriginalExtension();
        $dir = 'public/'.$id . '/' . $folderName;
        $originImageWidth = getimagesize($file)[0];
        $originImageHeight = getimagesize($file)[1];
        $fileName = Str::slug($imageName).'-'.$size['width'].'x'.$size['height']. '.' . $ext;
        if($originImageWidth == $size['width'] && $originImageHeight == $size['height']){
            $filePath = $file->storeAs('public/'. $id .'/'. $folderName, $fileName);
            return [
                'file_name'=>$fileName,
                'file_path' => Storage::url($filePath)
            ];
        }

        try {
            $image = Image::make($file);
            $image->resize($size['width'], $size ['height'], function ($constraint) {
                $constraint->upsize();
            });

            if (!file_exists($dir)) {
                Storage::disk('local')->makeDirectory($dir);
            }

            $dirFull = Storage::disk('local')->path($dir);

            $image->save($dirFull . '/' . $fileName);

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() .'--File'. $e->getFile() . '--Line : ' . $e->getLine());
        }

        return [
            'file_name'=>$fileName,
            'file_path' => Storage::url($dir . '/' . $fileName)
        ];
    }

}