<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Landing page, Template, Business, Service">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="Grayrids">
    <title>Imelar - Free Tools for Side-hustlers</title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="/landing//landing/img/icon.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/landing/css/bootstrap.min.css">
    <link rel="stylesheet" href="/landing/css/animate.css">
    <link rel="stylesheet" href="/landing/css/LineIcons.css">
    <link rel="stylesheet" href="/landing/css/LineIcons.min.css" >
    <link rel="stylesheet" href="/landing/css/owl.carousel.css">
    <link rel="stylesheet" href="/landing/css/owl.theme.css">
    <link rel="stylesheet" href="/landing/css/magnific-popup.css">
    <link rel="stylesheet" href="/landing/css/nivo-lightbox.css">
    <link rel="stylesheet" href="/landing/css/main.css">
    <link rel="stylesheet" href="/landing/css/responsive.css">

</head>

<body>

<!-- Header Section Start -->
<header id="home" class="hero-area">
    <div class="overlay">
        <span></span>
    </div>
    <nav class="navbar navbar-expand-md bg-inverse fixed-top scrolling-navbar">
        <div class="container">
            <a href="index.html" class="navbar-brand"><img src="/landing/img/imelar_logo3.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="lni-menu"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto w-100 justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="https://blog.imelar.com/" target="_blank">Blog</a>
                    </li>
                    @if(auth()->check())
                        <li class="nav-item">
                            <a class="nav-link page-scroll" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link page-scroll" href="/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link page-scroll" href="/register">Get started</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row space-100">
            <div class="col-lg-6 col-md-12 col-xs-12">
                <div class="contents">
                    <h2 class="head-title">Free business tools<br>for Side-hustlers</h2>
                    <p>Win the hearts of your customers and convert more prospects.<br>Keep track of your hustle and earn more on imelar.</p>
                    <div class="header-button">
                        @if(auth()->check())
                            <a href="{{ route('dashboard') }}" class="btn btn-border-filled">Dashboard</a>
                        @else
                            <a href="/register" class="btn btn-border-filled">Get Started</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-xs-12 p-0">
                <div class="intro-img">
                    <img src="/landing/img/business-img.png" alt="">
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header Section End -->

<!-- Cool Fetatures Section Start -->
<section id="features" class="section">
    <div class="container">
        <!-- Start Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="features-text section-header text-center">
                    <div>
                        <h2 class="section-title">Features</h2>
                        <div class="desc-text">
                            <p>Free business tools you can adopt to boost your side hustle <br> and give it a touch of class.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Row -->
        <!-- Start Row -->
        <div class="row featured-bg">
            <!-- Start Col -->
            <div class="col-lg-6 col-md-6 col-xs-12 p-0">
                <!-- Start Fetatures -->
                <div class="feature-item featured-border1">
                    <div class="feature-icon float-left">
                        <i class="lni-licencse"></i>
                    </div>
                    <div class="feature-info float-left">
                        <h4>Invoice</h4>
                        <p>Send invoices to your customers <br> through SMS, WhatsApp or Email<br> in very simple ways.</p>
                    </div>
                </div>
                <!-- End Fetatures -->
            </div>
            <!-- End Col -->

            <!-- Start Col -->
            <div class="col-lg-6 col-md-6 col-xs-12 p-0">
                <!-- Start Fetatures -->
                <div class="feature-item featured-border2">
                    <div class="feature-icon float-left">
                        <i class="lni-wallet"></i>
                    </div>
                    <div class="feature-info float-left">
                        <h4>Payment</h4>
                        <p>Secure payment gateway integration <br> with Paystack to enable your customers<br>pay you from anywhere anytime.</p>
                    </div>
                </div>
                <!-- End Fetatures -->
            </div>
            <!-- End Col -->

            <!-- Start Col -->
            <div class="col-lg-6 col-md-6 col-xs-12 p-0">
                <!-- Start Fetatures -->
                <div class="feature-item featured-border1">
                    <div class="feature-icon float-left">
                        <i class="lni-credit-cards"></i>
                    </div>
                    <div class="feature-info float-left">
                        <h4>Credit</h4>
                        <p>You can sell on credit and have your customers<br>set up direct debit for automatic payment.<br> You also become eligible for credit overtime.</p>
                    </div>
                </div>
                <!-- End Fetatures -->
            </div>
            <!-- End Col -->

            <!-- Start Col -->
            <div class="col-lg-6 col-md-6 col-xs-12 p-0">
                <!-- Start Fetatures -->
                <div class="feature-item featured-border2">
                    <div class="feature-icon float-left">
                        <i class="lni-layers"></i>
                    </div>
                    <div class="feature-info float-left">
                        <h4>Inventory</h4>
                        <p>Keep track of your product purchase history, <br> available stock quantity and re-order level.<br></p>
                    </div>
                </div>
                <!-- End Fetatures -->
            </div>
            <!-- End Col -->

            <!-- Start Col -->
            <div class="col-lg-6 col-md-6 col-xs-12 p-0">
                <!-- Start Fetatures -->
                <div class="feature-item featured-border3">
                    <div class="feature-icon float-left">
                        <i class="lni-emoji-happy"></i>
                    </div>
                    <div class="feature-info float-left">
                        <h4>Customer management</h4>
                        <p>Win the hearts of your customers by exploring<br>our promotional and loyalty tools.<br>We're redefining your customers' perception.</p>
                    </div>
                </div>
                <!-- End Fetatures -->
            </div>
            <!-- End Col -->

            <!-- Start Col -->
            <div class="col-lg-6 col-md-6 col-xs-12 p-0">
                <!-- Start Fetatures -->
                <div class="feature-item">
                    <div class="feature-icon float-left">
                        <i class="lni-bar-chart"></i>
                    </div>
                    <div class="feature-info float-left">
                        <h4>Expense and Income record</h4>
                        <p>Keep track of your expenses and income. <br> Monitor how you spend your capital and profit<br></p>
                    </div>
                </div>
                <!-- End Fetatures -->
            </div>
            <!-- End Col -->


        </div>
        <!-- End Row -->
    </div>
