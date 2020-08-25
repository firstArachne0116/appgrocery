@extends('layouts.app')
@section('content')
<div class="row" style="padding:0px 25px 0px 25px;">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2></h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
        </div>
    </div>
</div>
<div class="clearfix"><br/></div>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"> 
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="jumbotron">
            <h3>Role Details</h3>
        </div>
        <div class="kt-portlet__body">
        <div class="row">            
            <div class="col-md-3">
                <label>Name:</label><br/>
                <p>{{ $role->name }}</p>
            </div>            
            <div class="col-md-3">
                <label>Permissions:</label><br/>
                @if(!empty($rolePermissions))
                    @foreach($rolePermissions as $v)
                        <p>{{ $v->name }},</p>
                    @endforeach
                @endif
            </div>            
        </div>
        </div>
    </div>
<div>
@endsection