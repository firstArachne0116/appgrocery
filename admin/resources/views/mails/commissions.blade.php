@extends('mails/default')
@section('content')
<h2>Hello,</h2>
<br/>
<p>A commission amount of {{$commission->commission_payable}} was paid by 
{{App\Supermarket::find($commission->supermarket_id)->name}} Supermarket  
for the Order No. {{$commission->order_id}}.
</p>
@stop