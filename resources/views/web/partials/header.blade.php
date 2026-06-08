<div class="right-full-menu">
  <div class="right_menu_item">
    <div class="right_menu_item-content">
      <div class="right-menu-icon">
        <a href="{{ url('/') }}"><img src="images/logo.png" alt=""></a>
      </div>
      <div class="right-menu-list">
        <ul>
          <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ url('/') }}">Home</a>
          </li>

          <li class="{{ request()->is('about') ? 'active' : '' }}">
            <a href="{{ url('/about') }}">About</a>
          </li>

          <li class="{{ request()->is('product/razor6') ? 'active' : '' }}">
            <a href="{{ url('/product/razor6') }}">Products</a>
          </li>

          <li class="{{ request()->is('solutions/cloud') ? 'active' : '' }}">
            <a href="{{ url('/cloud-solution') }}">Solution</a>
          </li>

          <!-- <li class="{{ request()->routeIs('blog') ? 'active' : '' }}">
            <a href="{{ route('blog') }}">Blogs</a>
          </li> -->

          <li class="{{ request()->routeIs('contact-us') ? 'active' : '' }}">
            <a href="{{ route('contact-us') }}">Get In Touch</a>
          </li>

          <li class="{{ request()->is('login') ? 'active' : '' }}">
            <a href="{{ url(Auth::check() ? myDashboard() : '/login') }}">Login</a>
          </li>
        </ul>
      </div>
      <div class="right-menu-social-box">
        <ul class="cms-social">
          <li class="facebook">
            <a href="https://www.facebook.com/tracesciSolutions/"><i class="fa fa-facebook"></i></a>
          </li>
          <li class="youtube">
            <a href="https://www.youtube.com/@TracesciGlobal"><i class="fa fa-youtube"></i></a>
          </li>
          <li class="linkedin">
            <a href="https://in.linkedin.com/company/tracesci-solutions-pvt-ltd"><i class="fa fa-linkedin"></i></a>
          </li>
        </ul>
        <div class="footer-bottom-right right-menu-copyright">
          <p>© {{$year}}. All Rights Reserved by
            <br>
            <a class="text-white" href="{{route('home')}}">tracesci.</a>
        </div>
      </div>
    </div>
  </div>
  <div class="close_ic"></div>
</div>



<header class="header-area navbar-fixed-top">
  <div class="container custom-header">
    <div class="row">

      <div id="menuzord" class="menuzord">

        <!-- LOGO -->
        <a href="{{ url('/') }}" class="menuzord-brand">
          @if (request()->route()->uri!='p/{code}')
          <span>tracesci.</span>
          @else
          <span class="text-white">{{ $brand }}</span>
          @endif
        </a>
        <div class="header-contact">
          <ul>
            <li class="consult-search {{ request()->is('demo-scheduling') ? 'active' : '' }}"><a href="{{ route('demo-schedule-create') }}">Schedule Demo</a></li>
          </ul>
        </div>
        <!-- SEARCH + ICON -->



        <!-- MAIN MENU -->
        @if (request()->route()->uri!='p/{code}')
        <ul class="menuzord-menu menuzord-menu-bg">

          <li class="{{ request()->is('/') ? 'active' : '' }}">
            <a href="{{ url('/') }}">Home</a>
          </li>

          <li class="{{ request()->is('about') ? 'active' : '' }}">
            <a href="{{ url('/about') }}">About</a>
          </li>

          <li class="{{ request()->is('solutions/cloud') || request()->is('solutions/enterprise') ? 'active' : '' }}">
            <a href="{{ route('cloud-solution') }}">Solution</a>
            <ul class="dropdown">
              <li>
                <a href="{{ route('cloud-solution') }}">Cloud</a>
              </li>
              <li>
                <a href="{{ route('enterprise-solution') }}">Enterprise</a>
              </li>
              <li>
                <a href="#application">Customise</a>
              </li>
            </ul>
          </li>

          <li class="{{ request()->is('product/razor6') || request()->is('product/elite4') || request()->is('product/hyperloop') ? 'active' : '' }}">
            <a href="{{ url('/product/razor6') }}">Products</a>
            <ul class="dropdown">
              <li>
                <a href="{{ route('product-razor6') }}">Razor 6</a>
              </li>
              <li>
                <a href="{{ route('product-elite4') }}">Elite 4</a>
              </li>
              <li>
                <a href="{{ route('product-hyperloop') }}">Hyperloop</a>
              </li>
            </ul>
          </li>

          <!-- <li class="{{ request()->is('blog') ? 'active' : '' }}">
            <a href="{{ route('blog') }}">Blogs</a>
          </li> -->

          <li class="{{ request()->is('get_in_touch') ? 'active' : '' }}">
            <a href="{{ route('contact-us') }}">Get In Touch</a>
          </li>

          <li class="{{ request()->is('login') ? 'active' : '' }}">
            <a href="{{ url(Auth::check() ? myDashboard() : '/login') }}">
              {{ Auth::check() ? 'Dashboard' : 'Login' }}
            </a>
          </li>

          <!-- <li class="right_menu">
            <a href="#"><i class="fa fa-bars"></i></a>
          </li> -->
        </ul>
        @endif

      </div>
    </div>
  </div>
</header>