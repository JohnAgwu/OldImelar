@extends('layouts.business.layout')

@section('content')
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->

        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->

                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="card theme-bg">
                            <div class="card-block">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-auto">
                                        <img src="/assets/images/widget/shape4.png" alt="activity-user">
                                    </div>
                                    @if($business->isFreelance())
                                        <div class="col">
                                            <h4 class="text-white f-w-800">{{ $business->projects()->count() }}</h4>
                                            <h6 class="text-white">Projects</h6>
                                        </div>
                                    @else
                                        <div class="col">
                                            <h4 class="text-white f-w-800">{{ $business->products()->count() }}</h4>
                                            <h6 class="text-white">Products</h6>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="card theme-bg2">
                            <div class="card-block">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-auto">
                                        <img src="/assets/images/widget/shape5.png" alt="activity-user">
                                    </div>
                                    <div class="col">
                                        <h4 class="text-white f-w-800">{{ $business->invoices()->count() }}</h4>
                                        <h6 class="text-white">Invoices</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="card bg-c-blue">
                            <div class="card-block">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-auto">
                                        <img src="/assets/images/widget/shape6.png" alt="activity-user">
                                    </div>
                                    <div class="col">
                                        <h6 class="text-white f-w-800 autoCurrency">{{ $business->total_income }}</h6>
                                        <h6 class="text-white">Total Earnings</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="card theme-bg">
                            <div class="card-block">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-auto">
                                        <img src="/assets/images/widget/shape6.png" alt="activity-user">
                                    </div>
                                    <div class="col">
                                        <h4 class="text-white f-w-800">{{ $business->customers()->count() }}</h4>
                                        <h6 class="text-white">Total Customers</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- [ daily sales section ] start -->
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="mb-4">Daily Sales</h6>
                                <div class="row d-flex align-items-center">
                                    <div class="col-12">
                                        <h4 class="f-w-300 d-flex align-items-center m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>₦{{ number_format($dailySales) }}</h4>
                                    </div>
                                </div>
                                <div class="progress m-t-30" style="height: 4px;">
                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ daily sales section ] end -->

                    <!-- [ Monthly  sales section ] start -->
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="mb-4">Monthly Sales</h6>
                                <div class="row d-flex align-items-center">
                                    <div class="col-12">
                                        <h4 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-down text-c-red f-30 m-r-10"></i>₦{{ number_format($monthlySales) }}</h4>
                                    </div>
                                </div>
                                <div class="progress m-t-30" style="height: 4px;">
                                    <div class="progress-bar progress-c-theme2" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Monthly  sales section ] end -->

                    <!-- [ year  sales section ] start -->
                    <div class="col-md-12 col-xl-4">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="mb-4">Yearly Sales</h6>
                                <div class="row d-flex align-items-center">
                                    <div class="col-12">
                                        <h4 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>₦{{ number_format($yearlySales) }}</h4>
                                    </div>
                                    {{--<div class="col-3 text-right">--}}
                                    {{--<p class="m-b-0">80%</p>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="progress m-t-30" style="height: 4px;">
                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ year  sales section ] end -->
                </div>

                <div class="mt-3 d-flex justify-content-between">
                    @if($business->isFreelance())
                        <h5>PROJECTS</h5>
                        <a href="{{ route('business.projects', [$business->id]) }}">
                            View More &nbsp;<i class="fa fa-arrow-right"></i>
                        </a>
                    @else
                        <h5>PRODUCTS</h5>
                        <a href="{{ route('business.products', ['id' => $business->id]) }}">
                            View More &nbsp;<i class="fa fa-arrow-right"></i>
                        </a>
                    @endif
                </div>
                <hr>
                <div class="row">
                    @if($business->isFreelance())
                        @foreach( $business->projects()->take(4)->get() as $project )
                            <div class="col-xl-3 col-md-6">
                                <div class="card">

                                    <div class="card-block sale-view">
                                        <h5>{{ $project->title }}</h5>
                                        <hr>
                                        <h6 class="autoCurrency">{{ $project->price }}</h6>
                                        <h6>End date: {{ $project->end_date }}</h6>
                                        <div class="row justify-content-between mt-4">
                                            <div class="col-auto text-right">
                                                <a href="{{ route('business.send.invoice', [$business->id, $project->id]) }}">
                                                    <i class="fab fa fa-file-invoice f-20 text-white theme-bg" data-toggle="tooltip" data-placement="left" title="" data-original-title="Send invoice"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach( $business->products()->take(4)->get() as $product )
                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <img class="img-flui" height="250" src="{{ $product->image ? asset('storage/' . $product->image->path) : ''}}" alt="dashboard-user">
                                    <div class="card-block sale-view">
                                        <h5>{{ $product->name }}</h5>
                                        <hr>
                                        @if($product->quantity > 0 )<h6>{{ $product->quantity }}</h6>@endif
                                        <h6 class="text-muted">@if($product->quantity > 0 ) <span class="font-weight-bold text-c-green">In Stock</span> @else <span class="font-weight-bold text-c-red">Out Of Stock</span> @endif</h6>
                                        <div class="row justify-content-between mt-4">
                                            <div class="col-auto text-left">
                                                <a href="{{ route('business.restock.product', [$business->id, $product->id]) }}">
                                                    <i class="fab fa fa-calendar-plus f-20 text-white theme-bg2" data-toggle="tooltip" data-placement="left" title="" data-original-title="Re-Stock"></i>
                                                </a>
                                            </div>
                                            <div class="col-auto text-right">
                                                <a href="{{ route('business.send.invoice', [$business->id, $product->id]) }}">
                                                    <i class="fab fa fa-file-invoice f-20 text-white theme-bg" data-toggle="tooltip" data-placement="left" title="" data-original-title="Send invoice"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@push('head')

@endpush
@push('script')
    <!-- dashboard-custom js -->
    <script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>
    <script src="/assets/js/pages/dashboard-custom.js"></script>
@endpush
