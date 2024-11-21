<div class="navbar-wrapper">
    <div class="navbar-brand header-logo">
        <a href="{{ route('home') }}" class="b-brand">
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
                    <span class="pcoded-mtext">Main Dashboard</span>
                </a>
            </li>

            <li data-username="Animations" class="nav-item @if(request()->segment(3) == 'dashboard') active @endif">
                <a href="{{ route('business.dashboard', ['id' => $business->id]) }}" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="feather icon-home"></i>
                    </span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>

            <li data-username="Animations" class="nav-item @if(request()->segment(3) == 'customers') active @endif">
                <a href="{{ route('business.customers.index', [$business->id]) }}" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="fa fa-users"></i>
                    </span>
                    <span class="pcoded-mtext">Customers</span>
                </a>
            </li>

            @if($business->isFreelance())
                <li data-username="Animations" class="nav-item @if(request()->segment(3) == 'projects') active @endif">
                    <a href="{{ route('business.projects', [$business->id]) }}" class="nav-link">
                        <span class="pcoded-micon">
                            <i class="fa fa-list"></i>
                        </span>
                        <span class="pcoded-mtext">Projects</span>
                    </a>
                </li>
            @else
                <li data-username="Animations" class="nav-item @if(request()->segment(3) == 'products') active @endif">
                    <a href="{{ route('business.products', ['id' => $business->id]) }}" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="fa fa-file-invoice-dollar"></i>
                    </span>
                        <span class="pcoded-mtext">Products</span>
                    </a>
                </li>
            @endif

            <li data-username="Animations" class="nav-item @if(request()->segment(3) == 'invoice' && request()->segment(4) == null) active @endif">
                <a href="{{ route('business.invoices', ['id' => $business->id]) }}" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="fa fa-file-invoice-dollar"></i>
                    </span>
                    <span class="pcoded-mtext">Invoices</span>
                </a>
            </li>

            @if(!$business->isFreelance())
                <li data-username="Business" class="nav-item pcoded-hasmenu @if(request()->segment(3) == 'items-returned-to-supplier' || request()->segment(3) == 'items-returned-by-customer') active pcoded-trigger @endif">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-micon">
                            <i class="fa fa-retweet"></i>
                        </span>
                        <span class="pcoded-mtext">Returned Items</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="@if(request()->segment(3) == 'items-returned-to-supplier') active @endif">
                            <a href="{{ route('business.items.returned.to.supplier', ['id' => $business->id])  }}" class="">Items returned to supplier</a>
                        </li>

                        <li class="@if(request()->segment(3) == 'items-returned-by-customer') active @endif">
                            <a href="{{ route('business.items.returned.by.customer', ['id' => $business->id])  }}" class="">Items returned by customer</a>
                        </li>
                    </ul>
                </li>
            @endif

            <li data-username="Business" class="nav-item pcoded-hasmenu @if(request()->segment(3) == 'expenses' || request()->segment(3) == 'incomes') active pcoded-trigger @endif">
                <a href="#!" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="fa fa-money-bill"></i>
                    </span>
                    <span class="pcoded-mtext">Income & Expenses</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="@if(request()->segment(3) == 'incomes') active @endif">
                        <a href="{{ route('business.incomes.index', [$business->id])  }}" class="">Business Income</a>
                    </li>

                    <li class="@if(request()->segment(3) == 'expenses') active @endif">
                        <a href="{{ route('business.expenses.index', [$business->id])  }}" class="">Business Expenses</a>
                    </li>
                </ul>
            </li>

            <li data-username="Animations" class="nav-item @if(request()->segment(3) == 'receivables-and-payables') active @endif">
                <a href="{{ route('business.receivables.and.payables', ['id' => $business->id]) }}" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="mdi mdi-receipt"></i>
                    </span>
                    <span class="pcoded-mtext">Receivables and payables</span>
                </a>
            </li>

            <li data-username="Animations" class="nav-item @if(request()->segment(3) == 'activities') active @endif">
                <a href="{{ route('business.activities', ['id' => $business->id]) }}" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="fa fa-file-invoice"></i>
                    </span>
                    <span class="pcoded-mtext">Activities</span>
                </a>
            </li>


{{--            Settings --}}
            <li data-username="Business" class="nav-item pcoded-hasmenu @if(request()->segment(3) == 'settings') active pcoded-trigger @endif">
                <a href="#!" class="nav-link">
                    <span class="pcoded-micon">
                        <i class="mdi mdi-cogs"></i>
                    </span>
                    <span class="pcoded-mtext">settings</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="@if(request()->segment(3) == 'settings' && request()->segment(5) == 'edit') active @endif">
                        <a href="{{ route('business.edit', $business->id) }}">Edit Business</a>
                    </li>

                    <li class="@if(request()->segment(3) == 'settings' && request()->segment(4) == 'banks') active @endif">
                        <a href="{{ route('business.settings.banks', ['id' => $business->id]) }}">Bank Accounts</a>
                    </li>

                    <li class="@if(request()->segment(3) == 'settings' && request()->segment(4) == 'promotions') active pcoded-trigger @endif">
                        <a href="#!">Promotions</a>
                        <ul class="pcoded-submenu">
                            <li class="@if(request()->segment(3) == 'promotions' && request()->segment(4) == 'birthday') active @endif">
                                <a href="{{route('business.settings.promotions.birthday', ['id' => $business->id])}}" class="">Birthday</a>
                            </li>

                            <li class="@if(request()->segment(3) == 'promotions' && request()->segment(4) == 'holiday') active @endif">
                                <a href="{{route('business.settings.promotions.holiday', ['id' => $business->id])}}" class="">Holiday</a>
                            </li>

                            <li class="@if(request()->segment(3) == 'promotions' && request()->segment(4) == 'tell-a-friend') active @endif">
                                <a href="{{route('business.settings.promotions.tell-a-friend', ['id' => $business->id])}}" class="">Tell a friend and followup</a>
                            </li>

                            <li class="@if(request()->segment(3) == 'promotions' && request()->segment(4) == 'giveaways-and-freebies') active @endif">
                                <a href="{{route('business.settings.promotions.giveaways-and-freebies', ['id' => $business->id])}}" class="">Giveaways and freebies</a>
                            </li>
                        </ul>
                    </li>

{{--                    New Items Alert--}}
                    <li class="@if(request()->segment(3) == 'settings' && request()->segment(4) == 'new-item-alert') active @endif">
                        <a href="{{route('business.settings.new-item-alert', ['id' => $business->id])}}" class="">New Item Alert</a>
                    </li>
                </ul>
            </li>

{{--            <li data-username="Animations" class="nav-item @if(request()->segment(3) == 'Add admin') active @endif">--}}
{{--                <a href="{{ route('business.add.admin', ['id' => $business->id]) }}" class="nav-link">--}}
{{--                    <span class="pcoded-micon">--}}
{{--                        <i class="mdi mdi-history"></i>--}}
{{--                    </span>--}}
{{--                    <span class="pcoded-mtext">Add admin</span>--}}
{{--                </a>--}}
{{--            </li>--}}

{{--            <li data-username="Animations" class="nav-item @if(request()->segment(3) == 'settings') active @endif">--}}
{{--                <a href="{{ route('business.settings', ['id' => $business->id]) }}" class="nav-link">--}}
{{--                    <span class="pcoded-micon">--}}
{{--                        <i class="fa fa-cogs"></i>--}}
{{--                    </span>--}}
{{--                    <span class="pcoded-mtext">Settings</span>--}}
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
