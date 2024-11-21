<!DOCTYPE html>
<html lang="en">

<head>
    <title>Email Verification - Imelar</title>
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
    <meta name="author" content="CodedThemes" />

    <!-- Favicon icon -->
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="/assets/plugins/animation/css/animate.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="/assets/css/style.css">

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
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="col-sm-10">
                                <div class="mb-4">
                                    <i class="feather icon-mail auth-icon"></i>
                                </div>
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <h3 class="mb-4">Reset Password</h3>
                                    <div class="input-group mb-3">
                                        <input type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-4 shadow-2">Reset Password</button>
                                </form>
                                <p class="mb-0 text-muted">Back to <a href="{{ route('login') }}">Login</a></p>
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
</body>

</html>
