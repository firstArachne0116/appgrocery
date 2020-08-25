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
            <form class="kt-form" method="POST" action="{{ route('report.showreport') }}">
                    @csrf
                <div class="kt-portlet__body">
                    @role('admin')
                    <div class="form-group" id="supermarket_selector">
                            <label>Select a supermarket for the coupon</label>
                            <select class="form-control" id="supermarket_id" name="supermarket_id" required>
                                    <option value="0" >Select SuperMarket</option>
                                    @foreach ($sm as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                    @endrole
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
     
        @if (isset($reports))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" style="padding:0px !important;"> 
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-brand flaticon2-line-chart"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            Reports
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">	
                    </div></div>
                    </div>
                    
                    <div class="kt-portlet__body">
                        <!--begin: Datatable -->
                        <table class="table hover table-checkable" id="sales_report_table">
                            <thead>
                                <tr>
                                    <th>Total Sales</th>
                                    <th>Total Revenue</th>
                                    <th>Total Products Sold</th>
                                    <th>Coupons used</th>
                                    <th>Total Shipping Amount</th>
                                    <th>Total Product revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($reports as $report)
                                    <tr>
                                        <td>{{$report->no_of_orders}}</td>
                                        <td>{{$report->total_revenue}}</td>
                                        <td>{{$report->number_of_items }}</td>
                                        <td>{{$report->total_coupons_used}}</td>
                                        <td>{{$report->total_shipping}}</td>
                                        <td>{{$report->mrp_total}}</td>
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

   $('#sales_report_table').DataTable({
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