</section>
<!-- Cool Fetatures Section End -->

<!-- Suggestion Section -->
<section id="contact" class="section">
    <!-- Container Starts -->
    <div class="container" id="container2">
        <!-- Start Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="contact-text section-header text-center">
                    <div>
                        <h2 class="section-title">Your suggestions</h2>
                        <div class="desc-text">
                            <p>We'd love to get your suggestions</p>
                            <p>on how we can improve our services</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Row -->
        <!-- Start Row -->
        <div class="row">
            <!-- Start Col -->
            <div class="col-lg-6 col-md-12">
                <form id="contactForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required data-error="Please enter your name">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" placeholder="Subject" id="msg_subject" class="form-control" name="msg_subject" required data-error="Please enter your subject">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" required data-error="Please enter your Email">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" id="message"  name="message" placeholder="Write Message" rows="4" data-error="Write your message" required></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="submit-button">
                                <button class="btn btn-common" id="submit" type="submit">Submit</button>
                                <div id="msgSubmit" class="h3 hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Col -->
            <!-- Start Col -->
            <div class="col-lg-1">

            </div>
            <!-- End Col -->
            <!-- Start Col -->
            <div class="col-lg-4 col-md-12">
                <div class="contact-img">
                    <img src="/landing/img/contact/01.png" class="img-fluid" alt="">
                </div>
            </div>
            <!-- End Col -->
            <!-- Start Col -->
            <div class="col-lg-1">
            </div>
            <!-- End Col -->

        </div>
        <!-- End Row -->
    </div>
    <</section>
<!-- Contact Us Section End -->

<!-- Footer Section Start -->
<footer>
    <!-- Footer Area Start -->
    <section id="footer-Content">
        <div class="container">
            <!-- Start Row -->
            <div class="row">

                <!-- Start Col -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">

                    <div class="footer-logo">
                        <img src="/landing/img/imelar_logo3.png" alt="">
                    </div>
                </div>
                <!-- End Col -->
                <!-- Start Col -->

                <!-- Start Col -->
                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                    <div class="widget">
                        <h3 class="block-title">Features</h3>
                        <ul class="menu">
                            <li> - Invoice</li>
                            <li> - Payment</li>
                            <li>- Credit</li>
                            <li> - Inventory</li>
                            <li> - Customer management</li>
                            <li> - Expense and Income record</li>
                        </ul>
                    </div>
                </div>
                <!-- End Col -->

                <!-- Start Col -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                    <div class="widget">
                        <h3 class="block-title" id = "block-title2">Contact us:</h3>
                        <p>support@imelar.com</p>
                        <div class="social_media">
                            <a href= "https://www.instagram.com/myimelar"><i class="lni-instagram so_icon"></i></a>
                            <a href= "https://www.twitter.com/myimelar"><i class="lni-twitter so_icon"></i></a>
                            <a href= "https://www.facebook.com/myimelar"><i class="lni-facebook so_icon"></i></a>
                        </div>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- Copyright Start  -->

        <div class="copyright">
            <div class="container">
                <!-- Star Row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="site-info text-center">
                            <p>&copyCopyright 2019</a></p>
                        </div>

                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
        </div>
        <!-- Copyright End -->
    </section>
    <!-- Footer area End -->

</footer>
<!-- Footer Section End -->


<!-- Go To Top Link -->
<a href="#" class="back-to-top">
    <i class="lni-chevron-up"></i>
</a>

<!-- Preloader -->
<div id="preloader">
    <div class="loader" id="loader-1"></div>
</div>
<!-- End Preloader -->

<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="/landing/js/jquery-min.js"></script>
<script src="/landing/js/popper.min.js"></script>
<script src="/landing/js/bootstrap.min.js"></script>
<script src="/landing/js/owl.carousel.js"></script>
<script src="/landing/js/jquery.nav.js"></script>
<script src="/landing/js/scrolling-nav.js"></script>
<script src="/landing/js/jquery.easing.min.js"></script>
<script src="/landing/js/nivo-lightbox.js"></script>
<script src="/landing/js/jquery.magnific-popup.min.js"></script>
<script src="/landing/js/main.js"></script>

</body>
</html>
