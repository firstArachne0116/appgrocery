@extends('mails/default')
@section('content')

<h2>Hello, {{$data['name']}}</h2>
<p>This is to inform you that your order has been cancelled under Email-id {{$data['email']}} 
Your order number is : {{$data['order']['ordernumber']}}</p>
<p>You can contact us for any queries.</p>

@stop
