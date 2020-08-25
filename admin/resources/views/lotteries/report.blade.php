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
        @role('admin')
        <div class="kt-portlet">
            <!--begin::Form-->
            <form class="kt-form" method="POST" action="{{ route('lottery.showlotteryreport') }}">
                    @csrf
                <div class="kt-portlet__body">
                    <div class="form-group" id="supermarket_selector">
                        <label>Select a Lottery for reports</label>
                        <select class="form-control" id="lottery_id" name="lottery_id" required>
                                <option>Select a lottery</option>
                                @if (count($lotteries) > 0 )
                                    @foreach ($lotteries as $lottery)
                                    <option value="{{$lottery->id}}">{{$lottery->name}}</option>
                                    @endforeach  
                                @else
                                    <option>No valid lotteries to select from</option>
                                @endif
                               
                            </select>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            
                        </div>
                    </div>
                    
                </div>
            </form>    			
        </div>
        @endrole
        @if (count($lotteryreports) > 0)
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" style="padding:0px !important;"> 
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-brand flaticon2-line-chart"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            Lottery Report
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
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="lottery_report_list_table">
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Lottery Name</th>
                                        <th>Name of User</th>
                                        <th>User Mobile</th>
                                        <th>Lottery Ticket Number</th>
                                        <th>Lottery Reward</th>
                                        <th>Date of Purchase</th>
                                        <th>Valid Till</th>
                                    </tr>
                                </thead>
            
                                <tbody>
                                    @foreach ($lotteryreports as $lottery)
                                    <tr>
                                        <td>{{$lottery->order_id}}</td>
                                        <td>{{$lottery->lottery_name}}</td>
                                        <td>{{$lottery->user_name}}</td>
                                        <td>{{$lottery->user_mobile}}</td>
                                        <td>{{$lottery->lottery_ticket}}</td>
                                        <td>{{$lottery->lottery_reward}}</td>
                                        <td>{{date('d-M-Y', strtotime($lottery->purchased_at))}}</td>
                                        <td>{{date('d-M-Y', strtotime($lottery->lottery_validity))}}</td>
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
{{-- <script src="{{asset('js/datatable/dataTables.buttons.min.js')}}" type="text/javascript"></script> --}}



<script>

    $(document).ready(function() {
        $('#lottery_report_list_table').DataTable( {
            dom: 'Bfrtip',
            buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7 ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7 ]
                }
            },
        ]
    } );
    } );        
</script>    
@endsection