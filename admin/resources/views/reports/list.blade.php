@extends('layouts.app')
@section('content')
<div class="row" style="padding:0px 25px 0px 0px;">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2></h2>
        </div>    
    </div>
</div>
<div class="clearfix"><br/></div>
    
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"> 
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        
        <div class="kt-portlet">
            <!--begin::Form-->
            <form class="kt-form" method="POST" action="{{ route('report.showlistreport') }}">
                    @csrf
                <div class="kt-portlet__body">
                    <div class="form-group" id="supermarket_selector">
                            <label>Select a supermarket for reports</label>
                            <select class="form-control" id="supermarket_id" name="supermarket_id" required>
                                    <option value="0" >Select SuperMarket</option>
                                    @foreach ($sm as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                    </div>
                    <div class="form-group">
                        <label>Select a type of report</label>
                        <select class="form-control" id="report_type_selector" name="report_type" required>
                                <option value="1" >Weekly</option>
                                <option value="2" >Monthly</option>
                                <option value="3" >Custom</option>
                            </select>
                    </div>
                    <div class="form-group" id="date_from_selector" style="display: none;">
                        <label>Select Date From</label>
                        <input class="form-control" name="date_from" max="<?php echo date("Y-m-d"); ?>" type="date">
                    </div>
                    <div class="form-group" id="date_to_selector" style="display: none;">
                        <label>Select Date To</label>
                        <input class="form-control" max="<?php echo date("Y-m-d"); ?>" name="date_to" type="date">
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </div>
                    
                </div>
            </form>    			
        </div>
     
        @if (isset($orders))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" style="padding:0px !important;"> 
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-brand flaticon2-line-chart"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            Orders
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                        <div class="dropdown dropdown-inline">
                            <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="la la-download"></i> Export  	
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="kt-nav">
                                    <li class="kt-nav__section kt-nav__section--first">
                                        <span class="kt-nav__section-text">Choose an option</span>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon la la-print"></i>
                                            <span class="kt-nav__link-text">Print</span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon la la-copy"></i>
                                            <span class="kt-nav__link-text">Copy</span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                            <span class="kt-nav__link-text">Excel</span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon la la-file-text-o"></i>
                                            <span class="kt-nav__link-text">CSV</span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                            <span class="kt-nav__link-text">PDF</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        &nbsp;
                        </div>	
                    </div></div>
                    </div>
                    
                    <div class="kt-portlet__body">
                        <!--begin: Datatable -->
                        <table class="table hover table-checkable" id="sales_list_table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Consumer Name</th>
                                        <th>Total MRP</th>
                                        <th>Total Discount</th>
                                        <th>Total Coupon Discount</th>
                                        <th>Total Delivery Amount</th>
                                        <th>Total Bill</th>
                                        <th>Purchased On</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                
                                <tbody>
                                    @foreach ($orders as $order)                        
                                    <tr>
                                        <td>{{$order->order_id}}</td>
                                        <td>{{$order->consumer_name}}</td> 
                                        <td>{{$order->billed_amount}}</td> 
                                        <td>{{$order->mrp_discount}}</td> 
                                        <td>{{$order->total_coupon_discount}}</td> 
                                        <td>{{$order->delivery_charges}}</td> 
                                        <td>{{$order->total_amount}}</td> 
                                        <td>{{date('d-M-Y', strtotime($order->purchased_on))}}</td>
                                        <td>{{$order->order_status}}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ route('order.show',$order->order_id) }}">Show</a>
                                        </td> 
                                            @endforeach    
                                    </tr>
                                </tbody>
                
                            </table>
                    </div>
                </div>
            </div>            
        @endif
            <!--end::Portlet-->
    </div>
    </div>	
</div>
<script>
    $(document).ready(function () {
        $("#report_type_selector").change(function (e) { 
        var report_type_selector = $("#report_type_selector option:selected").val();

        if (report_type_selector == 3){
            $("#date_from_selector").show();
            $("#date_to_selector").show();
        }else {
            $("#date_from_selector").hide();
            $("#date_to_selector").hide(); 
        }
       
   });

   $('#sales_list_table').DataTable({
            dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });
    });
</script>   
@endsection