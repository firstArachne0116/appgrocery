<?php

namespace App\Http\Controllers;

use DB,Auth;
use App\User;
use App\Vendor;
use App\Category;
use App\Constant;
use App\Supermarket;
use App\Product;
use App\Productconfig;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use App\Http\Traits\ImageUploadTrait;
use App\Http\Traits\ValidationTrait;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ImageUploadTrait;
    use ValidationTrait;
    /**
     * Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(User::checkRole('vendor')){
            $vendor = Vendor::getSupermarketId();
            $supermarket = Supermarket::find($vendor[0]->supermarket_id);
            $categories =  $supermarket->categories()->select('categories.id','name')->where('parentid',0)->get();
            return view('categories.index',compact('categories','supermarket'));
            
        }
        $categories = Category::select('id','name')->where('parentid',0)->get();
        //$categories = Category::select('id','name')->where('parentid',1)->exists();
        //dd($categories);
        return view('categories.index',compact('categories'));

        
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $maincategories = Category::select('name','id')->where('parentid',0)->get();
        //$subcategories = Category::select('name','id')->where('parentid','!=',0)->get();  
        //$c = new Category;
        $sm = Supermarket::getValidSupermarkets();
        //$categories= $c->getCategoryForParentId();
        return view('categories.create',compact('sm','maincategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
    {
        $this->validate($request,[
            'category_name' => 'string|required',
            'name_arabic' => 'string|required',
        ]);
        if ($request->main_category_id === "-1" && $request->sub_category_id === "-1") {
            $this->validate($request,[
                'filename' => 'required',
                'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'category_name' => 'unique:categories,name',
                'name_arabic' => 'unique:categories,name_arabic'
            ]);
           $this->storecategory($request,0); // Create a Main Category
       } else if ($request->main_category_id != -1 && $request->sub_category_id === "-1"){
        $this->validate($request,[
            'filename' => 'required',
            'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
            $this->storecategory($request,$request->main_category_id); //Create a sub category
       } else if ($request->main_category_id != -1 && $request->sub_category_id != -1) {
            $this->storecategory($request,$request->sub_category_id); //Create a sub sub category
       }
       \Session::flash('success','Category was added!');
       $maincategories = Category::select('name','id')->where('parentid',0)->get();
       return view('categories.create',compact('maincategories'));
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
    public function delete(Request $request){
        $vendor = Vendor::getSupermarketId();
        $supermarket = Supermarket::find($vendor[0]->supermarket_id);
        $supermarket->categories()->detach($request->id);
        // DB::table('productconfigs')
        // ->where('category_id',$request->id)
        // ->where('supermarket_id', $supermarket->id)     
        // ->update('is_enabled',0)->toSql();
        return redirect()->route('category.index')->with('success','Category was removed!');
    }
    public function choose(){
		$userId=Auth::user()->id;
		  $cats=[];
	     	if(User::checkRole('vendor')){
            $vendor = Vendor::getSupermarketId();
					$sid = $vendor[0]['supermarket_id'] ;
					$catdata = DB::select(DB::raw("SELECT category_id FROM category_supermarket WHERE supermarket_id = '".$sid."'"));
					foreach($catdata as $cat) {
					$cats[] = $cat->category_id;
					}
			}
        $categories = Category::select('id','name')->where('parentid',0)->get();
        return view('categories.choose',compact('categories','cats'));
    }
    public function storesupermarketcategory(Request $request){
        $vendor = Vendor::getSupermarketId();
        
        foreach($request->available_options as $category){
            $parent_id = Category::select('parentid')->where('id',$category)->get();
            $parent = Category::find($parent_id[0]->parentid);
            //$status = $parent->supermarkets()->contains($vendor[0]['supermarket_id']);
            //return $status;
            $parent->supermarkets()->attach($vendor[0]['supermarket_id']);
            // if (!$parent->supermarkets()->exists($vendor[0]['supermarket_id'])) {
            //     $parent->supermarkets()->attach($vendor[0]['supermarket_id']);
            // }
            $sub_category = Category::find($category);
            $sub_category->supermarkets()->attach($vendor[0]['supermarket_id']);

            if(Category::where('parentid',$category)->exists()){
                $sub_sub_category = Category::where('parentid',$category)->get();
                $ssc = Category::find($sub_sub_category[0]->id);
                $ssc->supermarkets()->attach($vendor[0]['supermarket_id']);
            }
        }
        return redirect()->route('category.index')->with('success', 'Your Categories were added!');
    }

    public function storecategory($request,$id){
        $category = new Category;
       
        $category->name = $request->category_name;
        $category->name_arabic = $request->name_arabic;
        $category->parentid = $id;
        if($request->hasfile('filename')){  
            $path = Constant::where('constant_type','CATEGORY_IMAGE_PATH')->value('data');
            $data = $this->uploadImage($request->file('filename'),$path);
            $category->image_path = json_encode($data); 
        }
        else{
            $category->image_path = '404';
        }
        $category->save();
        //$category->supermarkets()->attach($request->input('supermarket_id'));
        
    }

    public function marketcats($request) {
        $validator = Validator::make($request->all(), [
            'sid' => 'required|min:1|int|exists:supermarkets,id'
        ]);
        $mcdata=[];
        if ($validator->fails()) {
            $mcdata['errors'] = $validator->errors()->first();
            return $mcdata;
        }
        $sid = $request->sid;
		
        $catdata = DB::select(DB::raw("SELECT category_id FROM category_supermarket WHERE supermarket_id = '".$sid."'"));
        if(count($catdata )>0)  
	    {
	        foreach($catdata as $cat) {
                $mcdata['categories'][] = $cat->category_id;
            }
	    }
	    else{
		   $mcdata['errors'] ='Category not found';
	    }
        return $mcdata;
    }

    public function productlist(Request $request) {
        App::setLocale($request->header('locale'));
        $user=auth('api')->user();
        if($user){
            $userdata = $user->toArray();
        }
        $sid = $request->sid;
        $validator = Validator::make($request->all(), [
            'sid' => 'bail|required|min:1|int|exists:supermarkets,id'
        ]);

        if ($validator->fails()) {
            return $this->erroroutput($validator);
        }

        $productlist = Product::with('supermarket','productconfig')->whereRaw('id IN (select p.id from products p inner join productconfigs pc on pc.product_id=p.id where pc.status=1 and pc.is_enabled=1 and pc.is_approved=1 and pc.supermarket_id='.$sid.')')->get()->toArray(); 
		  
        foreach($productlist as $productk =>$productv) {
            foreach($productv['productconfig'] as $pck => $pcv) {  
                $unitid = Constant::find($pcv['unit_id'])->data;
                $productlist[$productk]['productconfig'][$pck]['unit_id'] = $unitid; 
                $productlist[$productk]['productconfig'][$pck]['variant_name'] =  $productv['name'];
                $productlist[$productk]['productconfig'][$pck]['variant_name_arabic'] =  $productv['name_arabic'];              
                $productlist[$productk]['productconfig'][$pck]['wishlist_item'] = '0';
                $productlist[$productk]['productconfig'][$pck]['weeklylist_item'] = '0';
                if($user){
                    $wishlistdata = DB::select("SELECT * FROM wishlists WHERE user_id = '".$userdata['id']."' AND productconfig_id = '".$pcv['id']."'");
                    $weeklylistdata = DB::select("SELECT * FROM weeklylists WHERE user_id = '".$userdata['id']."' AND productconfig_id = '".$pcv['id']."'");
                    if(!empty($wishlistdata)) {
                        $productlist[$productk]['productconfig'][$pck]['wishlist_item'] = '1';
                    }            
                    if(!empty($weeklylistdata)) {
                        $productlist[$productk]['productconfig'][$pck]['weeklylist_item'] = '1';
                    }  
                }
                       
            }
        }        
        $path = Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data');        
        $redata = array('productList' => $productlist, "product_image_path" => $path);
        return $redata;
    }

    public function categorylist(Request $request) {
        App::setLocale($request->header('locale'));
        $mcdata = $this->marketcats($request);
        $sid    = $request->sid;
        if($mcdata) {
            if(isset($mcdata['errors'])) {
                $msg = $mcdata['errors'];
                $redata = array('categories'=>array(), 'products' => array());
                $data = array(
                    'message' => $msg,
                    'data' => $redata,
                    'status' => 401
                );
                return json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
            } else if(isset($mcdata['categories'])) {
                    $categories = $mcdata['categories'];
                    $parentcategories = category::whereIn('id', $categories)->where('parentid', '0')->get()->toArray();
                    $path = Constant::where('constant_type','CATEGORY_IMAGE_PATH')->value('data');                    
                    $message = trans("lang.success");
                    $productlist = $this->productlist($request);
                    $redata = array('categories' => $parentcategories, 'category_image_path' => $path, 'marketid' => $sid);
                    $redata = array_merge($redata, $productlist);
                    return $this->customerrormessage($message,$redata,200);
            } else { }
        }

    }

    
    public function subProductlist(Request $request, $sid, $categoryIds) {
        App::setLocale($request->header('locale'));
        $user=auth('api')->user();
        if($user){
            $userdata = $user->toArray();
        }

        $productlist = Product::with('supermarket','productconfig')->whereRaw('id IN (select p.id from products p inner join productconfigs pc on pc.product_id=p.id where pc.status=1 and pc.is_enabled=1 and pc.is_approved=1 and pc.supermarket_id='.$sid.' and pc.category_id IN ('.join(", ", $categoryIds).'))')->get()->toArray(); 
		  
        foreach($productlist as $productk =>$productv) {
            foreach($productv['productconfig'] as $pck => $pcv) {  
                $unitid = Constant::find($pcv['unit_id'])->data;
                $productlist[$productk]['productconfig'][$pck]['unit_id'] = $unitid; 
                $productlist[$productk]['productconfig'][$pck]['variant_name'] =  $productv['name'];
                $productlist[$productk]['productconfig'][$pck]['variant_name_arabic'] =  $productv['name_arabic'];              
                $productlist[$productk]['productconfig'][$pck]['wishlist_item'] = '0';
                $productlist[$productk]['productconfig'][$pck]['weeklylist_item'] = '0';
                if($user){
                    $wishlistdata = DB::select("SELECT * FROM wishlists WHERE user_id = '".$userdata['id']."' AND productconfig_id = '".$pcv['id']."'");
                    $weeklylistdata = DB::select("SELECT * FROM weeklylists WHERE user_id = '".$userdata['id']."' AND productconfig_id = '".$pcv['id']."'");
                    if(!empty($wishlistdata)) {
                        $productlist[$productk]['productconfig'][$pck]['wishlist_item'] = '1';
                    }            
                    if(!empty($weeklylistdata)) {
                        $productlist[$productk]['productconfig'][$pck]['weeklylist_item'] = '1';
                    }  
                }
                       
            }
        }        
        return $productlist;
    }

    public function subcategorylist(Request $request) {
        App::setLocale($request->header('locale'));
        $mcdata = $this->marketcats($request);
        if($mcdata) {
            if(isset($mcdata['errors'])) {
                $msg = $mcdata['errors'];
                $redata = new \stdClass();
                $data = array(
                    'message' => $msg,
                    'data' => new \stdClass(),
                    'status' => 401
                );
                return json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
            } else if(isset($mcdata['categories'])) {
                $categories = $mcdata['categories'];
                $cid = $request->cid;
                $sid = $request->sid;
                $validator = Validator::make($request->all(), [
                    'cid' => 'required|min:1|int|exists:categories,parentid'
                ]);
    
                if ($validator->fails()) {
                    $msg = $validator->errors()->first();
                    $redata = array();
                    $data = array(
                        'message' => $msg,
                        'data' => new \stdClass(),
                        'status' => 401
                    );
                    return json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
                }
                $newsubcategories = array();
                $subcategories = Category::where('parentid', $cid)->get()->toArray();
                $productCategoryIds = [];
                foreach($subcategories as $subcatk =>$subcatv) {
                    $productCategories = Category::where('parentid', $subcatv['id'])->get();
                    if($productCategories->count() == 0) {
                        $prcount = Productconfig::where(['category_id' => $subcatv['id'], 'supermarket_id' => $sid])->get()->count();
                        if($prcount > '0') {
                            $newsubcategories[] = $subcatv;
                            $productCategoryIds[] = $subcatv['id'];
                        }
                    } else {
                        $newsubcategories[] = $subcatv;
                        foreach($productCategories as $spCat) {
                            $productCategoryIds[] = $spCat['id'];
                        }
                    }
                }
                $productlist = $this->subProductlist($request, $sid, $productCategoryIds);
                $path = Constant::where('constant_type','CATEGORY_IMAGE_PATH')->value('data');
                $message = trans("lang.success");
                $redata = array('subcategories' => $newsubcategories, 'category_image_path' => $path, 'marketid' => $sid, 'productlist' => $productlist);
                return $this->customerrormessage($message,$redata,200);
            } else { }
        }
    }
}
