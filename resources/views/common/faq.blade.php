@extends('layouts.app')
@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb2">
      <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
        <li class="breadcrumb-item">FAQ</li>
      </ol>
    </nav>
    <div class="row">
      <div class="col-lg-12 mt-2 mb-5">
        <div id="accordion" role="tablist" class="faq">
          <div class="card">
            <div class="card-header" role="tab" id="headingOne"> <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <h5 class="mb-0">How do I register?</h5>
              </a> </div>
            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
                <p>You can register by clicking on the "Sign Up" link at the top right corner of the homepage. Please provide the information in the form that appears. You can review the terms and conditions, provide your payment mode details and submit the registration information</p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="headingTwo"> <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <h5 class="mb-0">Are there any charges for registration?</h5>
              </a> </div>
            <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="card-body">
                <p>No. Charges , APP GROCERY are absolutely free.</p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="headingThree"> <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              <h5 class="mb-0">Do I have to necessarily register to shop on APP GROCERY?</h5>
              </a> </div>
            <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
              <div class="card-body">
                <p>You can surf and add products to the cart without registration but only registered shoppers will be able to checkout and place orders. Registered members have to be logged in at the time of checking out the cart, they will be prompted to do so if they are not logged in.</p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="heading4"> <a class="collapsed" data-toggle="collapse" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
              <h5 class="mb-0">Can I have multiple registrations?</h5>
              </a> </div>
            <div id="collapse4" class="collapse" role="tabpanel" aria-labelledby="heading4" data-parent="#accordion">
              <div class="card-body">
                <p>Each email address and contact phone number can only be associated with one APP GROCERY account.</p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="heading4"> <a class="collapsed" data-toggle="collapse" href="#collapse9" aria-expanded="false" aria-controls="collapse4">
              <h5 class="mb-0">Can I have multiple accounts with same mobile number and email id?</h5>
              </a> </div>
            <div id="collapse9" class="collapse" role="tabpanel" aria-labelledby="heading4" data-parent="#accordion">
              <div class="card-body">
                <p>Each email address and phone number can be associated with one APP GROCERY account only.</p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="heading4"> <a class="collapsed" data-toggle="collapse" href="#collapse8" aria-expanded="false" aria-controls="collapse4">
              <h5 class="mb-0">Can I have multiple accounts for members in my family with different mobile number and email address but same or common delivery address?</h5>
              </a> </div>
            <div id="collapse8" class="collapse" role="tabpanel" aria-labelledby="heading4" data-parent="#accordion">
              <div class="card-body">
                <p>Yes, we do understand the importance of time and the toil involved in shopping groceries. Up to three members in a family can have the same address provided the email address and phone number associated with the accounts are unique.</p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="heading5"> <a class="collapsed" data-toggle="collapse" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
              <h5 class="mb-0">Can I add more than one delivery address in an account?</h5>
              </a> </div>
            <div id="collapse5" class="collapse" role="tabpanel" aria-labelledby="heading5" data-parent="#accordion">
              <div class="card-body">
                <p>Yes, you can add multiple delivery addresses in your APP GROCERY account. However, remember that all items placed in a single order can only be delivered to one address. If you want different products delivered to different address you need to place them as separate orders.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection