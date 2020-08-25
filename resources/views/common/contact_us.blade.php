@extends('layouts.app')
@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb2">
        <li class="breadcrumb-item"><a href="home"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
        <li class="breadcrumb-item">Contact</li>
      </ol>
    </nav>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
<div class="contact-page contact-us">
  <div class="feature map">
   <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7221.084838270194!2d55.276903!3d25.184924!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f68319169f881%3A0x69266793dd38e629!2sThe%20Metropolis%20Tower%20-%20Business%20Bay%20-%20Dubai!5e0!3m2!1sen!2sae!4v1591698715348!5m2!1sen!2sae" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
  </div>
  <div class="container">
    <div class="row justify-content-center mb-4">
      <div class="col-md-10">
        <div class="contact-method">
          <div class="row">
            <div class="col-12 col-md-4">
              <div class="method-block"> <i class="fa fa-map-marker"></i>
                <div class="method-block_text">
                  <p><b>App Grocery</b></p>
                  <p>Office #10-2202<br /> Metropolis Tower<br />  Business Bay, Dubai, UAE </p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="method-block"><i class="fa fa-envelope"></i>
                <div class="method-block_text">
                  <p> <span>Phone : </span>+971 600562622</p>
                  <p><span>Mail : </span><a href="mailto:hello@appgrocery.com">hello@appgrocery.com</a></p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="method-block"><i class="fa fa-clock-o"></i>
                <div class="method-block_text">
                  <p> <span>Week Days : </span>08:00 – 19:00</p>
                  <p><span>Friday : </span> <span class="text-danger">Closed</span> </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="leave-message">
          <h1 class="title">Leave Message</h1>
          <p>Our staff will call back later and answer your questions.</p>
          <div class="clearfix"><br/></div>
          @if ($message = Session::get('success'))
          <div class="alert alert-success">
            <p>{{ $message }}</p>
          </div>
          @endif
          @if (count($errors) > 0)
            <div class="alert alert-danger">
              <strong>Whoops!</strong> There were some problems with your input.<br><br>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        <form method="POST" action="{{route('common.contactform')}}">
            @csrf
            <div class="row">
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <input class="form-control" type="text" name="name" placeholder="Name" required>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <input class="form-control" type="email" name="email" placeholder="Email" required>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <textarea class="form-control" name="message" cols="30" rows="10" placeholder="Your message" required></textarea>
                </div>
              </div>
              <div class="col-12 text-center">
                <div class="form-group">
                  <input type="submit" class="btn add-to-cart2" value="Submit">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

    
@endsection