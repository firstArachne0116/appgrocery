@extends('layouts.app')
@section('content')
<div class="row" style="padding:0px 25px 0px 0px;">
    <div class="col-md-12 margin-tb">
        <div class="pull-left">
            <h2></h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('supermarket.create') }}"> Create Supermarket</a>
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
                        SuperMarket List
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">	
        </div>		</div>
            </div>
        
            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                <table class="table hover table-checkable" id="supermarket_index_table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Arabic Name</th>
                            <th>City</th>
                            <th>Area</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Actions</th>                                                                
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($sm as $item)
                        <tr>
                            
                                <td>{{$item->id}}</td>  
                                <td>{{$item->name}}</td>  
                                <td>{{$item->name_arabic}}</td>  
                                <td>{{$item->city?$item->city->name:''}}</td>  
                                <td>{{$item->area?$item->area->name:''}}</td>  
                                <td>{{$item->address}}</td>  
                                <td>{{($item->is_enabled == 1) ? 'Enabled' : 'Disabled'}} </td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('supermarket.show',$item->id) }}">Show</a>
                                    <a class="btn btn-primary" href="{{ route('supermarket.edit',$item->id) }}">Edit</a>
                                        {!! Form::open(['method' => 'DELETE','route' => ['supermarket.destroy', $item->id],'style'=>'display:inline']) !!}
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
      $('#supermarket_index_table').DataTable({
        "pageLength": 5,
            dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6 ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6 ]
                }
            },
        ]
    
        });
  } );
</script>
@endsection