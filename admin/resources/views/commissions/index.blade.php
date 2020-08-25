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
            <form class="kt-form" method="POST" action="{{ route('commission.showreport') }}">
                    @csrf
                <div class="kt-portlet__body">
                    @role('admin')
                    <div class="form-group" id="supermarket_selector">
                            <label>Select a Supermarket for Commission Report</label>
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
     
        @if (isset($commissions))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"> 
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-brand flaticon2-line-chart"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                          Commissions Report
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    {{-- <div class="dropdown dropdown-inline">
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
                    </div> --}}
                </div>	
            </div>		</div>
                </div>
            
                
                    <div class="kt-portlet__body">
                        <!--begin: Datatable -->
        
                    <table class="table hover table-checkable " id="commissions_table">
                    <thead> <tr>
                      <th>Order ID</th>
                      <th>Supermarket Name</th>
                      <th>Order Total</th>
                      <th>Commission Percentage Charged per Order </th>
                      <th>Commision Payable</th>
                      <th>Status</th>
                      <th width="280px">Action</th>
                    </tr></thead>
                    <tbody>
                    @foreach ($commissions as $commission)
                      <tr>
                        <td>{{ $commission->order_id }}</td>
                        <td>{{ App\Supermarket::find($commission->supermarket_id)->name }}</td>
                        <td>{{ $commission->order_amount }}</td>
                        <td>{{ $commission->commission_charges }}</td>
                        <td>{{ $commission->commission_payable }}</td>
                        <td>{{ $commission->is_complete == 1 ? 'Paid' : 'Unpaid' }}</td>
                        <td>
                          <a class="btn btn-info" href="{{ route('commission.edit',$commission->id) }}">Update Payment Status</a>
                            {{-- <a class="btn btn-primary" href="{{ route('offer.edit',$offer->id) }}">Edit</a>                    
                            {!! Form::open(['method' => 'DELETE','route' => ['offer.destroy', $offer->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!} --}}
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                    </table>
                    <!--end: Datatable -->
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

   $('#commissions_table').DataTable({
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