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
                                <h5>Product History for "{{ $product->name }}"</h5>
                                <div class="card-header-right">
                                    <div class="card-option">
                                        <a class="text-white label theme-bg btn-shadow" href="{{ route('business.restock.product', [$business->id, $product->id]) }}">
                                            <i class="fa fa-plus"></i>
                                            <b class="d-none d-sm-inline">Re-Stock</b>
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

                                <div class="table-responsive">
                                    <table class="table table-hover" id="mytable">
                                        <thead>
                                        <tr>
                                            <th>Quantity</th>
                                            <th>Payment Status</th>
                                            <th>Total Purchase Price</th>
                                            <th>Amount Paid</th>
                                            <th>Purchase Expenses</th>
                                            <th>Date</th>
                                            <th class="text-right"></th>
                                        </tr></thead>
                                        <tbody>

                                        @foreach( $product->stocks as $stock )
                                            <tr>
                                                <td>
                                                    <h6 class="m-0">{{ number_format($stock->quantity) }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $product->payment_status }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0 autoCurrency">{{ $stock->total_purchase_price }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0 autoCurrency">{{ $stock->amount_paid }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0 autoCurrency">{{ $stock->purchase_expenses }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $stock->created_at->format('d-m-Y h:i:s') }}</h6>
                                                </td>

                                                <td>
{{--                                                    <a href="{{ route('business.restock.product', [$business->id, $product->id]) }}" class="text-white label btn-primary f-12 btn-shadow">Restock</a>--}}
{{--                                                    <a href="{{ route('business.edit.product', [$business->id, $product->id]) }}" class="text-white label theme-bg2 f-12 btn-shadow">Edit</a>--}}
                                                    <a href="{{ route('business.delete.stock', [$business->id, $stock->id]) }}" class="text-white label theme-bgo f-12 btn-shadow" onclick="return confirm('Are you sure that you want to delete this item?')">Delete</a>
                                                </td>

                                            </tr>
                                        @endforeach


                                        </tbody>
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
    <script>
        $(document).ready(function() {
            $('#mytable').dataTable({searching: false});

            AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
            AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0})
            // $('.autonumber').autoNumeric('init');
        });
    </script>
@endpush