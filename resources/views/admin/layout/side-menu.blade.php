@extends('layout.main')

@section('head')
@yield('subhead')
@endsection

@section('content')
@include('admin.layout.components.mobile-menu')
<div class="flex">
    <!-- BEGIN: Side Menu -->
    <nav class="side-nav">
        <a href="{{ url('/admin') }}" class="intro-x flex items-center pl-5 pt-4">
            <img width="60%"  alt="Tracesci" src="{{asset('web/images/logo.png')}}" class="hidden xl:block"></a>
        </a>
        <div class="side-nav__devider my-6"></div>
        <ul>
            <li>
                <a href="{{ url('admin') }}" class="side-menu {{request()->is('admin')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="home"></i>
                    </div>
                    <div class="side-menu__title">
                        Dashboard
                    </div>
                </a>
            </li>

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'registrations','view'))
            <li>
                <a href="javascript:;" class="side-menu {{request()->is('admin/registrations*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="users"></i>
                    </div>
                    <div class="side-menu__title">
                        Registrations
                        <div class="side-menu__sub-icon">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>

                <ul class="{{request()->is('admin/registrations*')?'side-menu__sub-open':''}}">
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'registrations','view'))
                    <li>
                        <a href="{{ url('admin/registrations') }}" class="side-menu {{request()->is('admin/registrations')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Registrations
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'registrations','modify'))
                    <li>
                        <a href="{{ url('admin/registrations/create') }}" class="side-menu {{request()->is('admin/registrations/create')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Create Registrations
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'plans','view'))
            <li>
                <a href="javascript:;" class="side-menu {{request()->is('admin/plans*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="send"></i>
                    </div>
                    <div class="side-menu__title">
                        Plans
                        <div class="side-menu__sub-icon">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>

                <ul class="{{request()->is('admin/plans*')?'side-menu__sub-open':''}}">
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'plans','view'))
                    <li>
                        <a href="{{ url('admin/plans') }}" class="side-menu {{request()->is('admin/plans')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Plans
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'plans','modify'))
                    <li>
                        <a href="{{ url('admin/plans/create') }}" class="side-menu {{request()->is('admin/plans/create')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Create Plans
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'topups','view'))
            <li>
                <a href="javascript:;" class="side-menu {{request()->is('admin/topups*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="plus"></i>
                    </div>
                    <div class="side-menu__title">
                        Topups
                        <div class="side-menu__sub-icon">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>

                <ul class="{{request()->is('admin/topups*')?'side-menu__sub-open':''}}">
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'topups','view'))
                    <li>
                        <a href="{{ url('admin/topups') }}" class="side-menu {{request()->is('admin/topups')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Topups
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'topups','modify'))
                    <li>
                        <a href="{{ url('admin/topups/create') }}" class="side-menu {{request()->is('admin/topups/create')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Create Topups
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'offers','view'))
            <li>
                <a href="javascript:;" class="side-menu {{request()->is('admin/offers*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="percent"></i>
                    </div>
                    <div class="side-menu__title">
                        Offers
                        <div class="side-menu__sub-icon">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>

                <ul class="{{request()->is('admin/offers*')?'side-menu__sub-open':''}}">
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'offers','view'))
                    <li>
                        <a href="{{ url('admin/offers') }}" class="side-menu {{request()->is('admin/offers')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Offers
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'offers','modify'))
                    <li>
                        <a href="{{ url('admin/offers/create') }}" class="side-menu {{request()->is('admin/offers/create')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Create Offers
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'invoices','view'))
            <li>
                <a href="{{ url('admin/invoices') }}" class="side-menu {{request()->is('admin/invoices*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="printer"></i>
                    </div>
                    <div class="side-menu__title">
                        Invoices
                    </div>
                </a>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'qr-codes','view'))
            <li>
                <a href="{{ url('admin/codes') }}" class="side-menu {{request()->is('admin/codes*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="command"></i>
                    </div>
                    <div class="side-menu__title">
                        QR Codes
                    </div>
                </a>
            </li>
            @endif

            

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'qr-label-orders','modify'))
            <li>
                <a href="{{ url('admin/qr-label-orders') }}" class="side-menu {{request()->is('admin/qr-label-orders')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="terminal"></i>
                    </div>
                    <div class="side-menu__title">
                        Orders
                    </div>
                </a>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'scan-history','view'))
            <li>
                <a href="{{ url('admin/scanhistory') }}" class="side-menu {{request()->is('admin/scanhistory*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="maximize"></i>
                    </div>
                    <div class="side-menu__title">
                        Scan History
                    </div>
                </a>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'alerts','view'))
            <li>
                <a href="{{ url('admin/alerts') }}" class="side-menu {{request()->is('admin/alerts*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="bell"></i>
                    </div>
                    <div class="side-menu__title">
                        Alerts
                    </div>
                </a>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'app-reports','view'))
            <li>
                <a href="{{ url('admin/reports') }}" class="side-menu {{request()->is('admin/reports*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="file-text"></i>
                    </div>
                    <div class="side-menu__title">
                        App Reports
                    </div>
                </a>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'lost-damage','view'))
            <li>
                <a href="{{ url('admin/lost-damage') }}" class="side-menu {{request()->is('admin/lost-damage*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="alert-triangle"></i>
                    </div>
                    <div class="side-menu__title">
                        Report Lost/Damage
                    </div>
                </a>
            </li>
            @endif

            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'label-sizes','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'material-types','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'printing-cost','view') || inAllowedPermissionsByModuleSlug(Auth::id(),'qr-label-orders','view'))
            <li>
                <a href="javascript:;" class="side-menu {{request()->is('admin/label-sizes*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="send"></i>
                    </div>
                    <div class="side-menu__title">
                        QR Settings
                        <div class="side-menu__sub-icon">
                            <i data-feather="chevron-down"></i>
                        </div>
                    </div>
                </a>

                <ul class="{{(request()->is('admin/label-sizes*') || request()->is('admin/material-types*') || request()->is('admin/printing-cost*') || request()->is('admin/qr-label-orders*'))?'side-menu__sub-open':''}}">
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'label-sizes','view'))
                    <li>
                        <a href="{{ url('admin/label-sizes') }}" class="side-menu {{request()->is('admin/label-sizes')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                QR Label Sizes
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'material-types','view'))
                    <li>
                        <a href="{{ url('admin/material-types') }}" class="side-menu {{request()->is('admin/material-types')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Material Types
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'printing-cost','modify'))
                    <li>
                        <a href="{{ url('admin/printing-cost') }}" class="side-menu {{request()->is('admin/printing-cost')?'side-menu--active':''}}">
                            <div class="side-menu__icon">
                                <i data-feather="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Printing Cost
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            
            @if (inAllowedPermissionsByModuleSlug(Auth::id(),'users','view'))
            <li>
                <a href="javascript:;" class="side-menu {{request()->is('admin/users*')?'side-menu--active':''}}">
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

                <ul class="{{request()->is('admin/users*')?'side-menu__sub-open':''}}">
                    @if (inAllowedPermissionsByModuleSlug(Auth::id(),'users','view'))
                    <li>
                        <a href="{{ url('admin/users') }}" class="side-menu {{request()->is('admin/users')?'side-menu--active':''}}">
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
                        <a href="{{ url('admin/users/create') }}" class="side-menu {{request()->is('admin/users/create')?'side-menu--active':''}}">
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
                <a href="{{ url('admin/support') }}" class="side-menu {{request()->is('admin/support*')?'side-menu--active':''}}">
                    <div class="side-menu__icon">
                        <i data-feather="help-circle"></i>
                    </div>
                    <div class="side-menu__title">
                        Support
                    </div>
                </a>
            </li>

            <li>
                <a href="{{ url('admin/profile') }}" class="side-menu {{request()->is('admin/profile*')?'side-menu--active':''}}">
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
        @include('admin.layout.components.top-bar')
        @yield('subcontent')
    </div>
    <!-- END: Content -->
</div>
@endsection