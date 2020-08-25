@extends('layouts.app')
@section('content')
<style>
.card-header {
    background-color:#3b2f5c !important;
    color:#FFF;
}
</style>
<div class="kt-container  kt-container--fluid kt-margin-b-100">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" id="headingOne">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2> Show Product</h2>
                        </div>                        
                        @role('admin')
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('product.list') }}"> Back</a>
                        </div>
                        @endrole
                        @role('vendor')
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('product.index') }}"> Back</a>
                        </div>
                        @endrole
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="kt-container">
                    <div class="col-md-6"></div>
                </div>
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <label> Product ID </label>
                            <br />
                            <p>{{$product[0]->productconfig_id}}</p>
                        </div>
                        <div class="col-md-3">
                            <label> Product Name </label>
                            <br />
                            <p>{{$product[0]->product_name}}</p>
                        </div>
                        <div class="col-md-3">
                            <label> Product Description </label>
                            <br />
                            <p>{{$product[0]->description}}</p>
                        </div>
                        
                        <div class="col-md-3">
                            <label> Category Name </label>
                            <br />
                            <p>{{$product[0]->category_name}}</p>
                        </div>
                        <div class="col-md-3">
                            <label> Credits </label>
                            <br />
                            <p>{{$product[0]->credits}}</p>
                        </div>
                        <div class="col-md-3">
                            <label> Price </label>
                            <br />
                            <p>{{$product[0]->price}}</p>
                        </div>
                        <div class="col-md-3">
                            <label> Discount </label>
                            <br />
                            <p>{{$product[0]->discount}}</p>
                        </div>
                        <div class="col-md-3">
                            <label> Discounted Price </label>
                            <br />
                            <p>{{$product[0]->discountedprice}}</p>
                        </div>
                        <div class="col-md-3">
                            <label> Weight </label>
                            <br />
                            <p>{{$product[0]->capacity}} {{App\Constant::find($product[0]->unit_id)->name}}</p>
                        </div>
                        <div class="col-md-3">
                            <label> Quantity </label>
                            <br />
                            <p>{{$product[0]->quantity}}</p>
                        </div>      
                        <div class="col-md-3">
                            <label> Stock Keeping Unit </label>
                            <br />
                            <p>{{$product[0]->sku}}</p>
                        </div>      
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection