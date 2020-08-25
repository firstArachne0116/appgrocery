<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes(['register' => false]);
Route::get('/','HomeController@index')->middleware('auth');

Route::get('/home', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('markAsRead/{id}','HomeController@markasread')->name('markAsRead');
Route::get('markAllAsRead','HomeController@markAllAsRead')->name('markAllAsRead');
Route::resource('/category','CategoryController')->middleware('auth');
Route::group(['middleware' => ['auth','role:admin']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::get('/listvendor','UserController@listvendor')->name('users.listvendor');
    Route::resource('seller','VendorController');
    Route::resource('supermarket','SupermarketController');
    Route::get('list','ProductController@list')->name('product.list');
    Route::post('list','ProductController@listview')->name('product.showproduct');
    Route::post('approve/{id}/{supermarket_id}','ProductController@approve')->name('product.approve');
    Route::post('approve/{id}/','ProductController@approveall')->name('product.approveall');
    
    
    Route::resource('/coupon','CouponController');
    
    Route::resource('/offer','OfferController');
    Route::get('supermarket/{supermarket_id}/{category_id}','ProductController@showproductbysupermarket')
    ->name('supermarket.showproduct');

    // LOTTERY ROUTES 
    Route::resource('lottery','LotteryController');
    Route::get('/lottery-report','LotteryController@reports')->name('lottery.reports');
    Route::post('/lottery-report-show','LotteryController@showlotteryreport')->name('lottery.showlotteryreport');
    Route::get('/lottery-winner','LotteryController@winner')->name('lottery.winner');
    Route::post('/lottery-winner-upload','LotteryController@winnerupload')->name('lottery.winnerupload');
    // ENF OF LOTTERY ROUTES 
});
Route::get('list','ProductController@list')->name('product.list');
Route::post('list','ProductController@listview')->name('product.showproduct');

Route::resource('product','ProductController');
Route::post('/setexpiredate', 'OrderController@setproductexpiredate')->name('setexpiredate');
Route::get('/expirenotification', 'OrderController@sendProductExpirationNotification')->name('expirenotification');
Route::resource('order','OrderController',['only' => ['index', 'show']]);



Route::get('/addcategorytosupermarket','CategoryController@choose')->name('category.add');
Route::get('/delete/{id}','CategoryController@delete')->name('category.delete');
Route::post('category/choose','CategoryController@storesupermarketcategory')->name('category.storesupermarketcategory');



Route::get('/getstate','CommonController@getstate');
Route::get('/getcity','CommonController@getcity');
Route::get('/getproductbysupermarketid','CommonController@getproductbysupermarketid');
Route::get('/getsubcategory','CommonController@getsubcategory');
Route::get('/getsubsubcategory','CommonController@getsubsubcategory');
Route::get('/getcategorybysupermarketid','CommonController@getcategorybysupermarketid');
Route::get('/getusersbylotteryid','CommonController@getusersbylotteryid');
Route::get('/getproductsbycategory','CommonController@getproductsbycategory');


Route::get('/test','CommonController@test');



Route::resource('/report','ReportController');
Route::post('/showsalesreport','ReportController@showreport')->name('report.showreport');
Route::post('/showsupermarketsalesreport','ReportController@showsupermarketreport')->name('report.showlistreport');
Route::get('/listsupermarket','ReportController@list')->name('report.list');


Route::resource('/commission','CommissionController');
Route::post('showreport','CommissionController@showreport')->name('commission.showreport');


Route::post('show-shipping-details','ShippingController@showshipping')->name('shipping.showshipping');
Route::get('show-shipping','ShippingController@list')->name('shipping.list');
Route::resource('/shipping','ShippingController');
Route::get('/getarea','CommonController@getArea');
//Route::get('/','LoginController@showLoginForm');
