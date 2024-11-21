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
                        <div class="card-header">
                            <h5>Add Item</h5>
                            <span class="d-block m-t-5">Add a new <code>ITEM</code></span>
                        </div>
                        <div class="card-block">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('business.save.item.returned.to.supplier', [$business->id]) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Select Product</label>
                                        <select name="product_id" class="form-control" required>
                                            @foreach($business->products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!--QUANTITY-->
                                    <div class="col-sm-12 col-md-4">
                                        <label class="col-form-label">Quantity Returned</label>
                                        <input type="text" name="quantity" class="form-control autonumber" required>
                                    </div>

                                    <!--Amount-->
                                    <div class="col-sm-12 col-md-4">
                                        <label class="col-form-label">Amount Refunded</label>
                                        <input type="text" name="amount" class="form-control autocurrency" required>
                                    </div>

                                </div>

                                <div class="row form-group">
                                    <!--Expenses-->
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Select Expenses</label>
                                        <select name="expenses" class="form-control" required>
                                            @foreach($purchaseExpenses as $expenses)
                                                <option value="{{ $expenses }}">{{ $expenses }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!--Amount-->
                                    <div class="col-sm-12 col-md-4">
                                        <label class="col-form-label">Expense Amount</label>
                                        <input type="text" name="expenses_amount" class="form-control autocurrency" required>
                                    </div>
                                </div>

                                <!-- SUBMIT BUTTON-->
                                <div class="row">
                                    <div class="col-sm-12 text-center mt-5">
                                        <button class="btn text-white label theme-bg btn-shadow">
                                            <i class="fa fa-paper-plane"></i>
                                            <b>Submit</b>
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>
    <script>
        (function () {
            AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0});
            AutoNumeric.multiple('.autocurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
        })();
    </script>
@endpush