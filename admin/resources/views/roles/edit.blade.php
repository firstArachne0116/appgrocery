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
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"> 
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="jumbotron">
            <h3>Role Settings</h3>
        </div>
        <!--begin::Form-->
{!! Form::model($role, ['method' => 'PATCH', 'class' => 'kt-form', 'route' => ['roles.update', $role->id]]) !!}
<div class="kt-portlet__body">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permission:</strong>
            <br/>
            @foreach($permission as $value)
                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                {{ $value->name }}</label>
            <br/>
            @endforeach
        </div>
    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
        <button type="submit" class="btn btn-primary pull-right">Submit</button>
    </div></div>
</div>
{!! Form::close() !!}
</div>
</div>
@endsection