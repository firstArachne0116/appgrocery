@extends('layouts.app')


@section('content')

<div class="kt-container  kt-container--fluid kt-margin-b-100">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header" id="headingOne">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                
                        <div class="pull-left">
                
                            <h2> Show Lottery</h2>
                
                        </div>
                
                        <div class="pull-right">
                
                            <a class="btn btn-primary" href="{{ route('lottery.index') }}"> Back</a>
                
                        </div>
                
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
                                <label> Lottery ID </label>
                                <br />
                                <p>{{$lottery->id}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Name </label>
                                <br />
                                <p>{{$lottery->name}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Name in Aabic </label>
                                <br />
                                <p>{{$lottery->name_arabic}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Description </label>
                                <br />
                                <p>{{$lottery->description}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Description In Arabic</label>
                                <br />
                                <p>{{$lottery->description_arabic}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Lottery Rule </label>
                                <br />
                                <p>{{$lottery->lottery_rule}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Lottery Type </label>
                                <br />
                                <p>{{$lottery->supermarket_id == -1 ? "Grocery Hero lottery" :   "Supermarket lottery"}}</p>
                            </div>
                            @if ($lottery->supermarket_id != -1)
                            <div class="col-md-3">
                                    <label> Supermarket Name </label>
                                    <br />
                                    <p>{{$sm[0]->name}}</p>
                                </div>
                            @endif
                            <div class="col-md-3">
                                <label> Status </label>
                                <br />
                                <p>{{$lottery->status == 0 ? "Disabled" :   "Enabled"}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Valid From</label>
                                <br />
                                <p>{{date('d-M-Y', strtotime($lottery->valid_from))}}</p>
                            </div>
                            <div class="col-md-3">
                                <label> Valid Till </label>
                                <br />
                                <p>{{date('d-M-Y', strtotime($lottery->valid_till))}}</p>
                            </div>
                 
                        </div>

                    </div>

                </div>
            
        </div>

    </div>
</div>

@endsection