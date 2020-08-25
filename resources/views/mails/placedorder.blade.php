@extends('mails/default')
@section('content')

<h2>Hello, {{$data['name']}}</h2>

<p>We are delighted to inform you that your order has been placed under Email-id {{$data['email']}} 
Your order number is : {{$data['ordernumber']}}</p>

<p>You will be contacted shortly by the App Grocery Team in order to receive your order.</p>

@stop
