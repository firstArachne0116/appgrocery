@extends('layouts.app')
@section('content')
<div class="row">

    <div class="col-lg-12 margin-tb">

        <div class="pull-left">

            <h2>Lottery Management</h2>

        </div>

    </div>

</div>


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
                            Lottery List
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">	
            </div>		</div>
                </div>
            
                <div class="kt-portlet__body">
                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="lottery_product_list_table">
                            <thead>
                                <tr>
                                    <th>Lottery Name</th>
                                    <th>Description</th>
                                    <th>Lottery Reward</th>
                                    <th>Lottery Type</th>
                                    <th>Status</th> 
                                    <th>Valid From</th>
                                    <th>Valid Till</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
        
                            <tbody>
                                @foreach ($lotteries as $lottery)
                                <tr>
                                    <td>{{$lottery->name}}</td>
                                    <td>{{$lottery->description}}</td>
                                    <td>{{$lottery->lottery_rule}}</td>
                                    <td>{{$lottery->lottery_type == 1 ? "Supermarket Lottery" : "Grocery Hero"}}</td> 
                                    <td>{{$lottery->is_enabled == 1 ? "Enabled" : "Disabled"}}</td> 
                                    <td>{{date('d-M-Y', strtotime($lottery->valid_from))}}</td>
                                    <td>{{date('d-M-Y', strtotime($lottery->valid_till))}}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('lottery.show',$lottery->id) }}">Show</a>
                                        <a class="btn btn-primary" href="{{ route('lottery.edit',$lottery->id) }}">Edit</a>
                                        {!! Form::open(['method' => 'DELETE','route' => ['lottery.destroy', $lottery->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                 
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
