@extends('layouts.app')
@section('content')
<style>
    ul, #myUL {
      list-style-type: none;
    }
    
    #myUL {
      margin: 0;
      padding: 0;
    }
    
    .box {
      cursor: pointer;
      -webkit-user-select: none; / Safari 3.1+ /
      -moz-user-select: none; / Firefox 2+ /
      -ms-user-select: none; / IE 10+ /
      user-select: none;
    }
    
    .box::before {
      content: "\002B";
      color: #5867dd;
      display: inline-block;
      margin-right: 6px;
    }
    
    .check-box::before {
      content: "\002D"; 
      color: dodgerblue;
    }
    
    .nested {
      display: none;
    }
    
    .active {
      display: block;
    }
    #myUL li{
        
border-bottom: 1px solid #eae7e7;
background: #f2f3f8;
margin: 2px;
padding: 8px;  
    }

    </style>
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
<div class="kt-portlet">
                    <div class="kt-portlet ">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                               Category list
                            </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <!--begin::Accordion-->
                            <div class="accordion accordion-light  accordion-svg-icon" id="accordionExample7">

                                <div class="card">
                                    <div class="card-header" id="heading1">
                                            <ul id="myUL">
                                                <li><span class="box">Categories</span>
                                                    <ul class="nested">
                                                @foreach ($categories as $category)
                                                    <li><span class="box">{{$category['name']}}
                                                        {{-- {{ echo App\Category::where('parentid',$category['id'])->exists() }} --}}
                                                        @role('admin')
                                                        @if(App\Category::where('parentid',$category['id'])->exists())
                                                            <?php $sub_categories = App\Category::select('name','id')->where('parentid',$category['id'])->get(); ?>

                                                        <ul class="nested">
                                                            @foreach ($sub_categories as $sub_category)
                                                                <li>{{$sub_category['name']}} <a href="#">&nbsp;&nbsp;</a></li>
                                                            @endforeach
                                                        </ul>
                                                        @endif
                                                        @endrole
                                                        @role('vendor')
                                                        @if(App\Category::where('parentid',$category['id'])->exists())
                                                            <?php 
                                                                    $supermarket = App\Supermarket::find($supermarket->id);
                                                                    $sub_categories = $supermarket->categories()
                                                                    ->where('parentid',$category['id'])->get(); 
                                                                    //echo $sub_categories;
                                                                    ?>

                                                        <ul class="nested">
                                                            @foreach ($sub_categories as $sub_category)
                                                        <li>{{$sub_category['name']}} <a href="{{route('category.delete',['id' => $sub_category['id']])}}">&nbsp;&nbsp;</a></li>
                                                            @endforeach
                                                        </ul>
                                                        @endif
                                                        @endrole
                                                    </li>
                                                @endforeach
                                                    
                                                  </ul> </div>
                                    
                        </div>
                            </div>
                            <!--end::Accordion-->
                        </div>
                    </div>
                </div>  
    
    </div>	
</div>
{{-- <script src="{{asset('js/datatable/dataTables.buttons.min.js')}}" type="text/javascript"></script> --}}
<script>
        var toggler = document.getElementsByClassName("box");
        var i;
        
        for (i = 0; i < toggler.length; i++) {
          toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("check-box");
          });
        }
        </script>
@endsection