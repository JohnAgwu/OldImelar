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
                            <h5>Add Bank</h5>
                            <span class="d-block m-t-5">Add a new <code>BANK</code> account</span>
                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{ route('business.settings.save.add.bank', ['business_id' => $business->id]) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Select Pank</label>
                                        <select name="bank" class="form-control" required>
                                            @foreach($banks as $bank)
                                            <option value="{{ json_encode($bank) }}">{{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!--ACCOUNT NAME-->
                                    <div class="col-sm-12 col-md-4">
                                        <label class="col-form-label">Account Name</label>
                                        <input type="text" name="account_name" class="form-control">
                                    </div>

                                    <!--ACCOUNT NUMBER-->
                                    <div class="col-sm-12 col-md-4">
                                        <label class="col-form-label">Account Number</label>
                                        <input minlength="10" maxlength="10" type="text" name="account_number" class="form-control" required>
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
