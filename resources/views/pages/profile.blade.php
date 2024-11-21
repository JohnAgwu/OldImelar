@extends('layouts.user.layout')

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
                            <h5>My Account</h5>
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

                            <form method="POST" action="{{ route('update-profile') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Name</label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="col-form-label">Email</label>
                                        <input type="text" name="email" value="{{ $user->email }}" class="form-control">
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="col-form-label">Phone</label>
                                        <input type="text" name="phone" value="{{ $user->phone }}" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="col-form-label">Address</label>
                                        <input type="text" name="address" value="{{ $user->address }}" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">

                                    <!--Channel-->
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Gender</label>
                                        <select name="gender" class="form-control">
                                            <option @if($user->gender === 'MALE') selected @endif value="MALE">MALE</option>
                                            <option @if($user->gender === 'FEMALE') selected @endif value="FEMALE">FEMALE</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">Date of birth</label>
                                        <input type="text" name="dob" value="{{ $user->dob }}" id="dob" class="form-control">
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

@push('head')
    <link rel="stylesheet" href="/assets/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css">
@endpush

@push('script')
    <!-- bootstrap-maxlength Js -->
    <script src="{{ asset('assets/plugins/bootstrap-maxlength/js/bootstrap-maxlength.min.js') }}"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script src="/assets/plugins/material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <script>
        (function () {
            $('textarea.max-textarea').maxlength({
                alwaysShow: true
            });

            $(document).find('#dob').bootstrapMaterialDatePicker({
                weekStart: 0,
                time: false
            });
        })();
    </script>
@endpush