<header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed header-purple">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
        <a href="/" class="b-brand">
            <img src="/assets/images/logo.png" alt="lock images" class="img-fluid" width="120">
{{--            <div class="b-bg">--}}
{{--                <i class="feather icon-trending-up"></i>--}}
{{--            </div>--}}
{{--            <span class="b-title">IMELAR</span>--}}
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="#!">
        <i class="feather icon-more-horizontal"></i>
    </a>

    <div class="text-center w-100">
        <h4 class="text-white font-weight-bold">{{ $business->name ?? '' }}</h4>
    </div>
</header>