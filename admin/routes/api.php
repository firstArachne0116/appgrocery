<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/



Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');
Route::get('sendOtp', 'PassportController@sendWebOtp');
Route::post('emailpassword', 'PassportController@getresettoken');
Route::post('resetpassword', 'PassportController@resetpassword');
Route::post('gethome', 'HomeController@gethome');
Route::post('getslide', 'HomeController@getslide');
Route::post('categorylist', 'CategoryController@categorylist');
Route::post('subcategorylist', 'CategoryController@subcategorylist');
Route::post('productlist', 'ProductController@productlist');
Route::post('productview', 'ProductController@productview');
Route::post('marketlist', 'SupermarketController@marketlist');
Route::post('market', 'SupermarketController@market');
Route::get('getcountry', 'HomeController@getcountry');
Route::post('getcity', 'HomeController@getcity');
//  Route::get('test','CommonController@test');
 
Route::middleware('auth:api')->group(function () {
    Route::get('initotp', 'PassportController@initotp');
    Route::post('endotp', 'PassportController@endotp');
    Route::get('lottery', 'LotteryController@boughtdeals');   
    Route::post('updatetoken', 'PassportController@updateToken');
    Route::get('getprofile', 'PassportController@getprofile');
    Route::get('logout', 'PassportController@logout');
    Route::post('updateprofile', 'PassportController@updateprofile');
    Route::post('changepassword', 'PassportController@changepassword');    
    Route::post('addaddress', 'AddressController@addaddress');
    Route::get('listaddress', 'AddressController@listaddress');
    Route::post('deleteaddress', 'AddressController@deleteaddress');
    Route::get('rewards', 'PassportController@userrewards');
    Route::get('couponlist','CouponController@getcoupons');
    Route::post('couponview', 'CouponController@couponview');
    route::post('getcoupon', 'CouponController@getcoupon');
    Route::get('getwishlist', 'PassportController@getwishlist');
    Route::post('addtowishlist', 'PassportController@addtowishlist');
    Route::post('deletefromwishlist', 'PassportController@deletefromwishlist');
    Route::post('movefromwishlist', 'PassportController@deletefromwishlist');
    Route::get('getweeklylist', 'PassportController@getweeklylist');
    Route::post('addtoweeklylist', 'PassportController@addtoweeklylist');
    Route::post('deletefromweeklylist', 'PassportController@deletefromweeklylist');
    Route::post('movefromweeklylist', 'PassportController@movefromweeklylist');    
    Route::post('checkout', 'CartController@checkout');
    Route::post('placeorder', 'OrderController@placeorder');
    Route::get('orderlist', 'OrderController@orderlist');
    Route::post('orderview', 'OrderController@orderview');
    Route::post('cancelorder', 'OrderController@cancelorder');
    Route::get('notifications', 'CommonController@getnotifications');
    // Route::post('gethome', 'HomeController@gethome');
    // Route::post('getslide', 'HomeController@getslide');
    // Route::get('getcountry', 'HomeController@getcountry');
    // Route::post('getcity', 'HomeController@getcity');
    // Route::post('marketlist', 'SupermarketController@marketlist');
    // Route::post('market', 'SupermarketController@market');
    // Route::post('categorylist', 'CategoryController@categorylist');
    // Route::post('subcategorylist', 'CategoryController@subcategorylist');
    // Route::post('productlist', 'ProductController@productlist');
    // Route::post('productview', 'ProductController@productview');    

});

