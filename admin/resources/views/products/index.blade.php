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
                        Product List
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
            <div class="kt-portlet__head-actions">
                <div class="dropdown dropdown-inline">
                    <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="la la-download"></i> Export  	
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <ul class="kt-nav">
                            <li class="kt-nav__section kt-nav__section--first">
                                <span class="kt-nav__section-text">Choose an option</span>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link">
                                    <i class="kt-nav__link-icon la la-print"></i>
                                    <span class="kt-nav__link-text">Print</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link">
                                    <i class="kt-nav__link-icon la la-copy"></i>
                                    <span class="kt-nav__link-text">Copy</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link">
                                    <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                    <span class="kt-nav__link-text">Excel</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link">
                                    <i class="kt-nav__link-icon la la-file-text-o"></i>
                                    <span class="kt-nav__link-text">CSV</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link">
                                    <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                    <span class="kt-nav__link-text">PDF</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>	
        </div>		
        </div>
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
                    <th>Discount</th>
                    <th>Discounted Price</th>
                    <th>Weight</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($products as $product)
                    
                
                <tr>
                    <td>{{$product->productconfig_id}}</td>
                    <td>{{$product->product_name}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->category_name}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->discount}}</td>
                    <td>{{$product->discountedprice}}</td>
                    <td>{{$product->capacity.'  '.App\Constant::find($product->unit_id)->data}}</td>
                    <td>{{$product->quantity}}</td>
                    <td>
                        <a class="btn btn-info" href="{{ route('product.show',$product->productconfig_id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('product.edit',$product->productconfig_id) }}">Edit</a>
                            {!! Form::open(['method' => 'DELETE','route' => ['product.destroy', $product->productconfig_id ],'style'=>'display:inline']) !!}
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
        $('#product_list_table').DataTable({
        "pageLength": 5,
            dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7,8 ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7,8 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7,8 ]
                }
            },
        ]
    
        });
    } );
</script>
@endsection
