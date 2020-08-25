@extends('mails/default')
@section('content')

<h2>Hello, {{$data['name']}}</h2>
<p>We are delighted to inform you that your account registered under Email-id {{$data['email']}} 
has got a draw ticket as you have ordered a Ticket item form APP GROCERY.</p>
<p>Your tiket is {{$data['lotterynumber']}} </p>
<p>You will be contacted by the APP GROCERY personel if you are a winner.</p>

@stop
