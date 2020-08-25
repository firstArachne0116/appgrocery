@extends('layouts.app')
@section('content')
<style type="text/css">
  .split_input{display:table;border-spacing:0}
  .split_input_item{display:table-cell;border:1px solid #9e9ea6}
  .split_input_item:not(:first-child){border-left:none}
  .split_input_item:first-child{border-top-left-radius:5px;border-bottom-left-radius:5px}
  .split_input_item:last-child{border-top-right-radius:5px;border-bottom-right-radius:5px}
  .split_input_item.focused{border:1px double #2780f8;box-shadow:0 0 7px rgba(39,128,248,.3)}
  .split_input_item input{height:3.5rem;text-align:center;font-size:1.5rem;border:none;background:0 0;box-shadow:none;width: 80px;}
  .split_input_item input:active,.split_input_item input:focus,.split_input_item input:hover{box-shadow:none}
  

.fs_split{position:absolute;overflow:hidden;width:20%;top:0;bottom:0;left:0;right:0;background-color:#e8e8e8;-webkit-transition:background-color .2s ease-out 0s;-moz-transition:background-color .2s ease-out 0s;transition:background-color .2s ease-out 0s}
.fs_split h1{font-size:2.625rem;line-height:3rem;font-weight:300;margin-bottom:2rem}
.fs_split label{margin-bottom:.5rem}
.fs_split .desc{font-size:1.25rem;color:#9e9ea6;margin-bottom:2rem}
.fs_split .email{color:#555459;font-weight:700}
.fs_split .header_error_message{margin:0 11%;padding:1rem 2rem;background:#fff1e1;border:none;border-left:.5rem solid #ffa940;border-radius:.25rem}
.fs_split .header_error_message h3{margin:0}
.fs_split .error_message{display:none;font-weight:700;color:#ffa940}
.fs_split .error input,.fs_split .error textarea{border:1px solid #ffa940;background:#fff1e1}
.fs_split .error input:focus,.fs_split .error textarea:focus{border-color:#fff1e1;box-shadow:0 0 7px rgba(255,185,100,.15)}
.fs_split .error .error_message{display:inline}
.confirmation_code_span_cell{display:table-cell;font-weight:700;font-size:2rem;text-align:center;padding:0 .5rem;width:2rem}
.confirmation_code_state_message{position:absolute;width:100%;opacity:0;-webkit-transition:opacity .2s;-moz-transition:opacity .2s;transition:opacity .2s}
.confirmation_code_state_message.error,.confirmation_code_state_message.processing,.confirmation_code_state_message.ratelimited{font-size:1.25rem;font-weight:700;line-height:2rem}
.confirmation_code_state_message.processing{color:#3aa3e3}
.confirmation_code_state_message.error,.confirmation_code_state_message.ratelimited{color:#ffa940}
.confirmation_code_state_message ts-icon:before{font-size:2.5rem}
.confirmation_code_state_message svg.ts_icon_spinner{height:2rem;width:2rem}
.confirmation_code_checker{position:relative;height:12rem;text-align:center}
.confirmation_code_checker[data-state=unchecked] .confirmation_code_state_message.unchecked,.confirmation_code_checker[data-state=error] .confirmation_code_state_message.error,.confirmation_code_checker[data-state=processing] .confirmation_code_state_message.processing,.confirmation_code_checker[data-state=ratelimited] .confirmation_code_state_message.ratelimited{opacity:1}
.large_bottom_margin {
    margin-bottom: 2rem !important;
}
.mb_50{
  margin-bottom: 50px;
}
.otp{
  background: #fbfbfb;
  margin:20px 0px;
}
</style>
<div class="container">
  <?php //echo '<pre/>'; print_r($sentdata); ?>
    <div class="row justify-content-center">       
    <div class="col-lg-6 col-md-6 otp">
        @if (session('otpstatus'))
        <div class="alert alert-danger">
            {{ session('otpstatus') }}
        </div>
        @endif
    <div class="" ><!-- col -->
    <h2><h1>Check your @if($sentdata[0] == 'email_case') email! @endif @if($sentdata[0] == 'mobile_case') Mobile! @endif</h1></h2>
        <p class="desc">We’ve sent a six-digit confirmation code to 
          @if($sentdata[0] == 'email_case')               
              <strong>{{ Auth::user()->email }}</strong> 
          @endif
          @if($sentdata[0] == 'mobile_case')            
          <strong> {{ Auth::user()->mobile }} </strong>
          @endif
          Enter it below to confirm your @if($sentdata[0] == 'email_case') email address. @endif @if($sentdata[0] == 'mobile_case') mobile number. @endif</p>
       <br>
       <label><span class="normal">Your </span>confirmation code</label>
      <form name="otp-form" id="otp-form" action="{{ route('verifyotp') }}" method="post"> 
        @csrf  
       <div class="confirmation_code split_input large_bottom_margin" data-multi-input-code="true">
          <div class="confirmation_code_group">
          <div class="split_input_item input_wrapper"><input type="text" class="inline_input" name="otp1"  maxlength="1"></div>
          <div class="split_input_item input_wrapper"><input type="text" class="inline_input" name="otp2" maxlength="1"></div>
          <div class="split_input_item input_wrapper"><input type="text" class="inline_input" name="otp3" maxlength="1"></div>
        </div>

        <div class="confirmation_code_span_cell">—</div>

        <div class="confirmation_code_group">
          <div class="split_input_item input_wrapper"><input type="text" class="inline_input" name="otp4" maxlength="1"></div>
          <div class="split_input_item input_wrapper"><input type="text" class="inline_input" name="otp5" maxlength="1"></div>
          <div class="split_input_item input_wrapper"><input type="text" class="inline_input" name="otp6" maxlength="1"></div>
        </div>

          <input type="hidden" name="otp_type" id="otp_type" value="{{ $sentdata[0] }}" />
        
      </div>
        <div class="text-center mb_50">
            <button type="submit" class="btn btn-primary">Submit</button>
            <br />
            <div class="clearfix"></div>
            <div class="clearfix"></div>
        </div>
      </form>
    </div>
            </div><!-- endof col -->
    </div>
</div>

</div>
</div>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
@endsection