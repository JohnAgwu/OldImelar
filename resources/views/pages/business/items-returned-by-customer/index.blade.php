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
                                <h5>ITEMS RETURNED BY CUSTOMER</h5>
                                <div class="card-header-right">
                                    <div class="btn-group card-option">
                                        <a class="text-white label theme-bg2 btn-shadow pt-2" href="{{ route('business.add.item.returned.by.customer', ['id' => $business->id]) }}">
                                            <i class="fa fa-plus"></i> <b>Add Item</b>
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
                                <div class="table-responsive pb-5">
                                    <table id="items-returned-table" class="display table dt-responsive nowrap table-striped table-hover" style="width:100%" bid="{{ $business->id }}">
                                        <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Invoice NO</th>
                                            <th>Quantity Returned</th>
                                            <th>Amount Refunded</th>
                                            <th>Date</th>
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
    <script src="{{ asset('assets/js/pages/items-returned-by-customer.js') }}"></script>
@endpush