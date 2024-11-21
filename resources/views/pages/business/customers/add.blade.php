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
                            <h5>Add Customer</h5>
                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{ route('business.customers.store', [$business->id]) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row form-group">

                                    <!--NAME-->
                                    <div class="col-sm-12">
                                        <label class="col-form-label">Full Name</label>
                                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}">

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <!--Email-->
                                    <div class="col-sm-12 col-md-6">
                                        <label class="col-form-label">Email Address</label>
                                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <!--Phone-->
                                    <div class="col-sm-12 col-md-6">
                                        <label class="col-form-label">Phone Number</label>
                                        <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Phone Number e.g 080293*****" name="phone" value="{{ old('phone') }}" required maxlength="11">

                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <!--Gender-->
                                    <div class="col-sm-12 col-md-6">
                                        <label class="col-form-label">Gender</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </select>
                                    </div>

                                    <!--DOB-->
                                    <div class="col-sm-12 col-md-6">
                                        <label class="col-form-label">Date of Birth</label>
                                        <input type="date" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" placeholder="Date of Birth" name="dob" value="{{ old('dob') }}" id="dob">

                                        @if ($errors->has('dob'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('dob') }}</strong>
                                            </span>
                                        @endif
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
