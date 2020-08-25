<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Vendor;
use App\Lottery;
use App\Product;
use App\Category;
use App\Constant;
use Carbon\Carbon;
use App\Supermarket;
use App\Productconfig;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use App\Http\Requests\ProductRequest;
use App\Http\Traits\ImageUploadTrait;
use App\Http\Traits\ValidationTrait;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ImageUploadTrait;
    use ValidationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct (){
    //     $this->middleware('auth');
    // }
    public function index()
    {
        $vendor = Vendor::getSupermarketId();
        $p = new Product;
        $products = $p->getProductBySupermarketIDAndVendorID($vendor[0]['supermarket_id'],Auth::user()->id);

        //return $products;
        return view('products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $supermarket = new Supermarket;
        $categories = Category::select('id','name')->where('parentid',0)->get();
        $units = Constant::where([['constant_type','PRODUCT_UNITS'],['status',1]])->get();
         if (User::checkRole('vendor'))
            {
                $vendor = Vendor::getSupermarketId();
                $p = new Product;
                $products = $p->getProductBySupermarketIDAndVendorID($vendor[0]['supermarket_id'],Auth::user()->id);
                $supermarket = Supermarket::find($vendor[0]->supermarket_id);
            $categories =  $supermarket->categories()->select('categories.id','name')->where('parentid',0)->get();
                return view('products.create',[
                    'vendor' => $vendor,
                    'products' =>$products,
                    'categories' => $categories,
                    'units' => $units ]);
            }
            else if (User::checkRole('admin'))
            {  
                $lotteries = Lottery::getValidLotteries();
                $sm = Supermarket::getValidSupermarkets();
                //return $categories;
                return view('products.create',[
                    'sm' => $sm,
                    'lotteries' => $lotteries
                    ],compact('categories','units'));
            }  

       
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        if (User::checkRole('admin')){
            $this->validate($request,[
                'supermarket_id' => 'required|integer|min:1',
                'lottery_product' => 'required|integer',
               // 'lottery_winner' => 'required|integer',
                'price' => 'required|min:1',
                'discount' => 'required|min:0|max:100',
                'capacity' => 'required|min:0|',
                'quantity' => 'integer|required|min:0|',
                'unit' => 'integer|required|min:0|',                
                'credits' => 'integer|required|min:0|',
                'product_id' => 'integer|required',
                'sku' => 'required',
            ]);
        }
        else if (User::checkRole('vendor')){
            $this->validate($request,[
                'supermarket_id' => 'required|integer|min:1',
                'price' => 'required|min:1',
                'discount' => 'required|min:0|max:100',
                'capacity' => 'required|min:0|',
                'quantity' => 'integer|required|min:0|',
                'unit' => 'integer|required|min:0|',                
                'product_id' => 'integer|required',
            ]);
        }
        
    
        //return $request;
        if ($request->input('product_id') == -1 )
       {
        $this->validate($request,[
            'name' => 'required|max:255',
            'name_arabic' => 'required|max:255',
            'description' => 'required|max:1023',
            'description_arabic' => 'required|max:1023',
            'main_category_id' => 'integer|required|',
            'sub_category_id' => 'integer|required',
            'category_id' => 'integer|required|min:0|',
        ]);
           $this->storeNewProduct($request);
       }
       else if ($request->input('product_id') != -1)
       {
            
            $product = Product::find($request->input('product_id'));
            $this->saveProductVariant($request,$product);
       }

       if (User::checkRole('vendor')){
        return redirect()->route('product.index')->with('success','Product was added!');
       }else if (User::checkRole('admin')) {
        $p =  new Product;
        $products = $p->getProductDetailsBySupermarketID($request->supermarket_id);
        $sm = Supermarket::getValidSupermarkets();
        \Session::flash('success','Products was added!');
        return view('products.list',compact('products','sm'));
       }
        
    }
        private function storeNewProduct($request){
            $product = new Product;
            $product->name =  $request->input('name');
            $product->name_arabic =  $request->input('name_arabic');
            $product->description =  $request->input('description');
            $product->description_arabic =  $request->input('description_arabic');
            $product->supermarket_id = $request->input('supermarket_id');
            $product->category_id =  $request->input('category_id');
            if(User::checkRole('vendor')){
                $product->vendor_id = Auth::user()->id;
            }else{
                $product->vendor_id = -1;
            }
            $product->save();

            $this->saveProductVariant($request,$product);
        }

        private function saveProductVariant($request,$product){
         

        $unidstr = substr($product->name,3);
        $sku = substr(uniqid($unidstr,true),0,6);

        $sku = $request->input('sku');
        
        $productConfig = new Productconfig;
        $productConfig->price = $request->input('price');
        $productConfig->discount = $request->input('discount');
        $discountedprice = ((100 - $productConfig->discount)/100)*$productConfig->price;
        $productConfig->discountedprice = $discountedprice;
        $productConfig->sku = $sku;
        $productConfig->capacity = $request->input('capacity');
        $productConfig->unit_id = $request->input('unit');
        $productConfig->quantity = $request->input('quantity');        
        if(User::checkRole('admin')){
            $productConfig->credits = $request->input('credits');
            $productConfig->lotteryproduct = $request->input('lottery_product');
            //$productConfig->lottery_id = $request->input('lottery_product') == 1 ? $request->input('lottery_id') : -1;
			 $productConfig->lottery_id = ($productConfig->lotteryproduct?$request->input('lottery_id'):0);
           // $productConfig->fixedlotteryproduct = $request->input('lottery_winner');
        }
        $productConfig->description = $product->description;
        $productConfig->description_arabic = $product->description_arabic;
        $productConfig->supermarket_id = $product->supermarket_id;
        $data = [];
        if($request->hasfile('filename'))
        {

           foreach($request->file('filename') as $file)
           {
               //$fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            //    $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            //    $fullFileName = uniqid('img_').'.'.$file->getClientOriginalExtension();
            //    $file->move(public_path().Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data'), $fullFileName); ;  
            //    $data[] = $fullFileName;  

            $path = Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data');
            $data[] = $this->uploadMultipleImage($file,$path);
            
           }
        }

        $productConfig->image_path = json_encode($data);
        $productConfig->category_id= $product->category_id;
        if(User::checkRole('admin')){
            $productConfig->is_approved = 1;
        }
        //$productConfig->lotteryproduct= $request->query('lotteryproduct');
        $product->productconfig()->save($productConfig);

        }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $p= new Product;
        $product= $p->getProductsbyConfigId($id);
        //return $product;
        return view('products.show',compact('product'));


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Productconfig $product)
    {
        $c = new Category;
        $categories = $c->getCategoryForParentId();

        $vendor = Vendor::getSupermarketId(); 

        $units = Constant::where([['constant_type','PRODUCT_UNITS'],['status',1]])->get();
        $p = new Product;
        $products = $p->getProductsbyConfigId($product->id);
        $date = new Carbon;
        $lotteries = Lottery::select('id','name')->where([['valid_till', '>',$date],['is_enabled','!=',0]] )->get();
        $selectedlottery = Lottery::find($product->lottery_id);
        $sm = Supermarket::all('id','name');
        //return $products;
        return view('products.edit',[
            'vendor' => $vendor,
            'product' =>$products,
            'sm' => $sm,
            'lotteries' => $lotteries,
            'selectedlottery' => $selectedlottery,
            'units' => $units,
            ],compact('categories'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductConfig $product)
    {
        //return $request; 
        $this->validate($request,[
                'supermarket_id' => 'required|integer|min:1',
                'lottery_product' => 'required|integer',
              //  'lottery_winner' => 'required|integer',
                'name' => 'required|max:255',
                'name_arabic' => 'required|max:255',
                'description' => 'required|max:1023',
                'price' => 'required|min:1',
                'discount' => 'required|min:0|max:100',
                'capacity' => 'required|min:0|',
                'quantity' => 'integer|required|min:0|',
                'sku' => 'required',
            ]);
            
       
        $product_info = Product::where('id',$product->product_id)->get();
        $p = Product::find($product_info[0]['id']);
        $p->name = $request->input('name');
        $p->name_arabic = $request->input('name_arabic');
        $p->description = $request->input('description ');
        $p->description_arabic = $request->input('description_arabic');
        $p->supermarket_id = $request->input('supermarket_id');
        //return $p;
        $p->save();
        $product->price = $request->input('price');
        $product->discount = $request->input('discount');
        $discountedprice = ((100 - $product->discount)/100)*$product->price;
        $product->discountedprice = $discountedprice;
        $product->capacity = $request->input('capacity');
        $product->unit_id = $request->input('unit');
        $product->quantity = $request->input('quantity'); 
        $product->sku = $request->input('sku');       
        $product->credits = $request->input('credits');
        $product->description = $request->input('description');
        $product->description_arabic = $request->input('description_arabic');
        $product->lotteryproduct = $request->input('lottery_product');
        //$product->fixedlotteryproduct = $request->input('lottery_winner');
        //$product->lottery_id = $request->input('lottery_id') == -1 ? $product->lottery_id : $request->input('lottery_id');
        $product->lottery_id = ($product->lotteryproduct?$request->input('lottery_id'):0);
        $product->supermarket_id = $product_info[0]->supermarket_id;
        $data = [];

     
        if($request->hasfile('filename'))
        {
            $this->validate($request,[
                'filename' => 'required',
                'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
        
            $files = json_decode($product->image_path);
            $path = Constant::where('constant_type','SUPERMARKET_IMAGE_PATH')->value('data');
            
            foreach($files as $file){
                $this->deleteIfExists($file,$path);
            }

           foreach($request->file('filename') as $file)
           {
               $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
               
               $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
               $fullFileName = uniqid('img_').'.'.$file->getClientOriginalExtension();
               $file->move(public_path().Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data'), $fullFileName); 
               $data[] = $fullFileName;
             //$data[] = $this->uploadMultipleImage($file,$path);
                
           }
           $product->image_path = json_encode($data); 
           
        }
        $product->category_id= $product->category_id;
        $product->is_enabled = $request->input('status');
        $product->save();

        if (User::checkRole('vendor')){
            return redirect()->route('product.index')->with('success','Product was Updated!');
           }else if (User::checkRole('admin')) {
            $p =  new Product;
            $products = $p->getProductDetailsBySupermarketID($request->supermarket_id);
            
            $sm = Supermarket::getValidSupermarkets();
            \Session::flash('success','Products was updated');
            return view('products.list',compact('products','sm'));
            
           }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductConfig $product)
    {   
        $product->status = 0;
        $product->is_enabled = 0;
        $product->save();
        //return $product;
        $p = new Product;
        $products = $p->getProductDetailsBySupermarketID($product->supermarket_id);
        $sm = Supermarket::getValidSupermarkets();
        \Session::flash('success','Products was deleted');
        return view('products.list',compact('products','sm'));
        
    }

    public function list(){
            $sm = Supermarket::getValidSupermarkets();
            return view('products.list',compact('sm'));
    }

    public function listview( Request $request){
        $p =  new Product;
        $products = $p->getProductDetailsBySupermarketID($request->supermarket_id);
        $sm = Supermarket::getValidSupermarkets();  
        return view('products.list',compact('sm','products'));
    }

     public function approve($id,$supermarket_id){
            $p =  Productconfig::find($id);
            $p->is_approved = 1;
            $p->save();
            $pr =  new Product;
            $products = $pr->getProductDetailsBySupermarketID($supermarket_id);
            $sm = Supermarket::getValidSupermarkets();
            \Session::flash('success','Product was Approved');
            return view('products.list',compact('products','sm'));

     }      

     public function approveall($id){
            $p =new Product;
            $p->approveAll($id);
            $pr =  new Product;
            $products = $pr->getProductDetailsBySupermarketID($id);
            $sm = Supermarket::getValidSupermarkets();
            \Session::flash('Success','All Products were Approved');
            return view('products.list',compact('products','sm'));


     }
    
    public function showproductbysupermarket($supermarket_id,$category_id){
        $p = new Product;
        $products = $p->getProductBySupermarketIDAndCategoryId($supermarket_id,$category_id);
        //return $products;
        return view('products.index',compact('products'));

    }

    public function productlist(Request $request) {          
        App::setLocale($request->header('locale'));
        $user=auth('api')->user();
        if($user){
            $userdata = $user->toArray();
        }
        $sid = $request->sid;
        $cid = $request->cid;
        $validator = Validator::make($request->all(), [
            'cid' => 'bail|required|min:1|int|exists:categories,id',
            'sid' => 'bail|required|min:1|int|exists:supermarkets,id'
        ]);

        if ($validator->fails()) {
            return $this->erroroutput($validator);
        }

        //$productlist = Product::with('supermarket','productconfig')->where(['supermarket_id' => $sid, 'category_id' => $cid])->get()->toArray();  
          $productlist = Product::with('supermarket','productconfig')->whereRaw('id IN (select p.id from products p inner join productconfigs pc on pc.product_id=p.id where pc.status=1 and pc.is_enabled=1 and pc.is_approved=1 and pc.supermarket_id='.$sid.' and pc.category_id='.$cid.')')->get()->toArray(); 
		  
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
        $message    = trans('lang.success');
        $redata = array('productslist' => $productlist, "product_image_path" => $path);        
        return $this->customerrormessage($message,$redata,200); 
    }

    public function productview(Request $request) {
        App::setLocale($request->header('locale'));
		$user=auth('api')->user();
        if($user){
            $userdata = $user->toArray();
        }
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'id' => 'required|min:1|int|exists:products,id'
        ]);

        if ($validator->fails()) {
            return $this->erroroutput($validator);
        }
 		 
        //$product = Product::with('supermarket','productconfig')->where(['id' => $id])->get()->toArray(); 
        $product = Product::with('supermarket','productconfig')->whereRaw('id IN (select p.id from products p inner join productconfigs pc on pc.product_id=p.id where pc.status=1 and pc.is_enabled=1 and pc.is_approved=1 and p.id='.$id.')')->get()->toArray(); 
        foreach($product[0]['productconfig'] as $pck => $pcv) {
            $unitid = Constant::find($pcv['unit_id'])->data;
            $product[0]['productconfig'][$pck]['unit_id'] = $unitid;
            $product[0]['productconfig'][$pck]['variant_name'] =  $product[0]['name'];
            $product[0]['productconfig'][$pck]['variant_name_arabic'] =  $product[0]['name_arabic'];
            $product[0]['productconfig'][$pck]['wishlist_item'] = '0';
            $product[0]['productconfig'][$pck]['weeklylist_item'] = '0';            
             if($user){
                $wishlistdata = DB::select("SELECT * FROM wishlists WHERE user_id = '".$userdata['id']."' AND productconfig_id = '".$pcv['id']."'");
                $weeklylistdata = DB::select("SELECT * FROM weeklylists WHERE user_id = '".$userdata['id']."' AND productconfig_id = '".$pcv['id']."'");
                if(!empty($wishlistdata)) {
                $product[0]['productconfig'][$pck]['wishlist_item'] = '1';
                }            
                if(!empty($weeklylistdata)) {
                    $product[0]['productconfig'][$pck]['weeklylist_item'] = '1';
                }  
            }           
        }
        $path = Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data');        
        
        
        $message    = trans('lang.success');
        $redata = array('product' => $product, "product_image_path" => $path);
        return $this->customerrormessage($message,$redata,200);
        
        /* old for reference */
        /*$supermarketdata = Supermarket::where(['id' => $sid])->get(['freedeliveryamount','deliverytime'])->toArray();
        $products = Product::where(['supermarket_id' => $sid, 'category_id' => $cid])->get()->toArray();
        foreach($products as $productk => $productv) {
            $productdetails = Productconfig::where(['product_id' => $productv['id']])->get()->toArray();
            $products[$productk]['variants'] = $productdetails;
            $products[$productk]['deliveryduration'] = $supermarketdata[0]['deliverytime'];
            $products[$productk]['deliveryamount']   = $supermarketdata[0]['freedeliveryamount'];
            $productfinal = $products;
        }*/
        /*$product = Product::where(['id' => $id])->get()->toArray();;
        $productdetails = Productconfig::where(['product_id' => $id])->get()->toArray();
        $supermarketdata = Supermarket::where(['id' => $product[0]['supermarket_id']])->get(['freedeliveryamount','deliverytime'])->toArray();
        $product['variants'] = $productdetails;
        $product['deliveryduration'] = $supermarketdata[0]['deliverytime'];
        $product['deliveryamount']   = $supermarketdata[0]['freedeliveryamount'];*/
    } 
}
