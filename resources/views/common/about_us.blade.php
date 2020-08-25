@extends('layouts.app')
@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb2">
      <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
        <li class="breadcrumb-item">About Us</li>
      </ol>
    </nav>
    <div class="row">
      <div class="about-us">
        <div class="container">
          <div class="our-story">
            <div class="row">
              <div class="col-lg-6 col-md-12">
                <div class="our-story_text">
                  <h1 class="title orange-underline">About Us</h1>
                  <p>APPGROCERY.COM is an APP DELIVERY SERVICES LLC company in U.A.E.
APPGROCERY.COM is U.A.E direct Market to Home grocery store. Right from fresh Fruits and Vegetables, Rice and Pulses, Spices and Seasonings to Packaged products, Beverages, Personal care products, Meats, Flowers Bouquets, Indoor Plants – we have it all. We will keep adding other categories soon!!
</p>
                  <p>Choose from a range of options in every category, exclusively handpicked to help you find the best quality available at reasonable prices. </p>
                  <p>We strive for on time delivery, and the best quality!</p>
                </div>
              </div>
              <div class="col-lg-6 col-md-12"> <img src="{{asset('images/about-img.jpg')}}" class="img-fluid" alt="" title=""> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <div class="why-choose">
    <h2>Why Choose Us</h2>
    <div class="clearfix"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-7">
          <div class="row">
            <div class="col-lg-6 col-md-6 mb-4">
              <div class="icon-detail"><img src="{{asset('images/dow_icon_1.png')}}" class="img-fluid" alt="no image">
                <h5>High Quality Service</h5>
                <p>APP GROCERY strives to provide high service quality to meet your expectations.</p>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-4">
              <div class="icon-detail"><img src="{{asset('images/dow_icon_2.png')}}" alt="no image">
                <h5>Flexibility</h5>
                <p>AT APP GROCERY , we are flexible and would do all necessary internal changes to respond effectively to the ever growing , changing customer and vendor requirements.</p>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-4">
              <div class="icon-detail"><img src="{{asset('images/dow_icon_3.png')}}" alt="">
                <h5>Reliable Consistent Supply</h5>
                <p>APP GROCERY is always looking to provide quality reliable consistent service for all orders to give the best customer experience of ordering with APPGROCERY.</p>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-4">
              <div class="icon-detail"><img src="{{asset('/images/dow_icon_4.png')}}" alt="">
                <h5>Customer Planning and Management</h5>
                <p>AT APP GROCERY, we try to understand our customer needs and work to deliver accordingly. CUSTOMERS are at the heart of what we do.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div><img src="{{asset('images/page-img/why-choose.jpg')}}"  title="" alt="" class="img-fluid" ></div>
        </div>
      </div>
    </div>
  </div>
  <br/>
@endsection