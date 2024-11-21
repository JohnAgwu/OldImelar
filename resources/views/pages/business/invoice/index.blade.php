@extends('layouts.business.layout')

@section('content')
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->

        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card User-Activity">
                            <div class="card-header">
                                <h5>INVOICES</h5>
                                <div class="card-header-right">
                                    <div class="card-option">
                                        <a class="text-white label theme-bg btn-shadow" href="{{ route('business.send.invoice', [$business->id]) }}">
                                            <i class="fa fa-plus"></i>
                                            <b class="d-none d-sm-inline">Send Invoice</b>
                                        </a>
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="feather icon-more-horizontal"></i>
                                        </button>
                                        <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                            <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                            <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                            <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>
                                            <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>

                            <div class="card-block pb-0">
                                @if (session('message'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                @endif

                                <div class="table-responsive pb-5">
                                    <table id="invoice-table" class="display table dt-responsive nowrap table-striped table-hover" style="width:100%" bid="{{ $business->id }}" bmode="{{ $business->isFreelance() }}">
                                        <thead>
                                        @if( $business->isFreelance() )
                                            <tr>
                                                <th>Projects</th>
                                                <th>Price</th>
                                                <th>Amount Paid</th>
                                                <th>Payment Status</th>
                                                <th>Payment Method</th>
                                                <th>Customer Name</th>
                                                <th>Customer Phone</th>
                                                <th>Customer Email</th>
                                                <th>Payment Date</th>
                                                <th>Due Date</th>
                                                <th>Expenses Incurred</th>
                                                <th>Dispatch Date</th>
                                                <th>Date Created</th>
                                                <th class="text-right"></th>
                                            </tr>
                                        @else
                                            <tr>
                                                <th>Products</th>
                                                <th>Quantity</th>
                                                <th>Selling Price</th>
                                                <th>Amount Paid</th>
                                                <th>Payment Status</th>
                                                <th>Payment Method</th>
                                                <th>Customer Name</th>
                                                <th>Customer Phone</th>
                                                <th>Customer Email</th>
                                                <th>Payment Date</th>
                                                <th>Due Date</th>
                                                <th>Expenses Incurred</th>
                                                <th>Dispatch Date</th>
                                                <th>Date Created</th>
                                                <th class="text-right"></th>
                                            </tr>
                                        @endif
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
    </div>
@endsection


@push('head')
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/datatables.min.css') }}">
@endpush
@push('script')
    <script src="{{ asset('assets/plugins/data-tables/js/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>
    <script src="{{ asset('assets/js/pages/invoice.js') }}"></script>
@endpush
