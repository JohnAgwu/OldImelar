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
                                <h5>PRODUCTS PURCHASED</h5>
                                <div class="card-header-right">
                                    <div class="card-option">

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

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>In Stock</th>
                                            <th>Payment Status</th>
                                            <th>Total Purchase Price</th>
                                            <th>Amount Paid</th>
                                            <th>Purchase Expenses</th>
                                            <th>Date Created</th>
                                        </tr></thead>
                                        <tbody>

                                        @foreach( $products as $product )
                                            <tr>
                                                <td>
                                                    <img class="m-r-10" style="width:50px;" src="{{ asset('storage/'. $product->image->path) }}" alt="activity-user">
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $product->name }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">
                                                        {{ number_format($product->quantity) }}
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $product->payment_status }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0 autoCurrency">{{ $product->total_purchase_price }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0 autoCurrency">{{ $product->amount_paid }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0 autoCurrency">{{ $product->purchase_expenses }}</h6>
                                                </td>
{{--                                                <td>--}}
{{--                                                    <h6 class="m-0 autoCurrency">{{ $product->min_selling_price }}</h6>--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    <h6 class="m-0 autoCurrency">{{ $product->max_selling_price }}</h6>--}}
{{--                                                </td>--}}
                                                <td>
                                                    <h6 class="m-0">{{ $product->created_at->format('F jS, Y') }}</h6>
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

@endpush
@push('script')
    <script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>
    <script>
        $(document).ready(function() {
            AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
            AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0})
            // $('.autonumber').autoNumeric('init');
        });
    </script>
@endpush