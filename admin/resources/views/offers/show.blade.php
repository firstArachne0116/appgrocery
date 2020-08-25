@extends('layouts.app')
@section('content')
<style>
.card-header {
    background-color:#3b2f5c !important;
    color:#FFF;
}
</style>
<div class="kt-container  kt-container--fluid kt-margin-b-100">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" id="headingOne">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2> Show Product</h2>
                        </div>                        
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('offer.index') }}"> Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="kt-container">
                    <div class="col-md-6"></div>
                </div>
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <label> Offer ID </label>
                            <br />
                            <p>{{$offer->id}}</p>
                        </div>
                        <div class="col-md-4">
                            <label> Offer Name </label>
                            <br />
                            <p>{{$offer->name}}</p>
                        </div>
                        <div class="col-md-4">
                            <label> Offer Name in Arabic </label>
                            <br />
                            <p>{{$offer->name}}</p>
                        </div>
                        <div class="col-md-4">
                            <label> Offer Description </label>
                            <br />
                            <p>{{$offer->description}}</p>
                        </div>
                        <div class="col-md-4">
                            <label> Offer Description in Arabic </label>
                            <br />
                            <p>{{$offer->description}}</p>
                        </div>
                        <div class="col-md-4">
                            <label> Offer Type </label>
                            <br />
                            <p>{{$offer->offer_type == 1 ? 'Slider Offers' : "Static Offers"}}</p>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="center"> Offer Picture</label>
                            <br />
                            <?php $item = json_decode($offer->image_path);   ?>
                             @for ($i = 0; $i < count($item); $i++)
                                @if ($offer->offer_type == 1)
                                <img src={{asset(App\Constant::where('constant_type','OFFER_SLIDER_IMAGE_ENGLISH')->value('data').'/'.$item[$i])}} height="300" width="300" >
                                @else
                                <img src={{asset(App\Constant::where('constant_type','OFFER_STATIC_IMAGE_ENGLISH')->value('data').'/'.$item[$i])}} height="300" width="300" >  
                                @endif
                                
                             @endfor
                            
                        </div>
                        <div class="col-md-6">
                            <label class="center"> Offer Picture in Arabic</label>
                            <br />
                            <?php $item = json_decode($offer->image_path_arabic);   ?>
                             @for ($i = 0; $i < count($item); $i++)
                                @if ($offer->offer_type == 1)
                                <img src={{asset(App\Constant::where('constant_type','OFFER_SLIDER_IMAGE_ARABIC')->value('data').'/'.$item[$i])}} height="300" width="300" >
                                @else
                                <img src={{asset(App\Constant::where('constant_type','OFFER_STATIC_IMAGE_ARABIC')->value('data').'/'.$item[$i])}} height="300" width="300" >  
                                @endif
                                
                             @endfor
                            
                        </div>
                        
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection 