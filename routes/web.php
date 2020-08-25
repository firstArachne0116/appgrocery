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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/setcoordinates', 'HomeController@setcoordinates');
Route::get('/supermarkets', 'SupermarketController@index')->name('supermarkets');
Route::get('/category/{sid}', 'CategoryController@categorylist')->name('categories');
Route::get('/category/{sid}/{cid}', 'CategoryController@subcategorylist')->name('subcategories');
Route::get('/category/{sid}/{cid}/{scid}', 'CategoryController@subsubcategorylist')->name('subsubcategories');
Route::get('/products/{sid}/{cid}/{scid}', 'ProductController@productlist')->name('products');
Route::get('/products/{sid}/{cid}/{scid}/{pid}', 'ProductController@productview')->name('product');
//Route::post('/products/search/{sid}/{cid}/{scid}', 'ProductController@productsearch')->name('product.search');
Route::post('/addtocart', 'CartController@addtocart')->name('addtocart');
Route::get('/cart', 'CartController@cart')->name('cart');
Route::post('/updatecart', 'CartController@updatecart')->name('updatecart');
Route::post('/proceedtocheckout', 'CartController@proceedtocheckout')->name('proceedtocheckout');
Route::get('/checkout', 'CartController@checkout')->name('checkout');
Route::post('/placeorder', 'OrderController@placeorder')->name('placeorder')->middleware('auth');
Route::get('/placedorder', 'OrderController@orderreceived')->name('placedorder')->middleware('auth');
Route::post('/add_address', 'CartController@add_address')->name('add_address');
Route::get('/orderdetails/{id}', 'OrderController@show')->name('order.show');
Route::get('/ordercancel/{id}', 'OrderController@ordercancel')->name('order.cancel');
Route::get('/persistantcartdelete','CartController@cartdelete')->name('cartdelete');
Route::get('/otpscreen','OtpController@index')->name('otpscreen');
Route::post('/otpverify','OtpController@verifyOtp')->name('verifyotp');
Route::get('/changepassword', 'UserController@changepassword')->name('changepassword');
Route::post('/updatepassword', 'UserController@updatepassword')->name('updatepassword');

Auth::routes();
Route::resource('/user','UserController');
Route::resource('/lottery','LotteryController'); 
Route::resource('/address','AddressController'); 
Route::post('/searchcoupon','CartController@searchcoupon')->name('searchcoupon');

Route::get('/terms-and-conditions','CommonController@termsandconditions')->name('common.terms');
Route::get('/about-us','CommonController@aboutus')->name('common.aboutus');
Route::get('/privacy','CommonController@privacy')->name('common.privacy');
Route::get('/contact-us','CommonController@contactus')->name('common.contactus');
Route::get('/faq','CommonController@faq')->name('common.faq');
Route::get('/getstate','CommonController@getstate');
Route::get('/getcity','CommonController@getcity');
Route::get('/getarea','CommonController@getArea');
Route::get('/changelanguage/{id}','CommonController@changelanguage')->name('common.changelanguage');
Route::post('/show','CommonController@show')->name('show');
Route::post('/change','CommonController@change')->name('common.change');
Route::post('/contactform','CommonController@contactform')->name('common.contactform');
Route::resource('/wishlist','WishlistController');
Route::resource('/weeklylist','WeeklyListController');
Route::post('/setlocation', 'CommonController@setlocation');

