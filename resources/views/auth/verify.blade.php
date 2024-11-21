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
    <meta name="author" content="Canaan Etai" />

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
                            <div class="col-sm-10">
                                <h3 class="mb-4">Verify Your Email Address</h3>

                                @if (session('resent'))
                                    <div class="alert alert-success" role="alert">
                                        {{ __('A fresh verification link has been sent to your email address.') }}
                                    </div>
                                @endif


                                {{ __('Before proceeding, please check your email for a verification link.') }}
                                {{ __('If you did not receive the email') }},
                                <div class="d-inline">
                                    <form action="{{ route('verification.resend') }}" method="post">
                                        @csrf
                                        <button type="submit" class="border-0 py-2 bg-white">
                                            <span class="pl-3">{{ __('click here to request another') }}</span>
                                        </button>
                                    </form>
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
</body>

</html>
