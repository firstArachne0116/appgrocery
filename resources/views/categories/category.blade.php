@extends('layouts.app')
@section('content')
<div class="container">
  <nav aria-label="breadcrumb" class="bread-boder">
    <div class="row">
      <div class="col-lg-8 col-md-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}" >Home</a></li>
          <li class="breadcrumb-item"><a href="{{route('categories',['sid' => $marketid])}}" >Categories</a></li>
          <li class="breadcrumb-item">@if($categories) {{App\Category::find($categories[0]['parentid'])->{session('name')} }} @endif</li>
        </ol>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
  </nav>
  <div class="row">  
    <div class="col-lg-12 col-md-12">
      <div class="row">
        <div class="col-12">
          <div class="right-heading">
            <div class="row">
              <div class="col-md-4 col-4">
                <h3> Sub Category List</h3>
              </div>
              <div class="col-md-8 col-8">
                {{-- <div class="product-filter">
                  <div class="view-method"> <a href="#" id="grid"><i class="fa fa-th-large"></i></a> <a href="#" id="list"><i class="fa fa-list"></i></a> </div>
                </div> --}}
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div id="products" class="row view-group">            
            @if($categories)
            @foreach($categories as $catk => $catv)
            <?php $imgs = json_decode($catv['image_path']); $link = session('constant_url') . session('category_image_path'). '/'.$imgs[0]; ?>         
              <div class="item col-lg-3 col-md-3 mb-4 mb-4">
                <div class="thumbnail card product">
                  <div class="img-event"> <a class="group list-group-image" href="{{ route('products', ['sid' => $marketid, 'cid' => $cid, 'scid' => $catv['id']])}}"><img class="img-fluid" src="<?php echo $link; ?>" alt=""></a> </div>
                  <div class="caption card-body">                  
                    <h3 class="product-type1">UP to 60% Off</h3>
                      <h5 class="product-name"> {{ $catv[session('name')] }} </h5>
                      <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p> -->
                  </div>
                </div>
              </div>
            @endforeach
            @endif   
          </div>         

            <div class="clearfix"></div><br/>
            <!-- Pagination -->
            {{-- <div class="text-center col">
              <nav aria-label="Page navigation example">
                <ul class="pagination pagination-template d-flex justify-content-center float-none">
                  <li class="page-item"><a href="#" class="page-link"> <i class="fa fa-angle-left"></i></a></li>
                  <li class="page-item"><a href="#" class="page-link active">1</a></li>
                  <li class="page-item"><a href="#" class="page-link">2</a></li>
                  <li class="page-item"><a href="#" class="page-link">3</a></li>
                  <li class="page-item"><a href="#" class="page-link"> <i class="fa fa-angle-right"></i></a></li>
                </ul>
              </nav>
            </div> --}}
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
@endsection