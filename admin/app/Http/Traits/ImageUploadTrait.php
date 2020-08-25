<?php
namespace App\Http\Traits;

trait ImageUploadTrait {
    public function uploadImage($file,$path){
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $fullFileName = uniqid('img_').'.'.$file->getClientOriginalExtension();
        $file->move(public_path().$path, $fullFileName); 
        $data[] = $fullFileName; 
        return $data;
    }
    public function deleteIfExists($file,$path){
        $path = public_path().$path.'/'.$file[0];
        if(file_exists($path)){
           unlink($path);
        }
    }
    public function uploadMultipleImage($file,$path){
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $fullFileName = uniqid('img_').'.'.$file->getClientOriginalExtension();
        $file->move(public_path().$path, $fullFileName); 
        return $fullFileName; 
        //return $data;
    }
}