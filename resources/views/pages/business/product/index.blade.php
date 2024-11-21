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
                                <h5>PRODUCTS</h5>
                                <div class="card-header-right">
                                    <div class="card-option">
                                        <a class="text-white label theme-bg btn-shadow" href="{{ route('business.add.product', [$business->id]) }}">
                                            <i class="fa fa-plus"></i>
                                            <b class="d-none d-sm-inline">Add Product</b>
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
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Qty purchased</th>
                                            <th>Payment Status</th>
{{--                                            <th>Total Purchase Price</th>--}}
{{--                                            <th>Amount Paid</th>--}}
{{--                                            <th>Purchase Expenses</th>--}}
{{--                                            <th>Min Selling Price</th>--}}
{{--                                            <th>Max Selling Price</th>--}}
                                            <th>Last Updated</th>
                                            <th class="text-right"></th>
                                        </tr></thead>
                                        <tbody>

                                        @foreach( $business->products()->orderBy('id','desc')->get() as $product )
                                            <tr>
                                                <td>
                                                    <img class="m-r-10" style="width:50px;" src="{{ $product->image ? asset('storage/'. $product->image->path) : '' }}" alt="activity-user">
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $product->name }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">
                                                        <a href="{{ route('business.stocks.product', [$business->id, $product->id]) }}">
                                                            {{ number_format($product->quantity) }}
                                                        </a>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0">{{ $product->payment_status }}</h6>
                                                </td>
{{--                                                <td>--}}
{{--                                                    <h6 class="m-0 autoCurrency">{{ $product->total_purchase_price }}</h6>--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    <h6 class="m-0 autoCurrency">{{ $product->amount_paid }}</h6>--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    <h6 class="m-0 autoCurrency">{{ $product->purchase_expenses }}</h6>--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    <h6 class="m-0 autoCurrency">{{ $product->min_selling_price }}</h6>--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    <h6 class="m-0 autoCurrency">{{ $product->max_selling_price }}</h6>--}}
{{--                                                </td>--}}
                                                <td>
{{--                                                    <h6 class="m-0">{{ $product->created_at->format('d-m-Y h:i:s') }}</h6>--}}
                                                    <h6 class="m-0">{{ $product->stocks->count() > 0 ? $product->stocks->last()->created_at->format('d-m-Y h:i:s') : '' }}</h6>
                                                </td>

                                                <td>
                                                    <a href="{{ route('business.restock.product', [$business->id, $product->id]) }}" class="text-white label btn-primary f-12 btn-shadow">Restock</a>
                                                    <a href="{{ route('business.edit.product', [$business->id, $product->id]) }}" class="text-white label theme-bg2 f-12 btn-shadow">Edit</a>

                                                    <a id="delete-product" href="{{ route('business.delete.product', [$business->id, $product->id]) }}" class="text-white label theme-bgo f-12 btn-shadow">Delete</a>
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
    <script src="{{ asset('assets/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="/assets/js/pages/dashboard-custom.js"></script>
    <script>
        $(document).ready(function() {
            AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
            AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0})
            // $('.autonumber').autoNumeric('init');


            $(document).on('click', '#delete-product', function (e) {
                e.preventDefault();

                swal({
                    title: "Are you sure?",
                    text: "This product and related data will be deleted as well!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if ( willDelete ) {
                            window.location.href = $(this).attr('href');
                        }

                        return false;
                    });
            })
        });
    </script>
@endpush