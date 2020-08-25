@extends('layouts.app')
<?php
$city=App\City::find($supermarket->city_id);
?>

@section('content')
<div class="kt-container kt-container--fluid kt-margin-b-100">
<div class="col-md-12">
<div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample1">
    <div class="card">
        <div class="card-header" id="headingOne">
            <div class="card-title" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
                Business Details
            </div>
        </div>
        
        <div id="collapseOne1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample1" style="">
        <div class="card-body">
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
            <div class="col-md-3">
                <label> Name </label>
                <br /><p>{{ $supermarket->name }}</p>                
            </div>
            <div class="col-md-3">
                <label> Arabic Name </label>
                <br /><p>{{ $supermarket->name_arabic }}</p>                
            </div>
            <div class="col-md-3">
                <label> Latitude </label>
                <br /><p>{{ $supermarket->latitude }}</p>                
            </div>
            <div class="col-md-3">
                <label> Longitude </label>
                <br /><p>{{ $supermarket->longitude }}</p>              
            </div>
            <div class="col-md-3">
                <label> Delivery Amount </label>
                <br /><p>{{ $supermarket->freedeliveryamount }}</p>             
            </div>
            <div class="col-md-3">
                <label> Fixed Delivery Amount </label>
                <br /><p>{{ $supermarket->fixeddeliveryamount }}</p>             
            </div>
            <div class="col-md-3">
                <label> Fixed Service Amount </label>
                <br /><p>{{ $supermarket->fixedserviceamount }}</p>             
            </div>
            <div class="col-md-3">
                <label> Commision Precentage </label>
                <br /><p>{{ $supermarket->commission_percentage }}</p>             
            </div>
            <div class="col-md-3">
                <label> Cash Money Reward Points </label>
                <br /><p>{{ $supermarket->cash_money }}</p>             
            </div>

            <div class="col-md-3">
                <label> Country </label>
                <br /><p>{{App\Country::find($supermarket->country_id)->name}}</p>           
            </div>
           
            <div class="col-md-3">
                <label> City </label>
                <br /><p>{{!empty($city)?$city->name:''}}</p>              
            </div>
			 <div class="col-md-3">
                <label> Area </label>
                <br /><p>{{!empty($supermarket->area)?$supermarket->area->name:''}}</p>              
            </div>
            <div class="col-md-3">
                <label> Address </label>
                <br /><p>{{ $supermarket->address }}</p>              
            </div>
            <div class="col-md-3">
                <label> Status </label>
                <br /><p>{{ $supermarket->status ? 'Active' : 'Inactive' }} </p>               
            </div>
            <div class="col-md-3">
                <label> Uploaded Images </label>
                <br /><?php $item = json_decode($supermarket->image_path); ?>
                <img src={{asset('/public'.App\Constant::where('constant_type','SUPERMARKET_IMAGE_PATH')->value('data').'/'.$item[0])}} alt="No Image Uploaded for this Supermarket" height="100" width="100" >             
            </div>
        </div>
            </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                Vendor Details
            </div>
        </div>
        <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo1" data-parent="#accordionExample1">
            <div class="card-body">
                <div class="kt-portlet__body">
                    <!--begin: Datatable -->
                    <table class="table hover table-checkable" id="vendor_list_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Vendor Name</th>
                                <th>Email Id</th>
                                <th>Mobile No.</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                            @if ($vendors)
                            @foreach ($vendors as $vendor)
                                <td>{{$vendor->id}}</td>
                                <td>{{$vendor->name}}</td>
                                <td>{{$vendor->email}}</td>
                                <td>{{$vendor->mobile}}</td>
                                <td>{{$vendor->address}}</td>
                                <td>{{ $vendor->is_enabled == 1 ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('users.show',$vendor->id) }}">Show</a>
                                    <a class="btn btn-primary" href="{{ route('users.edit',$vendor->id) }}">Edit</a>
                                        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $vendor->id],'style'=>'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                
                                </td> 
                            </tr>
                            @endforeach
                            @endif        
                            
                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingThree1">
            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree1" aria-expanded="false" aria-controls="collapseThree1">
                Category List
            </div>
        </div>
        <div id="collapseThree1" class="collapse" aria-labelledby="headingThree1" data-parent="#accordionExample1">
            <div class="card-body">
                <ul class="subjects-list">
               <?php $i = 1; ?>
                    @foreach ($categories as $category)
                    <?php if($i%4 == 0) { echo '<div class="clearfix"><br/><br/></div>'; } ?>
                    <li class="subject-li">
                        <div class="categorylink">
                            <a class="subject-link" href="{{ route('supermarket.showproduct',['category_id'=>$category->id,'supermarket_id'=>$supermarket->id])}}">
                                    <img src="{{asset('/media/icon/icon2.png')}}" height="50" width="50"> {{$category->name}}
                            </a>
                            </div>
                    </li> 
                    <?php $i++; ?>
                    @endforeach                    
                </ul>

            </div>

        </div>
    </div>
</div>
</div>
</div>
<script>
    $(document).ready(function() {
        $('#vendor_list_table').DataTable();
    } );
</script>

@endsection