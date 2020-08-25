@extends('mails/default')
@section('content')
<h2>Hello, {{$data['email']}}</h2>
<br/>
<p>This is your otp which you can verify your account. {{$data['email_otp']}} </p>
<br/> 
<p>You can directly access the App Grocery support for any query.</p>
@stop