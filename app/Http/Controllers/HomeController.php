<?php

namespace App\Http\Controllers;

use DB;
use App\Offer;
use App\Product;
use App\Constant;
use App\Wishlist;
use App\Supermarket;
use App\Productconfig;
use App\Persistantcart;
use App\Country;
use Illuminate\Http\Request;
//use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{    

    public function __construct()
    {
        //$this->middleware('auth');
    }
    public function index() {
        $this->setcoordinates();
        //$supermarkets = $this->marketlist();
        $homedata       = $this->gethome();
        //echo '<pre/>'; print_r($homedata); exit;
        //return session('wishcount');
        //echo Session::has('name');
        return view('home',['data' => $homedata]);
    }

    public function setcoordinates() {                
        // $lat  = '25.1613751';
        // $long = '55.2590714';
        // session(['latitude' => $lat]);
        // session(['longitude' => $long]);
        $constant_url = url('admin/public');
        $supermarket_path  = Constant::where('constant_type','SUPERMARKET_IMAGE_PATH')->value('data');
        $product_path = Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data');
        $category_path = Constant::where('constant_type','CATEGORY_IMAGE_PATH')->value('data');
        $offer_eng_path = Constant::where('constant_type','OFFER_SLIDER_IMAGE_ENGLISH')->value('data');
        $offer_arabic_path = Constant::where('constant_type','OFFER_SLIDER_IMAGE_ARABIC')->value('data');
        $offer_static_english_path = Constant::where('constant_type','OFFER_STATIC_IMAGE_ENGLISH')->value('data');
        $offer_static_arabic_path = Constant::where('constant_type','OFFER_STATIC_IMAGE_ARABIC')->value('data');        
        session(['constant_url' => $constant_url,'supermarket_image_path' => $supermarket_path, 
        'category_image_path' => $category_path , 'product_image_path' => $product_path, 
        'offer_slider_image_eng' => $offer_eng_path, 'offer_slider_image_arabic' => $offer_arabic_path, 
        'offer_static_image_english' => $offer_static_english_path, 
        'offer_static_image_arabic' => $offer_static_arabic_path]);                
    }
    public function gethome() {        
        $latitude   = session('latitude'); // 25.1613751,55.2590714
        $longitude  = session('longitude');
        $latitude   = '25.1613751';
       $longitude  = '55.2590714';
        if(!session('currency_symbol')) {
            $country = Country::find('229');
            session(['currency_htmlcode' => $country->currency_htmlcode,'currency_name' => $country->currency_name, 'currency_code' => $country->currency_code]);
            session(['currency_symbol' => session('currency_code')]);  
        } 
        if (Session::has('name') && Session::has('description')) {               
            }
            else{                
                session(['name' => 'name','description' => 'description']);
                session(['language' => 'english']);                
            }
                
        
        if(Auth::check()) {
            $cartcount = $wishcount = 0;
            $user_id = Auth::user()->id;         
            $wishcount = Wishlist::wishcount($user_id);
            session(['wishcount' => $wishcount]);
            $cartcount = Persistantcart::where('user_id',$user_id)->count();
            $cart_info = Persistantcart::where('user_id',$user_id)->orderBy('created_at')->get();
            //echo json_encode($cartcount); exit();
            session(['cartcount' => $cartcount]);
            session(['cartinfo' => $cart_info]);
        }     
        if(isset($latitude) && isset($longitude) && $latitude>0 && $longitude>0) { 
            $dist = 30;
            /*$list = Supermarket::where(['latitude' => $latitude, 'longitude' => $longitude,
            'status' => 1,'is_enabled' => 1])->get()->toArray(); */
		$list= DB::select("SELECT id,is_enabled,name,name_arabic, latitude, longitude,country_id,state_id,city_id,address,freedeliveryamount,fixeddeliveryamount,
           fixedserviceamount,commission_percentage,cash_money, deliverytime,image_path,status, 3956 * 2 * 
          ASIN(SQRT( POWER(SIN(($latitude - latitude)*pi()/180/2),2)
          +COS($latitude*pi()/180 )*COS(latitude*pi()/180)
          *POWER(SIN(($longitude-longitude)*pi()/180/2),2))) 
          as distance FROM supermarkets WHERE 
          longitude between ($longitude-$dist/cos(radians($latitude))*69) 
          and ($longitude+$dist/cos(radians($latitude))*69) 
          and latitude between ($latitude-($dist/69)) 
          and ($latitude+($dist/69)) and is_enabled = 1 and status=1
          having distance < $dist ORDER BY distance limit 100"); 
		}
		else{
			$latitude=0;
			$longitude=0;
			$list= DB::select("SELECT id,is_enabled,name,name_arabic, latitude, longitude,country_id,state_id,city_id,address,freedeliveryamount,fixeddeliveryamount,
           fixedserviceamount,commission_percentage,cash_money, deliverytime,image_path,status, 3956 * 2 * 
          ASIN(SQRT( POWER(SIN(($latitude - latitude)*pi()/180/2),2)
          +COS($latitude*pi()/180 )*COS(latitude*pi()/180)
          *POWER(SIN(($longitude-longitude)*pi()/180/2),2))) 
          as distance FROM supermarkets where is_enabled = 1 and status=1 ORDER BY distance limit 100"); 
		}
		 // echo $query;exit;
            //$list= DB::select($query); 
         // having distance < $dist ORDER BY distance limit 100"); 
            $listArr = json_decode(json_encode($list), true);
            $slideoffers = array();  
            $productlist = array();
            foreach($listArr as $sk => $sv) {
                $products = Productconfig::select("productconfigs.*")->join("lotteries","lotteries.id","=","productconfigs.lottery_id")->where(['productconfigs.supermarket_id' => $sv['id'], 'productconfigs.lotteryproduct' => 1,'lotteries.is_enabled'=>1])->where('valid_till','>',date('Y-m-d'))->get()->toArray();                 
             
                //  config wishlist and weeklylist ststaus
            if(Auth::check()) {
                foreach($products as $pck => $pcv) {
                    $products[$pck]['wishlist_item'] = '0';
                    $products[$pck]['weeklylist_item'] = '0';
                    $products[$pck]['cid'] = '0';            
                    $wishlistdata = DB::select("SELECT * FROM wishlists WHERE user_id = '".$user_id."' AND productconfig_id = '".$pcv['id']."'");
                    $weeklylistdata = DB::select("SELECT * FROM weeklylists WHERE user_id = '".$user_id."' AND productconfig_id = '".$pcv['id']."'");
                    $categoryid = DB::select("SELECT parentid FROM categories WHERE id = '".$pcv['category_id']."'");                    
                    if(!empty($categoryid)) {
                        $products[$pck]['cid'] = $categoryid[0]->parentid;
                    }
                    if(!empty($wishlistdata)) {
                        $products[$pck]['wishlist_item'] = '1';
                    }          
                    if(!empty($weeklylistdata)) {
                        $products[$pck]['weeklylist_item'] = '1';
                    }            
                }
                         
                } else {
                    foreach($products as $pck => $pcv) {
                        $products[$pck]['wishlist_item'] = '0';
                        $products[$pck]['weeklylist_item'] = '0';
                        $products[$pck]['cid'] = '0'; 
                        $categoryid = DB::select("SELECT parentid FROM categories WHERE id = '".$pcv['category_id']."'");                    
                    if(!empty($categoryid)) {
                        $products[$pck]['cid'] = $categoryid[0]->parentid;
                    }
                    }
                }
               // $productlist[] = $products;
               $productlist= array_merge($productlist,$products);
                $slideoffers[] =  Offer::where(['supermarket_id' => $sv['id'], 'offer_type' => '1','is_enabled'=>1])->get()->toArray();                       
            }
            
            
            //echo '<pre/>'; print_r($productlist); exit;
                $redata = array('list' => $listArr, 'lotteryproducts' => $productlist, "offers" => $slideoffers);

            if($listArr){
                session(['supermarket_id' => $listArr[0]['id']]); 
            }
                       
            
            return $redata;
                
    }
}
