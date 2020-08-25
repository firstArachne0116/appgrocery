@extends('layouts.app')
@section('content')
<div class="row" style="padding:0 25px;">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2></h2>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
@if ($message = Session::get('error'))
<div class="alert alert-danger">
  <p>{{ $message }}</p>
</div>
@endif
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"> 
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-line-chart"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Order List
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">	
                </div>		
            </div>
        </div>
        
        <div class="kt-portlet__body">
            <!--begin: Datatable -->
            <table class="table hover table-checkable" id="lottery_product_list_table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Consumer Name</th>
                        <th>Number of Items</th>
                        <th>Total Bill Amount</th>
                        <th>Billing Date</th>
                        <th>Purchased From</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($orders as $order)                        
                    <tr>
                        <td>{{$order->ordernumber}}</td>
                        <td>{{$order->user_name}}</td> 
                        <td>{{$order->no_of_items}}</td> 
                        <td>{{$order->total}}</td> 
                        <td>{{date('d-M-Y', strtotime($order->order_date))}}</td>
                        <td>{{$order->supermarket_name}}</td> 

                        <td>{{App\Constant::find($order->order_status)->data}}</td>
                        <td>
                            <a class="btn btn-info" href="{{ route('order.show',$order->order_id) }}">Show</a>
                        </td> 
                            @endforeach    
                    </tr>
                </tbody>

            </table>
            <!--end: Datatable -->
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#lottery_product_list_table').DataTable({
            dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });
    } );
</script>
@endsection
