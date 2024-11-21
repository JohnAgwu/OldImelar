<div class="navbar-wrapper">
    <div class="navbar-brand header-logo">
        <a href="/" class="b-brand">
            <img src="/assets/images/logo.png" alt="lock images" class="img-fluid" width="120">
{{--            <div class="b-bg">--}}
{{--                <i class="feather icon-trending-up"></i>--}}
{{--            </div>--}}
{{--            <span class="b-title">IMELAR</span>--}}
        </a>
        <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
    </div>
    <div class="navbar-content scroll-div">
        <ul class="nav pcoded-inner-navbar">
            <li data-username="Animations" class="nav-item @if(request()->segment(1) == null) active @endif">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="feather icon-home"></i>
                    </span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>

            <li data-username="Animations" class="nav-item @if(request()->segment(1) == 'wallet') active @endif">
                <a href="{{ route('wallet') }}" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="fa fa-wallet"></i>
                    </span>
                    <span class="pcoded-mtext">My Wallet</span>
                </a>
            </li>

            <li data-username="Animations" class="nav-item @if(request()->segment(1) == 'profile') active @endif">
                <a href="{{ route('profile') }}" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="feather icon-user"></i>
                    </span>
                    <span class="pcoded-mtext">Profile</span>
                </a>
            </li>

            <li data-username="Animations" class="nav-item @if(request()->segment(1) == 'invoices-received') active @endif">
                <a href="/invoices-received" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="fa fa-file-invoice"></i>
                    </span>
                    <span class="pcoded-mtext">Invoices Received</span>
                </a>
            </li>

{{--            <li data-username="Animations" class="nav-item @if(request()->segment(1) == 'products-purchased') active @endif">--}}
{{--                <a href="/products-purchased" class="nav-link">--}}
{{--                    <span class="pcoded-micon">--}}
{{--                        <i class="fa fa-list"></i>--}}
{{--                    </span>--}}
{{--                    <span class="pcoded-mtext">Products Purchased</span>--}}
{{--                </a>--}}
{{--            </li>--}}

            {{--<li data-username="Animations" class="nav-item @if(request()->segment(1) == 'vendors-patrotronized') active @endif">--}}
                {{--<a href="/vendors-patrotronized" class="nav-link">--}}
                    {{--<span class="pcoded-micon">--}}
                        {{--<i class="fa fa-users"></i>--}}
                    {{--</span>--}}
                    {{--<span class="pcoded-mtext">VENDORS PATRONIZED</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            {{--<li data-username="Animations" class="nav-item @if(request()->segment(1) == 'insights') active @endif">--}}
                {{--<a href="/insights" class="nav-link">--}}
                    {{--<span class="pcoded-micon">--}}
                        {{--<i class="fa fa-chart-area"></i>--}}
                    {{--</span>--}}
                    {{--<span class="pcoded-mtext">INSIGHTS</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            <li data-username="Business" class="nav-item pcoded-hasmenu @if(request()->segment(1) == 'business') active pcoded-trigger @endif">
                <a href="#!" class="nav-link">
                    <span class="pcoded-micon"><i class="fa fa-store"></i></span>
                    <span class="pcoded-mtext">Business</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="@if(request()->segment(1) == 'business' && request()->segment(2) == null) active @endif">
                        <a href="{{route('my-business')}}" class="">View All</a>
                    </li>
                    <li class="@if(request()->segment(1) == 'business' && request()->segment(2) == 'add') active @endif">
                        <a href="{{route('add-business')}}" class="">Add New</a>
                    </li>
                </ul>
            </li>

            @role('ADMIN')
                <li data-username="Animations" class="nav-item @if(request()->segment(1) == 'users') active @endif">
                    <a href="{{ route('users') }}" class="nav-link">
                        <span class="pcoded-micon">
                            <i class="feather icon-users"></i>
                        </span>
                        <span class="pcoded-mtext">Registered Users</span>
                    </a>
                </li>

                <li data-username="Animations" class="nav-item @if(request()->segment(1) == 'businesses') active @endif">
                    <a href="{{ route('businesses') }}" class="nav-link">
                        <span class="pcoded-micon">
                            <i class="feather icon-user"></i>
                        </span>
                        <span class="pcoded-mtext">Businesses</span>
                    </a>
                </li>
            @endrole

{{--            <li data-username="Settings" class="nav-item @if(request()->segment(1) == 'settings') active @endif">--}}
{{--                <a href="/settings" class="nav-link">--}}
{{--                    <span class="pcoded-micon">--}}
{{--                        <i class="feather icon-settings"></i>--}}
{{--                    </span>--}}
{{--                    <span class="pcoded-mtext">SETTINGS</span>--}}
{{--                </a>--}}
{{--            </li>--}}

            <li>
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="pcoded-micon">
                        <i class="fa fa-user-lock"></i>
                    </span>
                    <span class="pcoded-mtext">Logout</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
