<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public function product() {
    	return $this->hasMany('App\Product');
    }

    public function productconfig() {
    	return $this->hasMany('APP\Productconfig');
    }

    public function supermarkets()
    {
        return $this->belongsToMany('App\Supermarket');
    }

    public function getCategoryForParentId($parentid=0){
        $categories = self::where('parentid',$parentid)->select('name','id','parentid')->orderBy('name')->get();
        $i=0;
    foreach ($categories as $mainCategory) {
        $category = array();
        $category['id'] = $mainCategory['id'];
        $category['name'] = $mainCategory['name'];
        $category['parent_id'] = $mainCategory['parentid'];
        $category['sub_categories'] = $this->getCategoryForParentId($category['id']);
        $categories[$i++] = $category;
        }
        return $categories;
    }

    public static function getCategoryName($id){
        return self::find($id)->value('name');
    }
}
