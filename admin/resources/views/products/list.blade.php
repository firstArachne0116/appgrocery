@extends('layouts.app')
@section('content')
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
            <form class="kt-form" method="POST" action="{{ route('product.showproduct') }}">
                    @csrf
                <div class="kt-portlet__body">
                    <div class="form-group" id="supermarket_selector">
                        <label>Select a supermarket for Product List</label>
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
            </form>    			
        </div>
        @endrole
        @if (isset($products))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" style="padding:0px !important;"> 
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-brand flaticon2-line-chart"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            Product List
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                        <!--<div class="dropdown dropdown-inline">-->
                        <!--    <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                        <!--        <i class="la la-download"></i> Export  	-->
                        <!--    </button>-->
                        <!--    <div class="dropdown-menu dropdown-menu-right">-->
                        <!--        <ul class="kt-nav">-->
                        <!--            <li class="kt-nav__section kt-nav__section--first">-->
                        <!--                <span class="kt-nav__section-text">Choose an option</span>-->
                        <!--            </li>-->
                        <!--            <li class="kt-nav__item">-->
                        <!--                <a href="#" class="kt-nav__link">-->
                        <!--                    <i class="kt-nav__link-icon la la-print"></i>-->
                        <!--                    <span class="kt-nav__link-text">Print</span>-->
                        <!--                </a>-->
                        <!--            </li>-->
                        <!--            <li class="kt-nav__item">-->
                        <!--                <a href="#" class="kt-nav__link">-->
                        <!--                    <i class="kt-nav__link-icon la la-copy"></i>-->
                        <!--                    <span class="kt-nav__link-text">Copy</span>-->
                        <!--                </a>-->
                        <!--            </li>-->
                        <!--            <li class="kt-nav__item">-->
                        <!--                <a href="#" class="kt-nav__link">-->
                        <!--                    <i class="kt-nav__link-icon la la-file-excel-o"></i>-->
                        <!--                    <span class="kt-nav__link-text">Excel</span>-->
                        <!--                </a>-->
                        <!--            </li>-->
                        <!--            <li class="kt-nav__item">-->
                        <!--                <a href="#" class="kt-nav__link">-->
                        <!--                    <i class="kt-nav__link-icon la la-file-text-o"></i>-->
                        <!--                    <span class="kt-nav__link-text">CSV</span>-->
                        <!--                </a>-->
                        <!--            </li>-->
                        <!--            <li class="kt-nav__item">-->
                        <!--                <a href="#" class="kt-nav__link">-->
                        <!--                    <i class="kt-nav__link-icon la la-file-pdf-o"></i>-->
                        <!--                    <span class="kt-nav__link-text">PDF</span>-->
                        <!--                </a>-->
                        <!--            </li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!--&nbsp;-->
                        
                        @if(count($products) > 0)
                        <form id="approve-form" action="{{ route('product.approveall',$products[0]->supermarket_id) }}" method="POST" style="display:inline !important;">
                            @csrf
                            <button class="btn btn-danger btn-elevate btn-icon-sm" type="submit">Approve All</button>
                        </form>
                        @endif
                        </div>	
                    </div></div>
                    </div>
                    
                    <div class="kt-portlet__body">
                        <!--begin: Datatable -->
                        <table class="table hover table-checkable" id="product_list_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Product Description</th>
                                    <th>Product Category</th>
                                    <th>Price</th>
                                    <th>Weight</th>
                                    <th>Quantity</th>
                                    <th>Stock Keeping Unit</th>
                                    <th>Product Approval Status</th>
                                    <th>Product Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 0; $i < count($products);$i++)
                                <tr>
                                    <td>{{$products[$i]->productconfig_id}}</td>
                                    <td>{{$products[$i]->product_name}}</td>
                                    <td>{{$products[$i]->description}}</td>
                                    <td>{{$products[$i]->category_name}}</td>
                                    <td>{{$products[$i]->price}}</td>
                                    <td>{{$products[$i]->capacity.'  '.App\Constant::find($products[$i]->unit_id)->data}}</td>
                                    <td>{{$products[$i]->quantity}}</td>
                                    <td>{{$products[$i]->sku}}</td>
                                    <td>{{$products[$i]->is_approved == 0 ? "Unapproved" : "Approved" }}</td>
                                    <td>{{$products[$i]->is_enabled == 1 ? "Enabled" : "Disabled" }}</td>
                                    
                                    <td>
                                        <a class="btn btn-success" href="{{ route('product.show',$products[$i]->productconfig_id) }}">Show</a>
                                        <a class="btn btn-primary" href="{{ route('product.edit',$products[$i]->productconfig_id) }}">Edit</a>
                                        @if ($products[$i]->is_approved == 0)
                                        <form action="{{ route('product.approve', [ 
                                            'id' => $products[$i]->productconfig_id,
                                            'supermarket_id' => $products[$i]->supermarket_id 
                                            ])}}" method="post">
                                        @csrf
                                        @method('POST')
                                        <button class="btn btn-info" type="submit">Approve</button>
                                        </form>
                                        @endif 
                                        {!! Form::open(['method' => 'DELETE','route' => ['product.destroy', $products[$i]->productconfig_id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                        </td> 
                                        @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>            
        @endif
            <!--end::Portlet-->
    </div>
    </div>	
</div>
{{-- <script src="{{asset('js/datatable/dataTables.buttons.min.js')}}" type="text/javascript"></script> --}}
<script>
    $(document).ready(function() {
        var table = $('#product_list_table').DataTable( {
            "pageLength": 5,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
    
        } );
    } );        
</script>    
@endsection