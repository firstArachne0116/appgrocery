@extends('layouts.app')
@section('content')
<div class="container mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb2">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                <li class="breadcrumb-item"> Lottery Product List</li>
            </ol>
        </nav>
    </div>
    <div class="container mt_40 mb_40">
        <div class="row">
            <div class="col-lg-12 ">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link1 active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Your tickets</a>
                        <a class="nav-item nav-link1" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Winning tickets</a>
    
                    </div>
                </nav>
                <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active pd_40" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        @foreach ($boughtlotteries as $item)
                        <div class="item col-lg-3 col-md-3 mb-4 mb-4 list-group-item">
                                <div class="thumbnail card product">
                                    <div class="img-event">
                                            <?php $imgs = json_decode($item->image_path); $link1 = session('constant_url') . session('product_image_path'). '/'.$imgs[0];?>
                                        <a class="group list-group-image" href="#"> <img class="img-fluid" src="{{$link1}}" alt=""></a>
                                    </div>
                                    <div class="caption card-body pd_40 text-center width-50">
        
                                        
                                    <h3 class="product-type">{{$item->lotterynumber}}</h3>
                                        <h5 class="product-name">{{$item->{session('name')} }}</h5>
                                        <p class="text-center">{{$item->{session('description')} }}</p>
                                    </div>                                    
                                </div>
                            </div>
                        @endforeach
                    
                    </div>
                    <div class="tab-pane fade pd_40" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        @foreach ($boughtlotteries as $item)
                        @if ($item->lottery_winner == 1)
                        <div class="item col-lg-3 col-md-3 mb-4 mb-4 list-group-item">
                                <div class="thumbnail card product">
                                    <div class="img-event">
                                            <?php $imgs = json_decode($item->image_path); $link1 = session('constant_url') . session('product_image_path'). '/'.$imgs[0];?>
                                        <a class="group list-group-image" href="#"> <img class="img-fluid" src="{{$link1}}" alt=""></a>
                                    </div>
                                    <div class="caption card-body pd_40 text-center width-50">
        
                                            <h3 class="product-type">{{$item->lotterynumber}}</h3>
                                            <h5 class="product-name">{{$item->{session('name')} }}</h5>
                                            <p class="text-center">{{$item->{session('description')} }}</p>
                                    </div>                                    
                                </div>
                            </div> 
                        @endif
                        @endforeach
                        
                    </div>
    
                </div>
    
            </div>
        </div>
    </div>

@endsection