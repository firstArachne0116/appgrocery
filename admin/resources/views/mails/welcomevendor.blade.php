@extends('mails/default')
@section('content')
<h2>Welcome to the site {{$user['name']}}</h2>
<br/>
Your registered Email-id is {{$user['email']}}
<br/>
Your registered Password is 'pass123'
<br/>
Please reset this password by going to this link. 
@stop