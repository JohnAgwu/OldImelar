@extends('layouts.user.layout')

@section('content')
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->

        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->

                <div class="row">
                    <!-- [ Total Revenue ] start -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="mb-4">Total Revenue</h6>
                                <div class="row d-flex align-items-center">
                                    <div class="col-12">
                                        <h4 class="f-w-300 d-flex align-items-center m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>₦{{ number_format($totalRevenue) }}</h4>
                                    </div>
                                </div>
                                <div class="progress m-t-30" style="height: 4px;">
                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Total Revenue ] end -->

                    <!-- [ Total Expenses ] start -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="mb-4">Total Expenses</h6>
                                <div class="row d-flex align-items-center">
                                    <div class="col-12">
                                        <h4 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-down text-c-red f-30 m-r-10"></i>₦{{ number_format($totalExpenses) }}</h4>
                                    </div>
                                </div>
                                <div class="progress m-t-30" style="height: 4px;">
                                    <div class="progress-bar progress-c-theme2" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Total Expenses ] end -->

                    <!-- [ Customers] start -->
                    <div class="col-md-12 col-xl-3">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="mb-4">Total Customers</h6>
                                <div class="row d-flex align-items-center">
                                    <div class="col-12">
                                        <h4 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>{{ number_format($totalCustomers) }}</h4>
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
                    <!-- [ customers ] end -->

                    <!-- [ Total unpaid invoices] start -->
                    <div class="col-md-12 col-xl-3">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="mb-4">Total unpaid Invoices</h6>
                                <div class="row d-flex align-items-center">
                                    <div class="col-12">
{{--                                        <h4 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>₦{{ number_format($totalUnPaidInvoice) }}</h4>--}}
                                        <h4 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>₦{{ number_format($totalUnPaidInvoice) }}</h4>
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
                    <!-- [ Total unpaid invoices ] end -->
                </div>

                <div class="row">

                    <!-- [ Invoices list ] starts-->
                    <div class="@if(auth()->user()->businesses->count() > 0 ) col-xl-4 col-md-6 @else col @endif">
                        <div class="card user-list">
                            <div class="card-header">
                                <h5>Recent Invoices</h5>
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
                            <div class="card-block px-0 py-3">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tbody>
                                        @if($invoices->count() < 1 )
                                            <div class="text-center p-5">No Invoice to display</div>
                                        @endif
                                        @foreach( $invoices as $invoice )
                                            <tr>
                                                <td>
                                                    <h6>#{{ str_pad($invoice->id, 8, '0', STR_PAD_LEFT) }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-1">{{ $invoice->product->name ?? '' }}</h6>
                                                    <p class="m-0">
                                                        To: {{ $invoice->customer->user->name }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <a href="{{ route('business.invoices.view', [$invoice->business_id, $invoice->id]) }}" class="label theme-bg2 text-white f-12" target="_blank">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ rating list ] end -->

                    @if(auth()->user()->businesses->count() > 0 )
                    <!-- [ Recent Customer ] start -->
                    <div class="col-xl-8 col-md-6">
                        <div class="card Recent-Users">
                            <div class="card-header">
                                <h5>Recent Customers</h5>
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
                            <div class="card-block px-0 py-3">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tbody>
                                        @if($customers->count() < 1 )
                                            <div class="text-center p-5">No Customer to display</div>
                                        @endif
                                        @foreach( $customers as $customer )
                                            <tr>
                                                <td>
                                                    <img class="rounded-circle" style="width:40px;" src="/assets/images/user/avatar-2.jpg" alt="activity-user">
                                                </td>
                                                <td>
                                                    <p>{{ $customer->user->name }}</p>
                                                </td>
                                                <td>
                                                    {{ $customer->user->email }}
                                                </td>
                                                <td>
                                                    {{ $customer->user->phone }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Recent Customer ] end -->
                    @endif
                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
    </div>
@endsection


@push('head')

@endpush
@push('script')
    <script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>
    <!-- dashboard-custom js -->
    <script src="/assets/js/pages/dashboard-custom.js"></script>
@endpush