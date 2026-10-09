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

          <li class="{{ request()->is('solutions/*') || request()->is('product/*') ? 'active' : '' }}">
            <a>Solutions</a>
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



<style>
  /* ---- top nav: white at 20% opacity ONLY while the page is at the top ---- */
  .header-area.navbar-fixed-top.at-top {
    background: rgba(255, 255, 255, 0.2) !important;   /* 0.2 = 20% */
    transition: background 0.3s ease;
  }

  .header-area.navbar-fixed-top.at-top .menuzord,
  .header-area.navbar-fixed-top.at-top .menuzord-menu-bg {
    background: transparent !important;
  }
  /* once scrolled, .at-top is removed and the theme's own nav style applies */
</style>

<header class="header-area navbar-fixed-top at-top">
  <div class="container custom-header">
    <div class="row">

      <div id="menuzord" class="menuzord">

        <!-- LOGO -->
        <a href="{{ url('/') }}" class="menuzord-brand">
          @if (request()->route()->uri!='p/{code}')
          <span>tracesci.</span>
        </a>
        @else
        <a href="#" class="menuzord-brand" style="display: none;">
          <span class="text-white">{{ $brand }}</span>
        </a>
        @endif
        @if (request()->route()->uri!='p/{code}')
        <div class="header-contact">
          <ul>
            <li class="consult-search {{ request()->is('demo-scheduling') ? 'active' : '' }}"><a href="{{ route('demo-schedule-create') }}">Schedule Demo</a></li>
          </ul>
        </div>
        @endif

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

          <li class="{{ request()->is('solutions/*') || request()->is('product/*') ? 'active' : '' }}">
            <a >Solutions</a>
            <ul class="dropdown">

              <!-- 1) SOFTWARE -->
              <li class="{{ request()->is('solutions/*') ? 'active' : '' }}">
                <a href="{{ route('cloud-solution') }}">Software</a>
                <ul class="dropdown">
                  <li>
                    <a href="{{ route('cloud-solution') }}">Cloud</a>
                  </li>
                  <li>
                    <a href="{{ route('enterprise-solution') }}">Enterprise</a>
                  </li>
                  <!-- <li>
                    <a href="{{ url('/') }}#application">Customise</a>
                  </li> -->
                </ul>
              </li>

              <!-- 2) EQUIPMENTS -->
              <li class="{{ request()->is('product/*') ? 'active' : '' }}">
                <a href="{{ route('product-hyperloop') }}">Equipments</a>
                <ul class="dropdown">
                  <li>
                    <a href="{{ route('product-hyperloop') }}">Hyperloop</a>
                  </li>
                  <li>
                    <a href="{{ route('product-razor6') }}">Razor 6</a>
                  </li>
                  <li>
                    <a href="{{ route('product-elite4') }}">Elite 4</a>
                  </li>
                </ul>
              </li>

            </ul>
          </li>

          <li class="{{ request()->is('blog') ? 'active' : '' }}">
            <a href="{{ route('blog') }}">Blogs</a>
          </li>

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

<script>
  // white 20% background only at the top of the page; theme style after scrolling
  (function () {
    var header = document.querySelector('.header-area.navbar-fixed-top');
    if (!header) return;

    function updateHeader() {
      if (window.pageYOffset <= 10) {
        header.classList.add('at-top');
      } else {
        header.classList.remove('at-top');
      }
    }

    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });
  })();
</script>