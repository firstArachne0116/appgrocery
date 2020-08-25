@extends('layouts.app')
@section('content')
<div class="row" style="padding: 0px 25px;">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2></h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('category.index') }}"> Back</a>
        </div>
    </div>
</div>
<div class="clearfix"><br/></div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
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
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="jumbotron">
                    <h3>Category Details</h3>
                </div>
                <!--begin::Form-->
                <form class="kt-form" method="POST" enctype="multipart/form-data" action="{{ route('category.store') }}">
                        @csrf
                    <div class="kt-portlet__body">
                            {{-- <div class="form-group">
                                    <label>Super Market</label>
                                    <select class="form-control" id="supermarket_id" name="supermarket_id" required>
                                            <option>Select SuperMarket</option>
                                            @foreach ($sm as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                            </div> --}}
                        <div class="form-group" id="main_category_selector">
                            <label for="exampleInputPassword1">Select Main Category</label>
                            <select class="form-control" id="main_category_type" name="main_category_id">
                                    <option value="-1" selected>Add New Main</option> 
                                    @foreach ($maincategories as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                    
                            </select>
                        </div>
                         <div class="form-group" id="sub_category_selector" style="display: none;">
                            <label for="exampleInputPassword1">Choose existing sub-category</label>
                            <select class="form-control" id="sub_category_id" name="sub_category_id">
                                     <option value="-1" > Create Sub Category</option>
                                        {{-- @foreach ($categories as $category)
                                             <optgroup label="{{$category['name']}} "></optgroup>
                                                @if (isset($category['sub_categories']) ))
                                                @foreach ($category['sub_categories'] as $sbcat)
                                                        <option value="{{$sbcat['parent_id']}}">{{$sbcat['name']}}</option>
                                                    @endforeach
                                                @endif
                                        @endforeach  --}}
                            </select>
                        </div>
                        <div class="form-group" id="category_name_control">
                            <label for="exampleInputPassword1" id="category_label">Name</label>
                            <input type="text" name="category_name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group" id="category_name_arabic_control">
                            <label for="exampleInputPassword1" id="category_label">Name in Arabic</label>
                            <input type="text" name="name_arabic" class="form-control" placeholder="Arabic Name">
                        </div>
                        <div class="form-group" id="category_image">
                                <label for="exampleInputPassword1">Category Image</label>
                                <input type="file" id="file" name="filename" class="form-control" >
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                               
                            </div>
                        </div>
                      
                    </div>
                </form>    			
            </div>
            <!--end::Portlet-->
    
        </div>
    </div>	
</div>

<script src="{{asset('js/category.js')}}"></script>


@endsection