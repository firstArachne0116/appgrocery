@extends('layouts.app')
@section('content')

<div class="row" style="padding:0px 25px 0px 0px;">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2></h2>
        </div>
        <div class="pull-right">
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
                      Consumer
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
	
        </div>		</div>
            </div>
        
            <div class="kt-portlet__body">
                <!--begin: Datatable -->

            <table class="table hover table-checkable " id="user_index_table">
            <thead> <tr>
              <th>User ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phones</th>
              <th>Referal Code</th>
              <th>Credits</th>
              <th>cash Credits</th>
              <th>Status</th>
              <th width="280px">Action</th>
            </tr></thead>
            <tbody>
            <?php $cuserrole = Auth::user()->getRoleNames(); ?>
            @foreach ($data as $key => $user)
              <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                <td>{{ $user->user_refer_code }}</td>
                <td>{{ $user->credits }}</td>
                <td>{{ $user->cash_credits }}</td>
                <td>{{ $user->is_enabled == 1 ? "Enabled" : "Disabled" }}</td>
                <td>
                  <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>                    
                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
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
      $('#user_index_table').DataTable({
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
{!! $data->render() !!}
@endsection