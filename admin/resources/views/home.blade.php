@extends('layouts.app')

@section('content')
@role('admin')
<!-- <div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">
    
    <div class="kt-login__body" style="min-height:435px;"> -->
        <div class=" kt-container--fluid mt_20 kt-grid__item kt-grid__item--fluid">
            <div class="row">

                <div class="kt-widget17 width-100">
                    <div class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides" style="background-color: #fd397a">
                        <div>
                            <div class="chartjs-size-monitor">
                                <div>
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="kt-widget17__stats">
                        <div class="kt-widget17__items">
                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" id="Combined-Shape" fill="#000000"></path>
                <rect id="Rectangle-Copy-2" fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1"></rect>
            </g>
        </svg>						</span>
                                <span class="kt-widget17__subtitle">
                                   Number of Customer
                                </span>
                                <span class="kt-widget17__desc">
                                    {{App\User::role('consumer')->where([['is_enabled',1],['status',1]] )->count()}}
                                </span>
                            </div>

                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon id="Bound" points="0 0 24 0 24 24 0 24"></polygon>
                        <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" id="Shape" fill="#000000" fill-rule="nonzero"></path>
                        <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" id="Path" fill="#000000" opacity="0.3"></path>
                    </g>
                </svg>						</span>
                                <span class="kt-widget17__subtitle">
                                      Number of Order
                                    </span>
                                <span class="kt-widget17__desc">
                                        {{App\Order::where('status',1)->count()}} 
                                    </span>
                            </div>

                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--danger">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                        <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                        <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" id="Rectangle-102-Copy" fill="#000000"></path>
                    </g>
                </svg>						</span>
                                <span class="kt-widget17__subtitle">
                                        Numbers of supermarkets
                                </span>
                                <span class="kt-widget17__desc">
                                    {{App\Supermarket::where([['is_enabled',1],['status',1]])->count()}}
                                </span>
                            </div>

                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--danger">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                        <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                        <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" id="Rectangle-102-Copy" fill="#000000"></path>
                    </g>
                </svg>						</span>
                                <span class="kt-widget17__subtitle">
                                        Numbers of vendors
                                </span>
                                <span class="kt-widget17__desc">
                                    {{App\User::role('vendor')->where([['is_enabled',1],['status',1]])->count()}}
                                </span>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="  kt-container--fluid  kt-grid__item kt-grid__item--fluid"> 
                <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon2-line-chart"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Sales List
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">	
                    </div>		</div>
                        </div>
                        <div class="kt-portlet__body">
                                <!--begin: Datatable -->
                                <table class="table table-striped- table-bordered table-hover table-checkable" id="sales_table">
                                    <thead>
                                        <tr>
                                            <th>Daily Sales</th>
                                            <th>Weekly Sales</th>
                                            <th>Monthly Sales</th>
                                       
                                        </tr>
                                    </thead>
                
                                    <tbody>
                                        <tr>
                                          <td>{{$dailyCommission[0]->dailyamount === NULL ? "No Sale Yet" : $dailyCommission[0]->dailyamount}}</td>
                                          <td>{{$weeklyCommission[0]->weeklyamount === NULL ? "No Sale Yet" : $weeklyCommission[0]->weeklyamount}}</td>
                                          <td>{{$monthlyCommission[0]->monthlyamount === NULL ? "No Sale Yet" : $monthlyCommission[0]->monthlyamount}}</td>
                                       
                                        </tr>
                                    </tbody>
                
                                </table>
                                <!--end: Datatable -->
                            </div>
                    </div>
            </div>
        </div>
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"> 
            <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-brand flaticon2-line-chart"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                Active Lottery Deals
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-wrapper">	
                </div>		</div>
                    </div>
                    <div class="kt-portlet__body">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="lottery_product_list_table">
                                <thead>
                                    <tr>
                                        <th>Lottery Name</th>
                                        <th>Description</th>
                                        <th>Lottery Reward</th>
                                        <th>Lottery Type</th>
                                        <th>Status</th> 
                                        <th>Valid From</th>
                                        <th>Valid Till</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
            
                                <tbody>
                                    @foreach ($lotteries as $lottery)
                                    <tr>
                                        <td>{{$lottery->name}}</td>
                                        <td>{{$lottery->description}}</td>
                                        <td>{{$lottery->lottery_rule}}</td>
                                        <td>{{$lottery->lottery_type == 1 ? "Supermarket Lottery" : "Grocery Hero"}}</td> 
                                        <td>{{$lottery->is_enabled == 1 ? "Enabled" : "Disabled"}}</td> 
                                        <td>{{date('d-M-Y', strtotime($lottery->valid_from))}}</td>
                                        <td>{{date('d-M-Y', strtotime($lottery->valid_till))}}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ route('lottery.show',$lottery->id) }}">Show</a>
                                            <a class="btn btn-primary" href="{{ route('lottery.edit',$lottery->id) }}">Edit</a>
                                            {!! Form::open(['method' => 'DELETE','route' => ['lottery.destroy', $lottery->id],'style'=>'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                     
                                         </td> 
                                    </tr>
                                         @endforeach    
                                    
                                </tbody>
            
                            </table>
                            <!--end: Datatable -->
                        </div>
                </div>
        </div>
        <!--    
    </div>
</div> -->
@endrole

@role('vendor')
<!-- <div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">
    
    <div class="kt-login__body" style="min-height:435px;"> -->
        {{-- <div class=" kt-container--fluid mt_20 kt-grid__item kt-grid__item--fluid">
            <div class="row">

                <div class="kt-widget17 width-100">
                    <div class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides" style="background-color: #fd397a">
                        <div>
                            <div class="chartjs-size-monitor">
                                <div>
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink"> 
                                    <div class=""></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="kt-widget17__stats">
                        <div class="kt-widget17__items">
                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" id="Combined-Shape" fill="#000000"></path>
                <rect id="Rectangle-Copy-2" fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1"></rect>
            </g>
        </svg>						</span>
                                <span class="kt-widget17__subtitle">
                                   Number of Unapproved Products
                                </span>
                                <span class="kt-widget17__desc">
                                    15 
                                </span>
                            </div>

                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon id="Bound" points="0 0 24 0 24 24 0 24"></polygon>
                        <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" id="Shape" fill="#000000" fill-rule="nonzero"></path>
                        <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" id="Path" fill="#000000" opacity="0.3"></path>
                    </g>
                </svg>						</span>
                                <span class="kt-widget17__subtitle">
                                      Number of Orders
                                    </span>
                                <span class="kt-widget17__desc">
                                        15 
                                    </span>
                            </div>

                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--danger">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                        <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                        <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" id="Rectangle-102-Copy" fill="#000000"></path>
                    </g>
                </svg>						</span>
                                <span class="kt-widget17__subtitle">
                                        Total income
                                </span>
                                <span class="kt-widget17__desc">
                                    {{App\Supermarket::where('is_enabled',1)->count()}}
                                </span>
                            </div>

                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--danger">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                        <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                        <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" id="Rectangle-102-Copy" fill="#000000"></path>
                    </g>
                </svg>						</span>
                                <span class="kt-widget17__subtitle">
                                        Commission Payable
                                </span>
                                <span class="kt-widget17__desc">
                                    72 New Items
                                </span>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div> --}}
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"> 
            <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-brand flaticon2-line-chart"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                Order List
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-wrapper">	
                </div>		</div>
                    </div>
                
                    <div class="kt-portlet__body">
                        <!--begin: Datatable -->
                        <table class="table hover table-checkable" id="order_list_table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Consumer Name</th>
                                    <th>Number of Items</th>
                                    <th>Total Bill Amount</th>
                                    <th>Billing Date</th>
                                    <th>Purchased From</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
            
                            <tbody>
                                @foreach ($orders as $order)                        
                                <tr>
                                    <td>{{$order->order_id}}</td>
                                    <td>{{$order->user_name}}</td> 
                                    <td>{{$order->no_of_items}}</td> 
                                    <td>{{$order->total}}</td> 
                                    <td>{{date('d-M-Y', strtotime($order->order_date))}}</td>
                                    <td>{{$order->supermarket_name}}</td> 
            
                                    <td>{{$order->status}}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('order.show',$order->order_id) }}">Show</a>
                                    </td> 
                                </tr>
                                        @endforeach    
                                
                            </tbody>
            
                        </table>
                        <!--end: Datatable -->
                    </div>
                </div>
        </div>
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
                </div>		</div>
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
                                    <td>{{$product->capacity}}</td>
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
    <!-- </div>
</div> -->
@endrole

<script>
    $(document).ready(function() {
      $('#lottery_product_list_table').DataTable();
      $('#order_list_table').DataTable();
      $('#sales_table').DataTable();
      $('#product_list_table').DataTable({
        "lengthMenu": [ 10, 25, 50, 75, 100 ],
        "pageLength": 5
      });
  } );
</script>
@endsection
