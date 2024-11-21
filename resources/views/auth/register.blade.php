<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign up - Imelar</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Canaan Etai" />

    <!-- Favicon icon -->
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="/assets/plugins/animation/css/animate.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <link rel="stylesheet" href="/assets/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css">

</head>

<body>
<div class="auth-wrapper">

    <div class="auth-content subscribe">
        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-4 col-lg-6 d-none d-md-flex d-lg-flex theme-bg2 align-items-center justify-content-center flex-column">
                    <img src="/assets/images/imelar.png" alt="lock images" class="img-fluid" width="50%">
{{--                    <h2 class="text-white font-weight-bold">imelar</h2>--}}
                </div>
                <div class="col-md-8 col-lg-6">
                    <div class="card-body text-center">
                        <div class="row justify-content-center">
                            <div class="col-sm-10 text-left">
                                <div class="mb-4 d-md-none">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="Imelar Logo" width="80">
                                </div>
                                <h3 class="mb-4">Sign Up</h3>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    {{--Name--}}
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Name</label>
                                        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Full name" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    {{--Email--}}
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Email Address</label>
                                        <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email Address" name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    {{--Phone--}}
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Phone Number</label>
                                        <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Phone Number e.g 080293*****" name="phone" value="{{ old('phone') }}" required maxlength="11">

                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    {{--Date of birth--}}
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Date Of Birth</label>
                                        <input type="text" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" placeholder="Date of Birth" name="dob" value="{{ old('dob') }}" id="dob" required autofocus>

                                        @if ($errors->has('dob'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('dob') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    {{--Gender--}}
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Gender</label>
                                        <select name="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" required autofocus>
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </select>

                                        @if ($errors->has('gender'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('gender') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    {{--Password--}}
                                    <div class="form-group mb-4">
                                        <label class="col-form-label">Password</label>
                                        <input type="password" placeholder="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary shadow-2 mb-4">Sign Up</button>
                                    </div>
                                </form>

                                <div class="text-center">
                                    <p class="mb-2 text-muted">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Required Js -->
<script src="/assets/js/vendor-all.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/plugins/bootstrap-maxlength/js/bootstrap-maxlength.min.js"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="/assets/plugins/material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script>
    (function () {
        $('input[maxlength]').maxlength({
            alwaysShow: true,
            placement: 'top'
        });

        $(document).find('#dob').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false
        });
    })();
</script>

</body>

</html>
