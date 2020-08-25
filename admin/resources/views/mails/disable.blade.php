@extends('mails/default')
@section('content')
<h2>Hello, {{$user['name']}}</h2>

<p>We regret to inform you that your account registered under Email-id {{$user['email']}} has been disabled.</p>

<p>You will not be able to login into your account</p>
<p>Please Contact Grocery Hero customer care for further details or questions.</p>
@stop