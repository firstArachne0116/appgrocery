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
            <form class="kt-form" method="POST" action="{{ route('shipping.showshipping') }}">
                    @csrf
                <div class="kt-portlet__body">
                    <div class="form-group" id="supermarket_selector">
                            <label>Select a supermarket for Shipping Details</label>
                            <select class="form-control" id="supermarket_id" name="supermarket_id" required>
                                    <option value="0" >Select SuperMarket</option>
                                    @foreach ($sm as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
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
     
        @if (isset($shipping))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid pd_50">
                <div class="kt-portlet kt-portlet--mobile">
            
                    <div class="kt-portlet__body">
                        <ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-success" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tabs_2_1" role="tab" aria-selected="true">Placed Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tabs_2_2" role="tab" aria-selected="false">In Process</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tabs_2_3" role="tab" aria-selected="false">Transit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tabs_2_4" role="tab" aria-selected="false">Delivered</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="kt_tabs_2_1" role="tabpanel">
            
                                <div class="kt-portlet__head kt-portlet__head--lg">
                                    <div class="kt-portlet__head-label">
                                        <span class="kt-portlet__head-icon">
                                            <i class="kt-font-brand flaticon2-line-chart"></i>
                                        </span>
                                        <h3 class="kt-portlet__head-title">
                                          Orders placed
                                        </h3>
                                    </div>
                                    <div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">
                                                <div class="dropdown dropdown-inline">
    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="kt-portlet__body">
                                    <!--begin: Datatable -->
            
                                    <table class="table hover table-checkable " id="user_index_table">
                                        <thead>
                                            <tr>
                                                <th>Shiping ID</th>
                                                <th>Order ID</th>
                                                <th>Consumer Name</th>
                                                <th>Shipping Address</th>
                                                <th>Status Message</th>
                                                <th width="280px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @foreach ($placed_orders as $item)
												<?php 
												$consumer=App\User::find($item->consumer_id);
												$name="";
												if(!empty($consumer))
												{
													$name=$consumer->name;
												}
												?>
                                                  <tr>
                                                    <td>{{ $item->shipping_id }}</td>
                                                    <td>{{ $item->order_id }}</td>
                                                    <td>{{ $name}}</td>
                                                    <td>{{ App\Address::formatAddress($item->address_id)}}</td>
                                                    <td>{{ $item->status_message }}</td>
                                                 
                                                    <td>
                                                            <a class="btn btn-info" href="{{ route('shipping.edit',$item->shipping_history_id) }}">Update</a>
                                                            {{-- <a class="btn btn-info" href="{{ route('shipping.show',$item->shipping_history_id) }}">Update</a> --}}
    
                                                            
    
                                                     
                                                    </td>
                                                  </tr>
                                                @endforeach
                                                </tbody>
            
                                    </table>
                                    <!--end: Datatable -->
                                </div>
            
                            </div>
                            <div class="tab-pane" id="kt_tabs_2_2" role="tabpanel">
                                
                                    <div class="kt-portlet__head kt-portlet__head--lg">
                                            <div class="kt-portlet__head-label">
                                                <span class="kt-portlet__head-icon">
                                                    <i class="kt-font-brand flaticon2-line-chart"></i>
                                                </span>
                                                <h3 class="kt-portlet__head-title">
                                                  Orders in process
                                                </h3>
                                            </div>
                                            <div class="kt-portlet__head-toolbar">
                                                <div class="kt-portlet__head-wrapper">
                                                    <div class="kt-portlet__head-actions">
                                                        <div class="dropdown dropdown-inline">
            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    
                                        <div class="kt-portlet__body">
                                            <!--begin: Datatable -->
                    
                                            <table class="table hover table-checkable " id="user_index_table1">
                                                <thead>
                                                    <tr>
                                                        <th>Shiping ID</th>
                                                        <th>Order ID</th>
                                                        <th>Consumer Name</th>
                                                        <th>Shipping Address</th>
                                                        <th>Order/Delivery Status</th>
                                                        <th width="280px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        @foreach ($in_progress_orders as $item)
																<?php 
																$consumer=App\User::find($item->consumer_id);
																$name="";
																if(!empty($consumer))
																{
																$name=$consumer->name;
																}
																?>
                                                          <tr>
                                                            <td>{{ $item->shipping_id }}</td>
                                                            <td>{{ $item->order_id }}</td>
                                                            <td>{{ $name}}</td>
                                                            <td>{{ App\Address::formatAddress($item->address_id)}}</td>
                                                            <td>{{ $item->status_message }}</td>
                                                            <td>
                                                                    <a class="btn btn-info" href="{{ route('shipping.edit',$item->shipping_history_id) }}">Show</a>
                                                                    
    
            
                                                             
                                                            </td>
                                                          </tr>
                                                        @endforeach
                                                    </tbody>
                    
                                            </table>
                                            <!--end: Datatable -->
                                        </div>
                            </div>
                            <div class="tab-pane" id="kt_tabs_2_3" role="tabpanel">
                                
                                    <div class="kt-portlet__head kt-portlet__head--lg">
                                            <div class="kt-portlet__head-label">
                                                <span class="kt-portlet__head-icon">
                                                    <i class="kt-font-brand flaticon2-line-chart"></i>
                                                </span>
                                                <h3 class="kt-portlet__head-title">
                                                Orders in transit
                                                </h3>
                                            </div>
                                            <div class="kt-portlet__head-toolbar">
                                                <div class="kt-portlet__head-wrapper">
                                                    <div class="kt-portlet__head-actions">
                                                        <div class="dropdown dropdown-inline">
            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    
                                        <div class="kt-portlet__body">
                                            <!--begin: Datatable -->
                    
                                            <table class="table hover table-checkable " id="user_index_table2">
                                                <thead>
                                                    <tr>
                                                        <th>Shiping ID</th>
                                                        <th>Order ID</th>
                                                        <th>Consumer Name</th>
                                                        <th>Shipping Address</th>
                                                        <th>Order/Delivery Status</th>
                                                        <th width="280px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        @foreach ($transit_orders as $item)
														<?php 
																$consumer=App\User::find($item->consumer_id);
																$name="";
																if(!empty($consumer))
																{
																$name=$consumer->name;
																}
																?>
                                                          <tr>
                                                            <td>{{ $item->shipping_id }}</td>
                                                            <td>{{ $item->order_id }}</td>
                                                            <td>{{ $name}}</td>
                                                            <td>{{ App\Address::formatAddress($item->address_id)}}</td>
                                                            <td>{{ $item->status_message }}</td>
                                                         
                                                            <td>
                                                                    <a class="btn btn-info" href="{{ route('shipping.edit',$item->shipping_history_id) }}">Show</a>
            
            
                                                             
                                                            </td>
                                                          </tr>
                                                        @endforeach
                                                    </tbody>
                    
                                            </table>
                                            <!--end: Datatable -->
                                        </div>
                            </div>
                            <div class="tab-pane" id="kt_tabs_2_4" role="tabpanel">
                                
                                    <div class="kt-portlet__head kt-portlet__head--lg">
                                            <div class="kt-portlet__head-label">
                                                <span class="kt-portlet__head-icon">
                                                    <i class="kt-font-brand flaticon2-line-chart"></i>
                                                </span>
                                                <h3 class="kt-portlet__head-title">
                                                  Delivered Orders
                                                </h3>
                                            </div>
                                            <div class="kt-portlet__head-toolbar">
                                                <div class="kt-portlet__head-wrapper">
                                                    <div class="kt-portlet__head-actions">
                                                        <div class="dropdown dropdown-inline">
            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    
                                        <div class="kt-portlet__body">
                                            <!--begin: Datatable -->
                    
                                            <table class="table hover table-checkable " id="user_index_table3">
                                                <thead>
                                                    <tr>
                                                        <th>Shiping ID</th>
                                                        <th>Order ID</th>
                                                        <th>Consumer Name</th>
                                                        <th>Shipping Address</th>
                                                        <th>Order/Delivery Status</th>
                                                        <th width="280px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        @foreach ($delivered_orders as $item)
														  <?php 
																$consumer=App\User::find($item->consumer_id);
																$name="";
																if(!empty($consumer))
																{
																$name=$consumer->name;
																}
																?>
                                                          <tr>
                                                            <td>{{ $item->shipping_id }}</td>
                                                            <td>{{ $item->order_id }}</td>
                                                            <td>{{ $name}}</td>
                                                            <td>{{ App\Address::formatAddress($item->address_id) }}</td>
                                                            <td>{{ $item->status_message }}</td>
                                                         
                                                            <td>
                                                                    <a class="btn btn-info" href="{{ route('shipping.edit',$item->shipping_history_id) }}">Show</a>
    
                                                             
                                                            </td>
                                                          </tr>
                                                        @endforeach
                                                    </tbody>
                    
                                            </table>
                                            <!--end: Datatable -->
                                        </div>
                            </div>
                        </div>
                    </div>
            
                </div>
            </div> 
        @endif
            <!--end::Portlet-->
    </div>
    </div>	
</div>
<script>
        $(document).ready(function() {
          $('#user_index_table').DataTable();
          $('#user_index_table1').DataTable();
          $('#user_index_table2').DataTable();
          $('#user_index_table3').DataTable();
      } );
    </script> 
@endsection