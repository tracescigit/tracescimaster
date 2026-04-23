<div class="right-full-menu">
  <div class="right_menu_item">
    <div class="right_menu_item-content">
      <div class="right-menu-icon">
        <a href="home.html"><img src="images/logo.png" alt=""></a>
      </div>
      <div class="right-menu-list">
        <ul>
          <li class="active"><a href="home.html">Home</a></li>
          <li><a href="about-1.html">About</a></li>
          <li><a href="products.html">Products</a></li>
          <li><a href="solution-1.html">Solution</a></li>
          <li><a href="feature-typography.html">Pricing Plan</a></li>
          <li><a href="plans.html">Products</a></li>
          <li><a href="blog-standard-right-sidebar.html">Blogs</a></li>
          <li><a href="contact-1.html">Get In Touch</a></li>
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
            <a href="{{ url('/') }}">About</a>
          </li>

          <li>
            <a href="#howitworks">Solution</a>
            <ul class="dropdown">
              <li><a href="#howitworks">Cloud</a></li>
              <li><a href="#features">Enterprise</a></li>
              <li><a href="#application">Custom</a></li>
            </ul>
          </li>

         
          <li>
            <a href="#pricing_table">Products</a>
            <ul class="dropdown">
              <li><a href="{{ route('product-razor6') }}">Razor 6</a></li>
              <li><a href="#features">Elite 4</a></li>
              <li><a href="#application">Inspection</a></li>
            </ul>
          </li>
          <li>
            <a href="#pricing_table">Blogs</a>
          </li>

          <li>
            <a href="#get_in_touch">Get In Touch</a>
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