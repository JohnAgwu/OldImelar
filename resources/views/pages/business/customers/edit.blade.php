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
                            <h5>Edit Customer</h5>
                        </div>
                        <div class="card-block">

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


                            <form method="POST" action="{{ route('business.customers.update', [$business->id, $customer->id]) }}" enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf

                                <div class="row form-group">

                                    <!--NAME-->
                                    <div class="col-sm-12">
                                        <label class="col-form-label">Full Name</label>
                                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $customer->user->name }}">

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <!--Email-->
                                    <div class="col-sm-12 col-md-6">
                                        <label class="col-form-label">Email Address</label>
                                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $customer->user->email }}">

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <!--Phone-->
                                    <div class="col-sm-12 col-md-6">
                                        <label class="col-form-label">Phone Number</label>
                                        <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Phone Number e.g 080293*****" name="phone" value="{{ $customer->user->phone }}" required maxlength="11">

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
                                            <option value="MALE" @if($customer->user->gender == 'MALE') selected @endif >MALE</option>
                                            <option value="FEMALE" @if($customer->user->gender == 'FEMALE') selected @endif>FEMALE</option>
                                        </select>
                                    </div>

                                    <!--DOB-->
                                    <div class="col-sm-12 col-md-6">
                                        <label class="col-form-label">Date of Birth</label>
                                        <input type="date" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" placeholder="Date of Birth" name="dob" value="{{ $customer->user->dob != null ? $customer->user->dob->format('Y-m-d') : '' }}" id="dob">

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
