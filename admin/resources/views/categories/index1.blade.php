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
          -webkit-user-select: none; /* Safari 3.1+ */
          -moz-user-select: none; /* Firefox 2+ */
          -ms-user-select: none; /* IE 10+ */
          user-select: none;
        }
        
        .box::before {
          content: "\2610";
          color: black;
          display: inline-block;
          margin-right: 6px;
        }
        
        .check-box::before {
          content: "\2611"; 
          color: dodgerblue;
        }
        
        .nested {
          display: none;
        }
        
        .active {
          display: block;
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
        @role('admin')
        <div class="kt-portlet">
            <!--begin::Form-->
            <div class="kt-portlet">
                    <!--begin::Form-->
                    {{-- <form class="kt-form" method="POST" action="{{ route('product.showproduct') }}">
                            @csrf
                        <div class="kt-portlet__body">
                            <div class="form-group" id="supermarket_selector">
                                <label>Select a supermarket And View Categories</label>
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
                    </form>    			 --}}
                </div>
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
                                                        @if(App\Category::where('parentid',$category['id'])->exists())
                                                            <?php $sub_categories = App\Category::select('name',)->where('parentid',$category['id'])->get(); ?>

                                                        <ul class="nested">
                                                            @foreach ($sub_categories as $sub_category)
                                                                <li>{{$sub_category['name']}}</li>
                                                            @endforeach
                                                        </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                                    </ul>
                                                    {{-- <li><span class="box">Categories</span>
                                                      <ul class="nested">
                                                        <li>Water</li>
                                                        <li>Coffee</li>
                                                        <li><span class="box">Tea</span>
                                                          <ul class="nested">
                                                            <li>Black Tea</li>
                                                            <li>White Tea</li>
                                                            <li><span class="box">Green Tea</span>
                                                              <ul class="nested">
                                                                <li>Sencha</li>
                                                                <li>Gyokuro</li>
                                                                <li>Matcha</li>
                                                                <li>Pi Lo Chun</li>
                                                              </ul>
                                                            </li>
                                                          </ul>
                                                        </li>  
                                                      </ul>
                                                    </li> --}}
                                                  </ul>
{{--         
                                        <div class="card-title1" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
                                                    <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" id="Path-94" fill="#000000" fill-rule="nonzero"></path>
                                                    <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>
                                                </g>
                                            </svg> category1   <img src="{{asset('files/cat.jpg')}}" class="img-thumbnail cat-img" >
                                        </div>
                                    </div>
                                    <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="">
                                        <div class="card-body">
                                            <div class="card">
                                                <div class="card-header" id="heading2">
                                                    <div class="card-title1 collapsed" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" id="Path-94" fill="#000000" fill-rule="nonzero"></path>
                                                                <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>
                                                            </g>
                                                        </svg> category1-2   <img src="{{asset('files/cat.jpg')}}" class="img-thumbnail cat-img" >
                                                    </div>
                                                </div>
                                                <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionExample7">
                                                    <div class="card-body">
        
                                                        <div class="card-header" id="heading3">
                                                            <div class="card-title1 collapsed" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
                                                                        <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" id="Path-94" fill="#000000" fill-rule="nonzero"></path>
                                                                        <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>
                                                                    </g>
                                                                </svg> category2-2   <img src="{{asset('files/cat.jpg')}}" class="img-thumbnail cat-img" >
                                                            </div>
                                                        </div>
        
                                                    </div>
                                                </div>
                                            </div>
        
                                        </div>
                                    </div>
                        </div>
        
                                {{-- <div class="card">
                                    <div class="card-header" id="headingThree71">
                                        <div class="card-title1 collapsed" data-toggle="collapse" data-target="#collapseThree7" aria-expanded="false" aria-controls="collapseThree7">
                                            Category 2
                                        </div>
                                    </div>
                                    <div id="collapseThree7" class="collapse" aria-labelledby="headingThree7" data-parent="#accordionExample7">
                                        <div class="card-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <!--end::Accordion-->
                        </div>
                    </div>
                </div>  			
        </div>
        @endrole
            <!--end::Portlet-->
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