@extends('mails/default')
@section('content')
<h2>Hello, {{$user[0]->user_name}}</h2>
<br/>
<p>We delighted to inform you that your order from the account registered under Email-id 
    {{$user[0]->user_email}} is in {{$user[0]->order_status}} status.</p>

<p>Track your order below.</p>
<table>
    <thead>
        <th>Order Status</th>
        <th>Time</th>
        <th>Message</th>
    </thead>
    <tbody>
        @foreach ($data as $shipping)
        <tr>
            <td>{{App\Constant::find($shipping->shipping_status)->data}}</td>
            <td>{{$shipping->created_at}}</td>
            <td>{{isset($shipping->status_message) ? $shipping->status_message : "None"}}</td>
        </tr>   
        @endforeach
           
    </tbody>    
</table>
<p>Please contact teh App Grocery customer care for further details or questions.</p>
@stop