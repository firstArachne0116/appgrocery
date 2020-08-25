@extends('layouts.app')
@section('content')
<style>
    SELECT, INPUT[type="text"] {
    width: 300px;
    box-sizing: border-box;
}
SECTION {
    padding: 8px;
    background-color: #f0f0f0;
    overflow: auto;
}
SECTION > DIV {
    float: left;
    padding: 4px;
}
SECTION > DIV + DIV {
    width: 40px;
    text-align: center;
}
</style>    
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
                    <h3>Add Categories to your Supermarket</h3>
                </div>
                <!--begin::Form-->
                <form class="kt-form" method="POST" action="{{ route('category.storesupermarketcategory') }}">
                        @csrf
                    <div class="kt-portlet__body">
                        <section class="container">
                            <div>
                                <select id="leftValues" name="available_options[]" multiple style="min-height:400px;">
                                    @foreach ($categories as $item)
                                           <optgroup label="{{$item['name']}} ">
                                               @if(App\Category::where('parentid',$item['id'])->exists())
                                                <?php $sub_categories = App\Category::select('name','id')->where('parentid',$item['id'])->get(); ?>

                                                @foreach ($sub_categories as $sub_category)
                                                     <option value="{{$sub_category->id}}" @if(in_array($sub_category->id,$cats)) selected @endif>{{$sub_category->name}}</option>
													 
													<?php /*	@if(App\Category::where('parentid',$sub_category->id)->exists())
														<?php $sub_categories2level = App\Category::select('name','id')->where('parentid',$sub_category->id)->get(); ?>

														@foreach ($sub_categories2level as $sub_cat)
														<option value="{{$sub_cat->id}}" @if(in_array($sub_cat->id,$cats)) selected @endif>--{{$sub_cat->name}}</option>
														@endforeach
														 @endif   */ ?>
                                                @endforeach
                                            </optgroup>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div>
                                <input type="button" id="btnLeft" value="&lt;&lt;" />
                                <input type="button" id="btnRight" value="&gt;&gt;" />
                            </div>
                            <div>
                                <select id="rightValues"  name="selected_options" multiple>
                                   
                                </select>
                            </div> --}}
                        </section>
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

<script>
    $(document).ready(function () {
        $("#btnLeft").click(function () {
        var selectedValue = $("#rightValues option:selected");
        $("#leftValues").append('<option value='+selectedValue.val()+'>'+selectedValue.text()+'</option>'); 
    });

    $("#btnRight").click(function () {
    var selectedValue = $("#leftValues option:selected")
    $("#rightValues").append('<option value='+selectedValue.val()+'>'+selectedValue.text()+'</option>');
});

    
       
});



</script>


@endsection