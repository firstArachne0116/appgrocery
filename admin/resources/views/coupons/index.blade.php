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
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-line-chart"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Coupon List
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
                </div>	
            </div></div>
        </div>
            
        <div class="kt-portlet__body">
                <!--begin: Datatable -->
                <table class="table hover table-checkable" id="coupon_list_table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Coupon Code</th>
                            <th>Coupon Reward</th>
                            <th>Coupon Type</th>
                            <th>Status</th>
                            <th>Valid From</th>
                            <th>Valid Till</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($coupons as $coupon)                                
                        <tr>
                            <td>{{$coupon->name}}</td>
                            <td>{{$coupon->coupon_code}}</td>
                            <td>{{$coupon->coupon_rule}}</td>                            
                            <td>{{$coupon->supermarket_id == 0 ? "Grocery Hero Coupon" : "SuperMarket Coupon"}}</td>
                            <td>{{$coupon->is_enabled == 1 ? "Enabled" : "Disabled"}}</td>
                            <td>{{date('d-M-Y', strtotime($coupon->valid_from))}}</td>
                            <td>{{date('d-M-Y', strtotime($coupon->valid_till))}}</td>                            
                            <td>
                                <a class="btn btn-info" href="{{ route('coupon.show',$coupon->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('coupon.edit',$coupon->id) }}">Edit</a>
                                {!! Form::open(['method' => 'DELETE','route' => ['coupon.destroy', $coupon->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            
                                </td> 
                        </tr>
                        @endforeach    
                    </tbody>
                </table>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
<script>
    $(document).ready(function() {
        $('#coupon_list_table').DataTable();
    } );
</script>
@endsection
