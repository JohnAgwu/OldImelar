@extends('layouts.business.layout')

@section('content')
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->

        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->

                <div>
                    <div class="card">
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

                        <div class="card-header">
                            <h5>Send Invoice</h5>
                            <span class="d-block m-t-5">Send an <code>INVOICE</code></span>
                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{ route('business.save.send.invoice', ['business_id' => $business->id]) }}" enctype="multipart/form-data">
                                @csrf

                                <send-invoice product-id="{{ $product_id }}" business="{{ $business }}" customers="{{ $customers }}" payment-status="{{ $paymentStatus }}" payment-methods="{{ $paymentMethods }}" banks="{{ $banks }}" channels="{{ $channels }}" business-expenses="{{ $businessExpenses }}">
                                    <div class="mt-5 mb-5 text-center">
                                        <i class="text-black-50 fa fa-spinner fa-spin fa-3x"></i>
                                    </div>
                                </send-invoice>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('head')
    <link rel="stylesheet" href="{{ asset('assets/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">

    <!-- select2 css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

@endpush
@push('script')

    <!-- Input mask Js -->
    <script src="{{ asset('assets/plugins/inputmask/js/inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>

    <!-- material datetimepicker Js -->
    <script src="{{ asset('assets/plugins/moment/js/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

    <!-- select2 Js -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>


    <script src="{{ asset('assets/js/business/send-invoice.js') }}"></script>
@endpush