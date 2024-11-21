@extends('layouts.user.layout')

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
                                <h5>INVOICES RECEIVED</h5>
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
                                    <table id="invoice-received-table" class="display table dt-responsive nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Business</th>
                                            <th>Products</th>
                                            <th>Total Quantity</th>
                                            <th>Selling Price</th>
                                            <th>Amount Paid</th>
                                            <th>Payment Status</th>
                                            <th>Payment Method</th>
                                            <th>Payment Date</th>
                                            <th>Due Date</th>
                                            <th>Expenses Incurred</th>
                                            <th>Dispatch Date</th>
                                            <th>Date Created</th>
                                            <th class="text-right"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $invoices as $invoice )
                                            <tr>
                                                <td>{{ $invoice->business->name }}</td>
                                                <td>
                                                    @foreach($invoice->products as $iv)
                                                        {{ $iv->product->name }} <br/>
                                                    @endforeach
                                                </td>
                                                <td>{{ $invoice->products->sum('quantity') }}</td>
                                                <td>₦{{ number_format($invoice->products->sum('amount')) }}</td>
                                                <td>₦{{ number_format($invoice->amount_paid) }}</td>
                                                <td>{{ $invoice->payment_status }}</td>
                                                <td>{{ $invoice->payment_method }}</td>
                                                <td>{{ !is_null($invoice->payment_date) ? $invoice->payment_date->format('Y-m-d') : '' }}</td>
                                                <td>{{ $invoice->payment_due_date }}</td>
                                                <td>{{ $invoice->expenses_incurred }}</td>
                                                <td>{{ $invoice->dispatched_at == null ? '' : $invoice->dispatched_at->format('Y-m-d') }}</td>
                                                <td>{{ $invoice->created_at->format('Y-m-d') }}</td>

                                                <td>
                                                    <a href="{{route('user.invoices.view', $invoice->id)}}" class="btn btn-sm theme-bg2 text-white">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    {{ $invoices->links() }}
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
{{--    <script src="{{ asset('assets/js/pages/invoice.js') }}"></script>--}}
@endpush