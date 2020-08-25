@extends('mails/default')
@section('content')
<h2>Hello, {{$data['name']}}</h2>

<p>We are delighted to inform you that your account registered under Email-id {{$data['email']}} 
has been selected to win the {{$data['lottery_name']}} from the lucky draw.</p>

<p>You will be contacted shortly by the Grocery Hero personel in order to receive your reward.</p>
@stop