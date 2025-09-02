
<div class="top-bar">
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{ url('/') }}">Home</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="{{ url('/admin') }}" class="breadcrumb--active">Dashboard</a>
    </div>
    <!-- END: Breadcrumb -->
    <!-- BEGIN: Notifications -->
    <a href="javascript:void(0);" class="intro-x dropdown mr-auto sm:mr-6 full-screen" data-open="0" onclick="openFullscreen(this)">
        <i  data-feather="maximize" class="notification__icon maximize dark:text-gray-300"></i>
        <i  data-feather="minimize" style="display:none;" class="notification__icon minimize dark:text-gray-300"></i>
    </a>
    <!-- END: Notifications -->
    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false">
            <img alt="{{ env('APP_NAME') }}" src="{{ asset('dist/images/' . $fakers[9]['photos'][0]) }}">
        </div>
        <div class="dropdown-menu w-56">
            <div class="dropdown-menu__content box bg-theme-26 dark:bg-dark-6 text-white">
                <div class="p-4 {{-- border-b border-theme-27 dark:border-dark-3 --}}">
                    <div class="font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-theme-28 mt-0.5 dark:text-gray-600">{{getDesignation(Auth::id())}}</div>
                </div>

                <div class="p-2">
                    @if (hasRoutePermission('admin-profile',Auth::id()))

                    <a href="{{route('admin-profile')}}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                        <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile
                    </a>
                    @endif

                    <a href="{{route('admin-support')}}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                        <i data-feather="help-circle" class="w-4 h-4 mr-2"></i> Support
                    </a>

                </div>

                <div class="p-2 border-t border-theme-27 dark:border-dark-3">
                    <a href="{{ route('logout') }}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                        <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Account Menu -->
</div>
<!-- END: Top Bar -->