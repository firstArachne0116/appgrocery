<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Supermarket;
use Illuminate\Http\Request;
use App\Http\Requests\SupermarketRequest;
use Illuminate\Support\Facades\Validator;
use App\Constant;

class SupermarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        $latitude   = session('latitude');
        $longitude  = session('longitude');
        // $country    = $request->country;
        // $city       = $request->city;
        if(isset($latitude) && isset($longitude)) {
            $list = Supermarket::where(['latitude' => $latitude, 'longitude' => $longitude,'status' => 1,'is_enabled' => 0])->paginate(2)->toArray();
            //return $list;
            return view('supermarkets.index', ['supermarkets' => $list]);
        } else if(isset($country) && isset($city)) {
            $list = Supermarket::where(['country_id' => $country, 'city_id' => $city])->get()->toArray();
            return view('supermarkets.index', ['supermarkets' => $list]);
        }
    }

}
