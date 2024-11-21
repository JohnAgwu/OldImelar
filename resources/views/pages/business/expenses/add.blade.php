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
                            <h5>Add Business Expense</h5>
                        </div>
                        <div class="card-block">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('business.expenses.store', [$business->id]) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row form-group">
                                    <div class="col-sm-7">
                                        <label class="col-form-label">Select Type</label>
                                        <select name="type" class="form-control" required>
                                            @foreach($business_expenses as $expense)
                                            <option value="{{ $expense }}">{{ $expense }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!--QUANTITY-->
                                    <div class="col-sm-12 col-md-5">
                                        <label class="col-form-label">Amount</label>
                                        <input type="text" name="amount" class="form-control autoCurrency" required>
                                    </div>

                                </div>


                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="col-form-label">Additional Information</label>
                                        <textarea name="info" class="form-control" cols="30" rows="10"></textarea>
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
            AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
        })();
    </script>
@endpush