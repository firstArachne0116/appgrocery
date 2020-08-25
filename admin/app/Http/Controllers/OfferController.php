<?php

namespace App\Http\Controllers;

use App\Offer;
use App\Product;
use App\Category;
use App\Constant;
use App\Supermarket;
use App\Productconfig;
use Illuminate\Http\Request;
use App\Http\Traits\ImageUploadTrait;

class OfferController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::where('status','!=', 0)->get();
        // $item =  json_decode($offers[0]->image_path);
        // return $item[0];
        return view('offers.index',compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id','name')->where('parentid',0)->get();
        $sm = Supermarket::getValidSupermarkets();
        return view('offers.create',compact('sm','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //return $request;

        $this->validate($request,[
            'offer_type' => 'required|integer',
            'name' => 'required|max:255',
            'name_arabic' => 'required|max:255',
            'description' => 'required|max:1023',
            'description_arabic' => 'required|max:1023',
            'main_category_id' => 'required|integer',
            'sub_category_id' => 'required|integer',
            'category_id' => 'required|integer',
            
        ]);
        $offer = new Offer;
                    $offer->name = $request->input('name');
                    $offer->name_arabic = $request->input('name_arabic');
                    $offer->description = $request->input('description');
                    $offer->description_arabic = $request->input('description_arabic');
                    $offer->supermarket_id = $request->input('supermarket_id');
                    $offer->main_category_id = $request->input('main_category_id');
                    $offer->sub_category_id = $request->input('sub_category_id');
                    $offer->category_id = $request->input('category_id');
                    $offer->offer_type = $request->input('offer_type');

        switch ($request->input('offer_type')) {
            case "1":
            $this->validate($request,[
                'productconfig_id' => 'required|integer',
                'image_slider' => 'required',
                'image_slider_arabic' => 'required',
                'image_slider.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'image_slider_arabic.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            $offer->productconfig_id = $request->input('productconfig_id');
            if ($request->has('productconfig_id') && $request->input('productconfig_id') > 0 ){
                $product_id = Productconfig::find($offer->productconfig_id);
                $offer->product_id = $product_id->product_id;
            }   
            $data = [];
            $data2 = [];
            if($request->hasfile('image_slider'))
            {
                $path = Constant::where('constant_type','OFFER_SLIDER_IMAGE_ENGLISH')->value('data');
                $data = $this->uploadImage($request->file('image_slider'),$path); 
                $offer->image_path = json_encode($data);
               
            }
            if($request->hasfile('image_slider_arabic'))
            { 
                $path = Constant::where('constant_type','OFFER_SLIDER_IMAGE_ARABIC')->value('data');
                $data = $this->uploadImage($request->file('image_slider_arabic'),$path); 
                $offer->image_path_arabic = json_encode($data); 
               
            }
                $offer->save();
                
                break;
            case 2:
                    $this->validate($request,[
                         'image' => 'required',
                         'image_arabic' => 'required',
                         'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                         'image_arabic.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                    ]);
                    if($request->hasfile('image')){
                
                        $path = Constant::where('constant_type','OFFER_STATIC_IMAGE_ENGLISH')->value('data');
                        $data = $this->uploadImage($request->file('image'),$path); 
                        $offer->image_path = json_encode($data); 
                        
                    }
                    if($request->hasfile('image_arabic')){
                        $path = Constant::where('constant_type','OFFER_STATIC_IMAGE_ARABIC')->value('data');
                        $data = $this->uploadImage($request->file('image_arabic'),$path); 
                        $offer->image_path_arabic = json_encode($data);   
                    }
                    $offer->save();
                   
                    break;
                }
                return redirect()->route('offer.index')->with('success','Offer was added!');         

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //return $offer;
        return view('offers.show',compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        $p = new Product;
        $products = $p->getproductsbycategory($offer->productconfig_id,$offer->supermarket_id);
        return view('offers.edit',compact('offer','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        
        $this->validate($request,[
            'name' => 'required|max:255',
            'name_arabic' => 'required|max:255',
            'description' => 'required|max:1023',
            'description_arabic' => 'required|max:1023',
            'status' => 'required|integer'

        ]);
        $offer->name = $request->input('name');
        $offer->name_arabic = $request->input('name_arabic');
        $offer->description = $request->input('description');
        $offer->description_arabic = $request->input('description_arabic');
        if($offer->offer_type == 1){
            $this->validate($request,[
                'productconfig_id' => 'required|integer'
            ]);
            if($request->hasfile('image_slider'))
            {
                $this->validate($request,[
                    'image_slider' => 'required',
                    'image_slider.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $file = json_decode($offer->image_path);
                $path = Constant::where('constant_type','OFFER_SLIDER_IMAGE_ENGLISH')->value('data');
                $this->deleteIfExists($file,$path);
                $data = $this->uploadImage($request->file('image_slider'),$path); 
                $offer->image_path = json_encode($data); 
               
               
            }
            if($request->hasfile('image_slider_arabic'))
            {
                $this->validate($request,[
                    'image_slider_arabic' => 'required',
                    'image_slider_arabic.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                $file = json_decode($offer->image_path_arabic);
                $path = Constant::where('constant_type','OFFER_SLIDER_IMAGE_ARABIC')->value('data');
                $this->deleteIfExists($file,$path);
                $data = $this->uploadImage($request->file('image_slider_arabic'),$path); 
                $offer->image_path_arabic = json_encode($data);
   
               
               
            }
        }
        if($offer->offer_type == 2){
            if($request->hasfile('image'))
            {
                $this->validate($request,[
                    'image' => 'required',
                    'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
           
                $file = json_decode($offer->image_path);
                $path = Constant::where('constant_type','OFFER_STATIC_IMAGE_ENGLISH')->value('data');
                $this->deleteIfExists($file,$path);
                $data = $this->uploadImage($request->file('image'),$path); 
                $offer->image_path = json_encode($data);
    
            }
            if($request->hasfile('image_arabic'))
            {
                $this->validate($request,[
                    'image_arabic' => 'required',
                    'image_arabic.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
        

                $file = json_decode($offer->image_path_arabic);
                $path = Constant::where('constant_type','OFFER_STATIC_IMAGE_ARABIC')->value('data');
                $this->deleteIfExists($file,$path);
                $data = $this->uploadImage($request->file('image_arabic'),$path); 
                $offer->image_path_arabic = json_encode($data);
            }
        }
        $offer->is_enabled = $request->input('status');
        $offer->save();

        //return $offer;
        return redirect()->route('offer.index')->with('success','Offer was updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        $offer->status = 0;
        $offer->is_enabled = 0;
        $offer->save();

        return redirect()->route('offer.index')->with('success','Offer was deleted!');

    }
}
