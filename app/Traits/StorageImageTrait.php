<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

}