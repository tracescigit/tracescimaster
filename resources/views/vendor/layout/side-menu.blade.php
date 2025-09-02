@extends('layout.main')

@section('head')
@yield('subhead')
@endsection

@section('content')
@include('vendor.layout.components.mobile-menu')
<div class="flex">
    <!-- BEGIN: Side Menu -->
    <nav class="side-nav">
        <a href="{{ url('/vendor') }}" class="intro-x flex items-center pl-5 pt-4">
            <img width="60%"  alt="Tracesci" src="{{asset('web/images/logo.png')}}" class="hidden xl:block"></a>
        </a>
        <div class="side-nav__devider my-6"></div>
        <ul>
            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'dashboard','view'))
            <li>
                <a href="{{ url('vendor') }}" class="side-menu {{request()->is('vendor')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="home"></i>
                    </div>
                    <div class="side-menu__title">
                        Dashboard
                    </div>
                </a>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'plans-credits','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'my-invoices','view'))
            <li>
                <a href="javascript:;" class="side-menu {{(request()->is('vendor/credits*') || request()->is('vendor/invoices*') || request()->is('vendor/qr-labels/create'))?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="printer"></i>
                    </div>
                    <div class="side-menu__title">
                        Credits & Invoices

                        <div class="side-menu__sub-icon">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>

                <ul class="{{(request()->is('vendor/credits*') || request()->is('vendor/invoices*') || request()->is('vendor/qr-labels/create'))?'side-menu__sub-open':''}}">
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'plans-credits','view'))
                    <li>
                        <a href="{{ url('vendor/credits') }}" class="side-menu {{request()->is('vendor/credits*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Plans & Credits
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'qr-labels','modify'))
                    <li>
                        <a href="{{ url('vendor/qr-labels/create') }}" class="side-menu {{request()->is('vendor/qr-labels/create')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Get your labels
                            </div>
                        </a>
                    </li>
                    @endif
                    @if(inAllowedPermissionsByModuleSlug(Auth::id(),'my-invoices','view'))
                    <li>
                        <a href="{{ url('vendor/invoices') }}" class="side-menu {{request()->is('vendor/invoices*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Invoices
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'products','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'batches','view'))
            <li>
                <a href="javascript:;" class="side-menu {{(request()->is('vendor/products*') || request()->is('vendor/batches*'))?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="plus"></i>
                    </div>
                    <div class="side-menu__title">
                        Products & Batches

                        <div class="side-menu__sub-icon">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>

                <ul class="{{(request()->is('vendor/products*') || request()->is('vendor/batches*'))?'side-menu__sub-open':''}}">
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'products','view'))
                    <li>
                        <a href="{{ url('vendor/products') }}" class="side-menu {{request()->is('vendor/products*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Products
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'batches','view'))
                    <li>
                        <a href="{{ url('vendor/batches') }}" class="side-menu {{request()->is('vendor/batches*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Batches
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'qr-codes','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'scan-history','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'alerts','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'app-reports','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'report-lostdamage','view'))
            <li>
                <a href="javascript:;" class="side-menu {{(request()->is('vendor/codes*') || request()->is('vendor/bulk-upload') || request()->is('vendor/scanhistory*') || request()->is('vendor/alerts*') || request()->is('vendor/reports*') || request()->is('vendor/lost-damage*'))?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="command"></i>
                    </div>
                    <div class="side-menu__title">
                        QR Codes
                        <div class="side-menu__sub-icon">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>

                <ul class="{{(request()->is('vendor/codes*') || request()->is('vendor/bulk-upload') || request()->is('vendor/scanhistory*') || request()->is('vendor/alerts*') || request()->is('vendor/reports*') || request()->is('vendor/lost-damage*'))?'side-menu__sub-open':''}}">
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'qr-codes','view'))
                    <li>
                        <a href="{{ url('vendor/codes') }}" class="side-menu {{request()->is('vendor/codes*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                QR Codes
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'qr-codes','modify'))
                    <li>
                        <a href="{{ url('vendor/bulk-upload') }}" class="side-menu {{request()->is('vendor/bulk-upload*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Bulk Upload
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'scan-history','view'))
                    <li>
                        <a href="{{ url('vendor/scanhistory') }}" class="side-menu {{request()->is('vendor/scanhistory*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Scan History
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'alerts','view'))
                    <li>
                        <a href="{{ url('vendor/alerts') }}" class="side-menu {{request()->is('vendor/alerts*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Alerts
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'app-reports','view'))
                    <li>
                        <a href="{{ url('vendor/reports') }}" class="side-menu {{request()->is('vendor/reports*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                App Reports
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'report-lostdamage','view'))
                    <li>
                        <a href="{{ url('vendor/lost-damage') }}" class="side-menu {{request()->is('vendor/lost-damage*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Report Lost / Damage
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'qr-labels','view'))
            <li>
                <a href="{{ url('vendor/qr-labels') }}" class="side-menu {{request()->is('vendor/qr-labels')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="terminal"></i>
                    </div>
                    <div class="side-menu__title">
                        Orders
                    </div>
                </a>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'schemes','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'cashbacks','view')  || inAllowedPermissionsByModuleSlug(Auth::id(),'rewards','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'reward-orders','view'))
            <li>
                <a href="javascript:;" class="side-menu {{(request()->is('vendor/schemes*') || request()->is('vendor/cashbacks*') || request()->is('vendor/reward*') || request()->is('vendor/wallets*'))?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="users"></i>
                    </div>
                    <div class="side-menu__title">
                        Consumer Engagement
                        <div class="side-menu__sub-icon">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>

                <ul class="{{(request()->is('vendor/schemes*') || request()->is('vendor/cashbacks*') || request()->is('vendor/rewards*'))?'side-menu__sub-open':''}}">
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'schemes','view'))
                    <li>
                        <a href="{{ url('vendor/schemes') }}" class="side-menu {{request()->is('vendor/schemes')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="gift"></i>
                            </div>
                            <div class="side-menu__title">
                                Lucky Draw
                            </div>
                        </a>
                    </li>
                    @endif

                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'cashbacks','view'))
                    <li>
                        <a href="{{ url('vendor/cashbacks') }}" class="side-menu {{request()->is('vendor/cashbacks')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="gift"></i>
                            </div>
                            <div class="side-menu__title">
                                Cashbacks
                            </div>
                        </a>
                    </li>
                    @endif

                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'rewards','view'))
                    <li>
                        <a href="{{ url('vendor/rewards') }}" class="side-menu {{request()->is('vendor/rewards')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="gift"></i>
                            </div>
                            <div class="side-menu__title">
                                Rewards
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('vendor/reward-orders') }}" class="side-menu {{request()->is('vendor/reward-orders')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="gift"></i>
                            </div>
                            <div class="side-menu__title">
                                Reward Orders
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('vendor/wallets') }}" class="side-menu {{request()->is('vendor/wallets')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="gift"></i>
                            </div>
                            <div class="side-menu__title">
                                Reward Wallets
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif


            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'aggregations','view'))
            <li>
                <a href="javascript:;" class="side-menu {{request()->is('vendor/aggregations*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="git-merge"></i>
                    </div>
                    <div class="side-menu__title">
                        Aggregations
                        <div class="side-menu__sub-icon">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>

                <ul class="{{request()->is('vendor/aggregations*')?'side-menu__sub-open':''}}">
                    <li>
                        <a href="{{ url('vendor/aggregations?level=All') }}" class="side-menu {{(request()->is('vendor/aggregations') && request()->has('level') && request()->get('level')=='All')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                All Aggregations
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('vendor/aggregations?level=Primary') }}" class="side-menu {{(request()->is('vendor/aggregations') && request()->has('level') && request()->get('level')=='Primary')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Primary Aggregations
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('vendor/aggregations?level=Secondary') }}" class="side-menu {{(request()->is('vendor/aggregations') && request()->has('level') && request()->get('level')=='Secondary')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Secondary Aggregations
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('vendor/aggregations?level=Tertiary') }}" class="side-menu {{(request()->is('vendor/aggregations') && request()->has('level') && request()->get('level')=='Tertiary')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Tertiary Aggregations
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('vendor/aggregations?level=Pallette') }}" class="side-menu {{(request()->is('vendor/aggregations') && request()->has('level') && request()->get('level')=='Pallette')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Pallette Aggregations
                            </div>
                        </a>
                    </li>

                </ul>
            </li>            
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'supply-chain-roles','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'supply-chain-users','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'supply-chain-management','view'))
            <li>
                <a href="javascript:;" class="side-menu {{request()->is('vendor/supply-chain*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="git-pull-request"></i>
                    </div>
                    <div class="side-menu__title">
                        Supply Chain
                        <div class="side-menu__sub-icon">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>

                <ul class="{{request()->is('vendor/supply-chain*')?'side-menu__sub-open':''}}">
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'supply-chain-roles','view'))
                    <li>
                        <a href="{{ url('vendor/supply-chain-roles') }}" class="side-menu {{request()->is('vendor/supply-chain-roles*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Roles
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'supply-chain-users','view'))
                    <li>
                        <a href="{{ url('vendor/supply-chain-users') }}" class="side-menu {{request()->is('vendor/supply-chain-users*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Users
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'supply-chain-management','view'))
                    <li>
                        <a href="{{ url('vendor/supply-chain-management') }}" class="side-menu {{request()->is('vendor/supply-chain-management*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Management
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('vendor/supply-chain-scan-history') }}" class="side-menu {{request()->is('vendor/supply-chain-scan-history*')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Scan History
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'users','view'))
            <li>
                <a href="javascript:;" class="side-menu {{request()->is('vendor/users*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="users"></i>
                    </div>
                    <div class="side-menu__title">
                        Users
                        <div class="side-menu__sub-icon">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>

                <ul class="{{request()->is('vendor/users*')?'side-menu__sub-open':''}}">
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'users','view'))
                    <li>
                        <a href="{{ url('vendor/users') }}" class="side-menu {{request()->is('vendor/users')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Users
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'users','modify'))
                    <li>
                        <a href="{{ url('vendor/users/create') }}" class="side-menu {{request()->is('vendor/users/create')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Create Users
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            <li>
                <a href="{{ url('vendor/support') }}" class="side-menu {{request()->is('vendor/support*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="help-circle"></i>
                    </div>
                    <div class="side-menu__title">
                        Support
                    </div>
                </a>
            </li>

            <li>
                <a href="{{ url('vendor/profile') }}" class="side-menu {{request()->is('vendor/profile*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="user"></i>
                    </div>
                    <div class="side-menu__title">
                        Profile
                    </div>
                </a>
            </li>

        </ul>
    </nav>
    <!-- END: Side Menu -->
    <!-- BEGIN: Content -->
    <div class="content">
        @include('vendor.layout.components.top-bar')
        @yield('subcontent')
    </div>
    <!-- END: Content -->
</div>
@endsection