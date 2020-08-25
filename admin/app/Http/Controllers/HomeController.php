<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\City;
use App\User;
use App\Offer;
use App\Order;
use App\Vendor;
use App\Lottery;
use App\Product;
use App\Constant;
use App\Wishlist;
use App\Commission;
use App\Weeklylist;
use App\Supermarket;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use App\Http\Traits\ValidationTrait;
use Illuminate\Support\Facades\Validator;
use App\Productconfig;

class HomeController extends Controller
{
    use ValidationTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (User::checkRole('admin')){
            $lotteries = Lottery::getDetailsValidLotteries();
            
            $to_date= date("Y-m-d");
            $week_date= date('Y-m-d', strtotime('-7 days')); 
            $month_date= date('Y-m-d', strtotime('-30 days')); 
            $dailyCommission = Commission::select(DB::raw('sum(commission_payable) as dailyamount'))
            ->wheredate('created_at',$to_date)->get();
            $weeklyCommission = Commission::select(DB::raw('sum(commission_payable) as weeklyamount'))
            ->wheredate('created_at','>=',$week_date) 
            ->wheredate('created_at','<=',$to_date)->get();
            $monthlyCommission = Commission::select(DB::raw('sum(commission_payable) as monthlyamount'))
            ->wheredate('created_at','>=',$month_date)
            ->wheredate('created_at','<=',$to_date)->get();
            Lottery::disableExpiredLotteries();
            $lotteries = Lottery::getDetailsValidLotteries();
            return view('home',compact('lotteries','dailyCommission','weeklyCommission','monthlyCommission'));
        }
        else if (User::checkRole('vendor')){
            $vendor = Vendor::getSupermarketId();
            $o = new Order;
            $orders = $o->getOrdersBySupermarketId($vendor[0]['supermarket_id']);
            $p = new Product;
            $products = $p->getProductBySupermarketIDAndVendorID($vendor[0]['supermarket_id'],Auth::user()->id);
            return view('home',compact('orders','products'));

        }
    }
    public function markasread($id){
        $notification = auth()->user()->notifications()->find($id);
        if($notification) {
            $notification->markAsRead();
        }
        return redirect()->route('home');
    }
    public function markAllAsRead(){
        $notification = auth()->user()->unreadNotifications->markAsRead();;
        return redirect()->route('home');
    }

    /* API Calls*/
    public function getcountry(Request $request) {
        App::setLocale($request->header('locale'));
        $countries = DB::table('countries')->get();
        foreach($countries as $countryk => $countryv) {
            $code = $countryv->sortname;
            $flag_image_link = url('public/cflags/') .'/'. $code . '.png';
            $countries[$countryk]->flag = $flag_image_link;
        }                
        $message    = trans('lang.success');       
        $redata = array('countries' => $countries);
        return $this->customerrormessage($message,$redata,200); 
    }

    public function getcity(Request $request) {
        App::setLocale($request->header('locale'));
        $validator = Validator::make($request->all(), [
            'countryid'         => 'required|int|exists:countries,id'
        ]);
        if ($validator->fails()) {
            return $this->erroroutput($validator);
        }
         $countryid = $request->countryid;
         $country = DB::table('countries')->where(['id' => $countryid])->get();
        // $cities = DB::table('cities')->where(['country_id' => $countryid])->get(); 
        	$cities =City::select('id','name')->with('area')->get();	
			//dd($cities);
        $message    = trans('lang.success');
        $redata = array('cities' => $cities, 'country' => $country);
        return $this->customerrormessage($message,$redata,200); 
    }

    public function gethome(Request $request) {        
        App::setLocale($request->header('locale'));
        if(Auth::check()){
            $userid = Auth::user()->id;
        }
        $latitude   = $request->latitude;
        $longitude  = $request->longitude;     
        $dist = 30;
        $slideoffers = array();
        if(isset($latitude) && isset($longitude)) {
            $validator = Validator::make($request->all(), [
                'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
            ]);
            if ($validator->fails()) {
                return $this->erroroutput($validator);
            }
           // $list = Supermarket::where(['latitude' => $latitude, 'longitude' => $longitude])->get()->toArray();
           $list= DB::select("SELECT id,name,name_arabic, latitude, longitude,country_id,state_id,city_id,address,freedeliveryamount,fixeddeliveryamount,image_path,
           fixedserviceamount,commission_percentage,cash_money, deliverytime,status, 3956 * 2 * 
          ASIN(SQRT( POWER(SIN(($latitude - latitude)*pi()/180/2),2)
          +COS($latitude*pi()/180 )*COS(latitude*pi()/180)
          *POWER(SIN(($longitude-longitude)*pi()/180/2),2))) 
          as distance FROM supermarkets WHERE 
          longitude between ($longitude-$dist/cos(radians($latitude))*69) 
          and ($longitude+$dist/cos(radians($latitude))*69) 
          and latitude between ($latitude-($dist/69)) 
          and ($latitude+($dist/69)) and is_enabled=1 having distance < $dist ORDER BY distance limit 100 "); 
          $listArr = json_decode(json_encode($list), true); 
        
            if(empty($list)) {
                $message = trans('lang.emptysupermarket');
                $redata = array();
                return $this->customerrormessage($message,$redata,403); 
            }
            $offers = array();
            foreach($listArr as $sk => $sv) {
                /* $products = Product::with('productconfig')->where('supermarket_id', )->whereHas('productconfig', function($q){
					            $q->join("lotteries","lotteries.id","=","productconfigs.lottery_id")->where(['productconfigs.lotteryproduct' => 1,'lotteries.is_enabled'=>1])->where('valid_till','>',date('Y-m-d'));
                               // $q->where('lotteryproduct', '1');
                            })->get()->toArray(); */		
                 $date=date('Y-m-d');					
               $products = Product::with('productconfig')->whereRaw('id IN (select p.id from products p inner join productconfigs pc on pc.product_id=p.id inner join lotteries l on l.id=pc.lottery_id where pc.lotteryproduct=1 and l.is_enabled=1 and l.valid_till >'.$date.' and pc.status=1 and pc.is_enabled=1 and pc.is_approved=1 and pc.supermarket_id='.$sv['id'].')')->get()->toArray(); 							
                //$products = Productconfig::select("productconfigs.*")->join("lotteries","lotteries.id","=","productconfigs.lottery_id")->where(['productconfigs.supermarket_id' => $sv['id'], 'productconfigs.lotteryproduct' => 1,'lotteries.is_enabled'=>1])->where('valid_till','>',date('Y-m-d'))->get()->toArray();    
				
                foreach($products as $productk => $productv) {
                    foreach($productv['productconfig'] as $pck => $pcv) {                          
                        $unitid = Constant::find($pcv['unit_id'])->data;
                        $products[$productk]['productconfig'][$pck]['unit_id'] = $unitid; 
                        $products[$productk]['productconfig'][$pck]['variant_name'] =  $productv['name'];
                        $products[$productk]['productconfig'][$pck]['variant_name_arabic'] =  $productv['name_arabic'];                                            
                        $products[$productk]['productconfig'][$pck]['wishlist_item'] = '0';
                        $products[$productk]['productconfig'][$pck]['weeklylist_item'] = '0';
                        if(Auth::check()){
                                $wishlistdata = Wishlist::where(['user_id' => $userid, 'productconfig_id' => $pcv['id']])->get(['id'])->toArray();                        
                                $weeklylistdata = Weeklylist::where(['user_id' => $userid, 'productconfig_id' => $pcv['id']])->get(['id'])->toArray();                                                                       
                            if(!empty($wishlistdata)) {                                                                                   
                                $products[$productk]['productconfig'][$pck]['wishlist_item'] = '1';
                            }          
                            if(!empty($weeklylistdata)) {
                                $products[$productk]['productconfig'][$pck]['weeklylist_item'] = '1';
                            }   
                        }            
                                                                             
                    }
                   
                }
                $listArr[$sk]['products'] = $products;
                $slideoffers=  Offer::where(['supermarket_id' => $sv['id'], 'offer_type' => '1','is_enabled'=>1])->get(); 
                if (count($slideoffers)  > 0 ){
                    foreach($slideoffers as $slideoffer){
                        array_push($offers,$slideoffer);
                    }
                }                               
            }
                        
            $images_paths['offer_image_path_english'] = Constant::where('constant_type','OFFER_SLIDER_IMAGE_ENGLISH')->value('data');
            $images_paths['offer_image_path_arabic']  = Constant::where('constant_type','OFFER_SLIDER_IMAGE_ARABIC')->value('data');
            $images_paths['supermarket_image_path']   = Constant::where('constant_type','SUPERMARKET_IMAGE_PATH')->value('data');
            $images_paths['product_image_path']       = Constant::where('constant_type','PRODUCT_IMAGE_PATH')->value('data');
                            
            $message = trans("lang.success");
            $redata = array('list' => $listArr, "offers" => $offers, 'images_paths' => $images_paths);            
            return $this->customerrormessage($message,$redata,200); 
        }
    }

    public function getslide(Request $request) {
        App::setLocale($request->header('locale'));
        $sid        = $request->supermarket;
        $catid      = $request->maincategory;
        $subcatid   = $request->subcategory;
        $scat       = $request->childcategory;
        
        if($sid) {
            if($catid) {
                $slideoffers =  Offer::where(['supermarket_id' => $sid, 'offer_type' => '2', 'main_category_id' => $catid,'is_enabled'=>1])->get(); 
            } else if ($subcatid) {
                $slideoffers =  Offer::where(['supermarket_id' => $sid, 'offer_type' => '2', 'sub_category_id' => $subcatid,'is_enabled'=>1])->get();
            } else if($scat) {
                $slideoffers =  Offer::where(['supermarket_id' => $sid, 'offer_type' => '2', 'category_id' => $scat,'is_enabled'=>1])->get();
            }            
        }

        if($slideoffers) { 
            $offerimages['offer_image_path_english'] = Constant::where('constant_type','OFFER_SLIDER_IMAGE_ENGLISH')->value('data');
            $offerimages['offer_image_path_arabic'] = Constant::where('constant_type','OFFER_SLIDER_IMAGE_ARABIC')->value('data');           
            $message = trans("lang.success");
            $redata = array("slides" => $slideoffers,"offerimages" => $offerimages);
            return $this->customerrormessage($message,$redata,200);
        }

    }
}
