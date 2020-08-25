<div class="container-fluid py-5 grey">
  <div class="container">
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 address wow fadeInLeft">
      <p><img src="{{ asset('/images/logo.png') }}" alt="" title="" class="img-fluid"></p>
      <p>Address: Business Bay Metropolis Tower, Office #10-2202</p>
      <p>Phone: +971 600562622</p>
      <p>Email: <a href="#">hello@appgrocery.com</a></p>
      <ul class="social-2">
        <li><a href="https://www.facebook.com/appgrocery/" title="facebook"><i class="fa fa-facebook"></i></a></li>
        <li><a href="https://www.instagram.com/app_grocery/" title="instagram +"><i class="fa fa-instagram"></i></a></li>
        <li><a href="https://www.linkedin.com/company/app-grocery" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
      </ul>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 footer-link  wow fadeInLeft">
      <h3>Information</h3>
      <ul>
        <li><a href="{{route('common.aboutus')}}">About Us</a></li>
        <li><a href="{{route('common.terms')}}">Terms & Conditions</a></li>
        <li><a href="{{route('common.privacy')}}">Privacy Policy</a></li>
        <li><a href="{{route('common.contactus')}}">Contact Us</a></li>
        <li><a href="{{route('common.faq')}}">FAQ</a></li>
      </ul>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 footer-link  wow fadeInLeft">
      <h3>My Account</h3>
      <ul>
      <li><a href="{{route('user.index')}}">My Account</a></li>
        
      <li><a href="{{route('weeklylist.index')}}">Weekly List</a></li>         
      </ul>
    </div>

  </div>
</div>
</div>
<footer class="py-4 bg-dark">
  <div class="container copy-right">
    <div class="row">
    <div class="col-md-6 text-white"> Copyright © 2020 <a href="{{route('home')}}">App Delivery Services </a>- All Rights Reserved. </div>
      <div class="col-md-6 payment">
        <div class="pull-right"> <a href="#"><img src="{{ asset('/images/paypal.png') }}" alt="" title=""></a> <a href="#"><img src="{{ asset('/images/am.png') }}" alt="" title=""></a> <a href="#"><img src="{{ asset('/images/mr.png') }}" alt="" title=""></a> <a href="#"><img src="{{ asset('/images/visa.png') }}" alt="" title=""></a> </div>
      </div>
    </div>
  </div>
</footer>
