<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Category;
use App\Constant;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    
    public function marketcats($request) {
        // $validator = Validator::make($request->all(), [
        //     'id' => 'required|min:1|int|exists:supermarkets,id'
        // ]);

        // if ($validator->fails()) {
        //     $mcdata['errors'] = $validator->errors();
        //     return $mcdata;
        // }
        $sid = $request->sid;
        $catdata = DB::select(DB::raw("SELECT category_id FROM category_supermarket WHERE supermarket_id = '".$sid."'"));
        $mcdata = array();
        foreach($catdata as $cat) {
            $mcdata['categories'][] = $cat->category_id;
        }
        return $mcdata;
    }

    public function categorylist(Request $request) {
        $mcdata = $this->marketcats($request);
        $sid    = $request->sid;
        if($mcdata) {
            if(isset($mcdata['errors'])) {
                return view('categories.shop');
            } else if(isset($mcdata['categories'])) {
                    $categories = $mcdata['categories'];
                    $parentcategories = category::whereIn('id', $categories)->where('parentid', '0')->paginate(1000)->toArray();
                    //return $parentcategories;
                    $path = Constant::where('constant_type','CATEGORY_IMAGE_PATH')->value('data');
                    return view('categories.shop', ['categories' => $parentcategories, 'category_image_path' => $path, 'marketid' => $sid]);
            } else { }
        }

    }

    public function subcategorylist(Request $request) {
        $mcdata = $this->marketcats($request);
        if($mcdata) {
            if(isset($mcdata['errors'])) {
                return view('categories.category');
            } else if(isset($mcdata['categories'])) {
                $categories = $mcdata['categories'];
                $cid = $request->cid;
                $sid = $request->sid;
                // $validator = Validator::make($request->all(), [
                //     'cid' => 'required|min:1|int|exists:categories,parentid'
                // ]);
    
                // if ($validator->fails()) {
                //     $msg = "Bad Request";
                //     $redata = array();
                //     return response()->json(["error" => $validator->errors(),"message" => $msg,"data" => $redata,"status" => 401]);
                // }
                $subcategories = Category::whereIn('id', $categories)->where('parentid', $cid)->get()->toArray();
                //return $subcategories;
                $path = Constant::where('constant_type','CATEGORY_IMAGE_PATH')->value('data');
                return view('categories.category', ['categories' => $subcategories, 'category_image_path' => $path, 'marketid' => $sid, 'cid' => $cid]);
            } else { }
        }
    }

    public function subsubcategorylist(Request $request) {
        $mcdata = $this->marketcats($request);
        if($mcdata) {
            if(isset($mcdata['errors'])) {
                
            } else if(isset($mcdata['categories'])) {
                $categories = $mcdata['categories'];
                $cid = $request->cid;
                $sid = $request->sid;
                $scid = $request->scid;
                $subcategories = Category::where('parentid', $scid)->get()->toArray();
                $path = Constant::where('constant_type','CATEGORY_IMAGE_PATH')->value('data');
                $sucattablist = array('categories' => $subcategories, 'category_image_path' => $path, 'marketid' => $sid, 'cid' => $cid, 'scid' => $scid);
                return $sucattablist;
            } else { }
        }
    }
}
