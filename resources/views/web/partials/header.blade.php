<div class="right-full-menu">
  <div class="right_menu_item">
    <div class="right_menu_item-content">
      <div class="right-menu-icon">
        <a href="{{ url('/') }}"><img src="images/logo.png" alt=""></a>
      </div>
      <div class="right-menu-list">
        <ul>
          <li class="active"><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/about') }}">About</a></li>
          <li><a href="{{ url('/product/razor6') }}">Products</a></li>
          <li><a href="{{ url('/cloud-solution') }}">Solution</a></li>

          <li><a href="{{route('blog')}}">Blogs</a></li>
          <li><a href="{{route('contact-us')}}">Get In Touch</a></li>
          <li><a href="{{ url(Auth::check()?myDashboard():'/login') }}">Login</a></li>
        </ul>
      </div>
      <div class="right-menu-social-box">
        <ul class="cms-social">
          <li class="facebook">
            <a href="#"><i class="fa fa-facebook"></i></a>
          </li>
          <li class="twitter">
            <a href="#"><i class="fa fa-twitter"></i></a>
          </li>
          <li class="google">
            <a href="#"><i class="fa fa-pinterest"></i></a>
          </li>
          <li class="linkedin">
            <a href="#"><i class="fa fa-linkedin"></i></a>
          </li>
          <li class="linkedin">
            <a href="#"><i class="fa fa-rss"></i></a>
          </li>
        </ul>
        <div class="footer-bottom-right right-menu-copyright">
          <p>© 2015 - 2016 Metrics. All Rights Reserved</p>
          <p>
            With Love by <span><a href="#">tracesci</a></span>
          </p>
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
          <span >tracesci.</span>
          @else
          <span class="text-white">{{ $brand }}</span>
          @endif
        </a>
        <div class="header-contact">
          <ul>
            <li class="consult-search"><a href="{{ route('demo-schedule-create') }}">Schedule Demo</a></li>
          </ul>
        </div>
        <!-- SEARCH + ICON -->



        <!-- MAIN MENU -->
        @if (request()->route()->uri!='p/{code}')
        <ul class="menuzord-menu menuzord-menu-bg">

          <li class="active">
            <a href="{{ url('/') }}">Home</a>
          </li>
          <li>
            <a href="{{ url('/about') }}">About</a>
          </li>

          <li>
            <a href="#howitworks">Solution</a>
            <ul class="dropdown">
              <li><a href="{{route('cloud-solution')}}">Cloud</a></li>
              <li><a href="#features">Enterprise</a></li>
              <li><a href="#application">Custom</a></li>
            </ul>
          </li>

         
          <li>
            <a href="{{ url('/product/razor6') }}">Products</a>
            <ul class="dropdown">
              <li><a href="{{ route('product-razor6') }}">Razor 6</a></li>
              <li><a href="{{route('product-elite4')}}">Elite 4</a></li>
              <li><a href="{{route('product-hyperloop')}}">Hyperloop</a></li>
            </ul>
          </li>
          <li>
            <a href="#pricing_table">Blogs</a>
          </li>

          <li>
            <a href="{{route('contact-us')}}">Get In Touch</a>
          </li>

          <li>
            <a href="{{ url(Auth::check()?myDashboard():'/login') }}">
              {{ Auth::check() ? 'Dashboard' : 'Login' }}
            </a>
          </li>
          <li class="right_menu">
            <a href="#"><i class="fa fa-bars"></i></a>
          </li>
        </ul>
        @endif

      </div>
    </div>
  </div>
</header>