@extends('mails/default')
@section('content')
<h2>Hello, {{$maildata['name']}}</h2>

<p>Your token is generated under Email-id {{$maildata['email']}} 
to reset your password. Please use this token to reset your password. {{$maildata['token']}}</p>

<p>For any query please contact us.</p>
@stop