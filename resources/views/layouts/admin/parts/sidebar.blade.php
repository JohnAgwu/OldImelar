<div class="navbar-wrapper">
    <div class="navbar-brand header-logo">
        <a href="/" class="b-brand">
            <img src="/assets/images/logo.png" alt="lock images" class="img-fluid" width="120">
{{--            <div class="b-bg">--}}
{{--                <i class="feather icon-trending-up"></i>--}}
{{--            </div>--}}
            <span class="b-title">IMELAR</span>
        </a>
        <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
    </div>
    <div class="navbar-content scroll-div">
        <ul class="nav pcoded-inner-navbar">
            <li data-username="Animations" class="nav-item @if(request()->segment(1) == null) active @endif">
                <a href="/" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="feather icon-home"></i>
                    </span>
                    <span class="pcoded-mtext">DASHBOARD</span>
                </a>
            </li>

            <li data-username="Animations" class="nav-item @if(request()->segment(1) == 'invoice') active @endif">
                <a href="/invoice" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="fa fa-file-invoice"></i>
                    </span>
                    <span class="pcoded-mtext">INVOICE</span>
                </a>
            </li>

            <li data-username="Animations" class="nav-item @if(request()->segment(1) == 'terminals') active @endif">
                <a href="/terminals" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="feather icon-tablet"></i>
                    </span>
                    <span class="pcoded-mtext">TERMINALS</span>
                </a>
            </li>

            <li data-username="Animations" class="nav-item @if(request()->segment(1) == 'staff') active @endif">
                <a href="/staff" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="feather icon-users"></i>
                    </span>
                    <span class="pcoded-mtext">STAFF</span>
                </a>
            </li>

            <li data-username="Animations" class="nav-item @if(request()->segment(1) == 'merchants') active @endif">
                <a href="/merchants" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="feather icon-users"></i>
                    </span>
                    <span class="pcoded-mtext">MERCHANTS</span>
                </a>
            </li>

            <li data-username="Animations" class="nav-item @if(request()->segment(1) == 'enquiries') active @endif">
                <a href="/enquiries" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="feather icon-info"></i>
                    </span>
                    <span class="pcoded-mtext">FEEDBACK | ENQUIRY</span>
                </a>
            </li>
        </ul>
    </div>
</div>