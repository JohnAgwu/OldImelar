
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Imelar :: Invoice</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="imelar"/>
    <meta name="keywords" content="imelar">
    <meta name="author" content="Canaan Etai" />

    {{--Opengraph--}}
    <meta property="og:image" content="{{ asset('assets/images/logo.png') }}" />
    <meta property="og:image:secure_url" content="{{ asset('assets/images/logo.png') }}" />
    <meta property="og:image:type" content="image/png" />
    {{--<meta property="og:image:width" content="400" />--}}
    {{--<meta property="og:image:height" content="300" />--}}
    <meta property="og:image:alt" content="IMELA LOGO" />

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material/css/materialdesignicons.min.css') }}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/animation/css/animate.min.css') }}">
    <!-- notification css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/notification/css/notification.min.css') }}">
    <!-- pnotify css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/pnotify/css/pnotify.custom.min.css') }}">
    <!-- pnotify-custom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/pages/pnotify.css') }}">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style type="text/css">

    </style>

</head>

<body>


<div class="mt-3 ml-5" style="width: 1200px">
    <div class="card" id="invoice-base">


        <div class="d-flex mb-5">
            <div class="text-center p-3 w-50">
                <img src="{{ asset('storage/' . $page->image1)  }}" alt="Product 1" width="300">
            </div>
            <div class="text-center p-3 w-50">
                <img src="{{ asset('storage/' . $page->image2)  }}" alt="Product 1" width="300">
            </div>
        </div>

        <div class="d-flex mb-5 flex-column align-items-start">
            <div class="text-center pl-3 pb-2">
                <h4>Business Name: <b>{{ $page->business->name }}</b></h4>
            </div>
            <div class="text-center pl-3 pb-2">
                <h4>Phone Number: <b>{{ $page->business->phone }}</b></h4>
            </div>
        </div>

        <div class="d-flex mb-5 justify-content-center">
            @foreach($page->business->social as $social)
                <a href="/page/{{$page->ref}}" class="text-white label btn-default f-12 btn-shadow mr-3" target="_blank">
                    <b class="text-dark">Share with</b> <img src="{{ asset('assets/images/social-icon/'. $social['type'] .'.png') }}" alt="{{ $social['type'] }}" width="50">
                </a>
            @endforeach
        </div>


        <div class="card-block p-0 position-relative d-flex flex-column align-items-center">
            <div class="theme-bg2 w-25 position-absolute d-flex align-items-center justify-content-center" style="height: 35px; border-radius:50px 50px 0 0; bottom: 0;">
                <p class="text-center text-white mt-3">Thank you for you patronage</p>
            </div>

            <div class="theme-bg2 w-100 text-right pr-2" style="height: 25px;">
                <a href="{{env('APP_URL')}}" target="_blank">
                    <small class="text-white">Powered by {{ strtoupper(env('APP_NAME')) }}</small>
                </a>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('assets/plugins/jquery/js/jquery.min.js') }}"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="{{ asset('assets/plugins/inputmask/js/autoNumeric.js') }}"></script>
<script src="{{ asset('assets/js/pages/invoice-view.js') }}"></script>
</body>

</html>
