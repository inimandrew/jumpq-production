<?php

namespace App\Http\Controllers;
use Storage;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function profileImage($file_name){
        return Storage::download("public/profile_images/".$file_name,'image.jpg');
    }

    public function productImage($file_name){
        return Storage::download("public/product_images/".$file_name,'image.jpg');
    }

    public function uploadProfileImage($image){
        $path = Storage::disk('public')->putFile('profile_images',$image);
        $file_name = explode('/',$path);
        return $file_name[1];
    }

    public function uploadProductImage($image,$type){
            if(empty($image)){
                return $type.'.jpg';
            }else{
                $path = Storage::disk('public')->putFile('product_images',$image);
                $file_name = explode('/',$path);
                return $file_name[1];
            }

    }
}
