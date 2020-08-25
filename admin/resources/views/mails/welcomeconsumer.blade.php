@extends('mails/default')
@section('content')
<h2>Welcome to the site {{$user['name']}}</h2>
<br/>
Your registered Email-id is {{$user['email']}}
<br/>
Your registered Password is {{$user['password']}}
<br/>
Please reset this password by going to this link. 
@stop