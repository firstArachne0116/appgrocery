@extends("layouts.app")
@section("content")
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb2 breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo url('/'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="breadcrumb-item">Near By Supermarkets</li>
    </ol>
  </nav>
  <div class="clearfix"></div>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="row">
        <div class="col-12">        
          <div class="clearfix"></div>
          <div id="products" class="row view-group">            
            @if($supermarkets['data'])
            @foreach($supermarkets['data'] as $market)
            <?php $imgs = json_decode($market['image_path']); $link = session('constant_url') . session('supermarket_image_path'). '/'.$imgs[0]; ?>    
            <div class="item col-lg-3 col-md-3  mb-4">
              <div class="thumbnail card product1">
                <div class="img-event1"> <a class="group list-group-image" href="{{ route('categories', ['sid' => $market['id']]) }}"> <img class="img-fluid" src="<?php echo $link; ?>" alt=""></a> </div>
                <div class="caption card-body">
                  <h5 class="product-type">{{ $market[session('name')] }}</h5>
                  <h3 class="product-name">{{ $market['address'] }}</h3>                 
                </div>
              </div>
            </div>
            @endforeach
            @endif
           </div>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="col text-center">
    <nav aria-label="Page navigation example">
      <ul class="pagination pagination-template d-flex justify-content-center float-none">
        {{-- <li class="page-item"><a href="#" class="page-link"> <i class="fa fa-angle-left"></i></a></li>
        <li class="page-item"><a href="#" class="page-link active">1</a></li>
        <li class="page-item"><a href="#" class="page-link">2</a></li>
        <li class="page-item"><a href="#" class="page-link">3</a></li>
        <li class="page-item"><a href="#" class="page-link"> <i class="fa fa-angle-right"></i></a></li> --}}
        {{-- @if ($supermarkets['per_page']%$supermarkets['total'] > 0 )
        <li class="page-item"><a href="#" class="page-link"> <i class="fa fa-angle-left"></i></a></li>
        <li class="page-item"><a href="{{$supermarkets['first_page_url']}}" class="page-link active">1</a></li>
        <li class="page-item"><a href="#" class="page-link"> <i class="fa fa-angle-right"></i></a></li>   
        @endif --}}
      </ul>
    </nav>
  </div>
</div>
<div class="clearfix"></div>
@endsection