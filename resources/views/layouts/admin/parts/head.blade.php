<title>Imelar</title>
<!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 11]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- Meta -->
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
<link rel="icon" href="/assets/favicon.ico" type="image/x-icon">
<!-- fontawesome icon -->
<link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css">
<!-- animation css -->
<link rel="stylesheet" href="/assets/plugins/animation/css/animate.min.css">
<!-- notification css -->
<link rel="stylesheet" href="/assets/plugins/notification/css/notification.min.css">
<!-- pnotify css -->
<link rel="stylesheet" href="/assets/plugins/pnotify/css/pnotify.custom.min.css">
<!-- pnotify-custom css -->
<link rel="stylesheet" href="/assets/css/pages/pnotify.css">
<!-- vendor css -->
<link rel="stylesheet" href="/assets/css/style.css">

@stack('head')

