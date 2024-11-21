@extends('layouts.business.layout')

@section('content')
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->

        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->

                <div class="row">
                    {{--RECEIVABLES--}}
                    <div class="col-xl-6">
                        <div class="card User-Activity">
                            <div class="card-header">
                                <h5>RECEIVABLES</h5> <span class="autoCurrency f-20">{{ $business->receivables->sum('amount') }}</span>
                                <div class="card-header-right">
                                    <div class="btn-group card-option">
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
                                <div class="table-responsive pb-5">
                                    <table id="receivables-table" class="display table dt-responsive nowrap table-striped table-hover" style="width:100%" bid="{{ $business->id }}">
                                        <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Amount</th>
                                            <th>Payment Status</th>
                                            <th>Due Date</th>
                                            <th>Days Overdue</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--PAYABLES--}}
                    <div class="col-xl-6">
                        <div class="card User-Activity">
                            <div class="card-header">
                                <h5>PAYABLES</h5> <span class="autoCurrency f-20">{{ $business->payables->sum('amount') }}</span>
                                <div class="card-header-right">
                                    <div class="btn-group card-option">
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
                                <div class="table-responsive pb-5">
                                    <table id="payables-table" class="display table dt-responsive nowrap table-striped table-hover" style="width:100%" bid="{{ $business->id }}">
                                        <thead>
                                        <tr>
                                            <th>Product</th>
                                            {{--<th>Customer</th>--}}
                                            <th>Amount unPaid</th>
                                        </tr>
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
    <script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>
    @if($business->mode == 'FREELANCE')
        <script src="{{ asset('assets/js/pages/receivables-payables-product.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/pages/receivables-payables-project.js') }}"></script>
    @endif
@endpush
