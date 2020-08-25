<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Product;
use App\Constant;
use Carbon\Carbon;
use App\Productconfig;
use App\Supermarket;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Validator;

class ProductController extends CategoryController
{

    public function productlist(Request $request) {


        //return $request;
        if(Auth::check()) { $userid = Auth::user()->id; }
        $productdata = array();
        $lastcategories = $this->subsubcategorylist($request);
        $sid = $request->sid;
        $cid = $request->cid;
        $scid = $request->scid;
        if(isset($request->childnode)) {
            if($request->childnode > 0) {
                $lcid = $request->childnode;
            }
            else {
                $lcid = $lastcategories['categories'][0]['id'];
            } 
        } else {
                $lcid = $lastcategories['categories'][0]['id'];
        }
        //Filter Options
        $field = 'created_at'; $order = 'desc';$limit = 100;
        if (isset($request->sortcategory)){
            $sort = $request->sortcategory;
            switch ($sort) {
                case 1:
                    $field = 'name';
                    $order = 'asc';
                    break;
                case 2:
                    $field = 'name';
                    $order = 'desc';
                    break;
            }
        }
        if (isset($request->productlimit)){
            $limit = $request->productlimit;
        }
        //Filter Options

        //search function 
        $enabled_products = Productconfig::where('is_enabled', '=', 1)
            ->select('product_id')->get()->toArray();
        if (isset($request->search_text)){
            $productlist = Product::with('supermarket','productconfig')
            ->where(['supermarket_id' => $sid])
            ->Where('products.name','LIKE','%'.$request->search_text.'%')
            ->whereIn('products.id', $enabled_products)
            ->orderBy($field,$order)->limit($limit)->get(); 
        }
        else {
            $productlist = Product::with('supermarket','productconfig')
            ->where(['supermarket_id' => $sid, 'category_id' => $lcid])
            ->whereIn('products.id', $enabled_products)
            ->orderBy($field,$order)->limit($limit)->get();
        }
        
        //return $productlist;  
        if(Auth::check()) {
            foreach($productlist as $productk =>$productv) {
                foreach($productv['productconfig'] as $pck => $pcv) {
                    $productlist[$productk]['productconfig'][$pck]['wishlist_item'] = '0';
                    $productlist[$productk]['productconfig'][$pck]['weeklylist_item'] = '0';
                    $wishlistdata = DB::select("SELECT * FROM wishlists WHERE user_id = '".$userid."' AND productconfig_id = '".$pcv['id']."'");
                    $weeklylistdata = DB::select("SELECT * FROM weeklylists WHERE user_id = '".$userid."' AND productconfig_id = '".$pcv['id']."'");
                    if(!empty($wishlistdata)) {
                    $productlist[$productk]['productconfig'][$pck]['wishlist_item'] = '1';
                    }            
                    if(!empty($weeklylistdata)) {
                        $productlist[$productk]['productconfig'][$pck]['weeklylist_item'] = '1';
                    } 
                    //echo $productlist[$productk]['productconfig'][$pck]['is_approved']; exit;
                    // if($productlist[$productk]['productconfig'][$pck]['is_approved'] == '0') {
                    //     $productlist[$productk]['productconfig'][$pck] = array();
                    // }            
                }
            }
        }
        
        $path = Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data');
        $productdata = array('childcategories' => $lastcategories, 
        'productlist' => $productlist, "product_image_path" => $path, 'marketid' => $sid, 'cid' => $cid, 'scid' => $scid );
    //echo '<pre/>'; print_r($productdata); exit;        
        return view('products.index', ['productdata' => $productdata]);
    }

    public function productview(Request $request) {
        if(Auth::check()) { $userid = Auth::user()->id; }
        $product = array();
        $sid = $request->sid;
        $cid = $request->cid;
        $scid = $request->scid;
        $pid =  $request->pid;

        $productobj = Product::find($pid);
        $product   = Product::find($pid)->toArray();
        $supermarket = $productobj->supermarket()->where(['id' => $product['supermarket_id']])->get()->toArray();

        if(isset($request->units)) {
            if($request->units > 0) {
                $pcid = $request->units;
                $variant = $productobj->productconfig()->where(['id' => $pcid])->get()->toArray();
            } else {
                $variant[0] = $productobj->productconfig()->where(['product_id' => $pid])->first()->toArray();
            }
        } else {
            $variant[0] = $productobj->productconfig()->where(['product_id' => $pid])->first()->toArray();
        }

        $productconfig = $productobj->productconfig()->where(['product_id' => $product['id']])->get()->toArray();

        //  config wishlist and weeklylist ststaus
        if(Auth::check()) {
            foreach($productconfig as $pck => $pcv) {
                $productconfig[$pck]['wishlist_item'] = '0';
                $productconfig[$pck]['weeklylist_item'] = '0';            
                $wishlistdata = DB::select("SELECT * FROM wishlists WHERE user_id = '".$userid."' AND productconfig_id = '".$pcv['id']."'");
                $weeklylistdata = DB::select("SELECT * FROM weeklylists WHERE user_id = '".$userid."' AND productconfig_id = '".$pcv['id']."'");
                if(!empty($wishlistdata)) {
                    $productconfig[$pck]['wishlist_item'] = '1';
                }          
                if(!empty($weeklylistdata)) {
                    $productconfig[$pck]['weeklylist_item'] = '1';
                }            
            }
        }

        // variant wishlist and weeklylist status
        if(Auth::check()) {
            $variant[0]['wishlist_item'] = '0';
            $variant[0]['weeklylist_item'] = '0';            
            $wishlistdata = DB::select("SELECT * FROM wishlists WHERE user_id = '".$userid."' AND productconfig_id = '".$variant[0]['id']."'");
            $weeklylistdata = DB::select("SELECT * FROM weeklylists WHERE user_id = '".$userid."' AND productconfig_id = '".$variant[0]['id']."'");
            if(!empty($wishlistdata)) {
                $variant[0]['wishlist_item'] = '1';
            }          
            if(!empty($weeklylistdata)) {
                $variant[0]['weeklylist_item'] = '1';
            }
        }
 
         //Recommended Products// 
         $rp = new Product;
         $recommendedProducts = $rp->findSimilarProducts($productobj->category_id,$pid);         
         if(Auth::check()) {
            foreach($recommendedProducts as $pck => $pcv) {                
                $recommendedProducts[$pck]->wishlist_item = '0';
                $recommendedProducts[$pck]->weeklylist_item = '0';            
                $wishlistdata = DB::select("SELECT * FROM wishlists WHERE user_id = '".$userid."' AND productconfig_id = '".$pcv->productconfig_id."'");
                $weeklylistdata = DB::select("SELECT * FROM weeklylists WHERE user_id = '".$userid."' AND productconfig_id = '".$pcv->productconfig_id."'");
                if(!empty($wishlistdata)) {
                    $recommendedProducts[$pck]->wishlist_item = '1';
                }          
                if(!empty($weeklylistdata)) {
                    $recommendedProducts[$pck]->weeklylist_item = '1';
                }            
            }
        }        
        //return $recommendedProducts;
          //Recommended Products//           
        $path = Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data');
        $productdata = array('product' => $product,'variant' => $variant, 'productconfig' => $productconfig, 
        'supermarket' => $supermarket, "product_image_path" => $path, 'marketid' => $sid, 
        'cid' => $cid, 'scid' => $scid, 'pid' => $pid,
        'recommendedProducts' => $recommendedProducts
    
    );         
        return view('products.product', ['productdata' => $productdata]);
    } 
}
