  <header class="header-area navbar-fixed-top">
    <div class="container custom-header">
      <div class="row">

        <div id="menuzord" class="menuzord">

          <!-- LOGO -->
          <a href="{{ url('/') }}" class="menuzord-brand">
            @if (request()->route()->uri!='p/{code}')
            <img src="" alt="tracesci." style="max-height:50px;">
            @else
            <span class="text-white">{{ $brand }}</span>
            @endif
          </a>
          <div class="header-contact">
            <ul>
              <li class="consult-search"><a href="#">FREE SEO ANALYSIS</a></li>
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
                <li><a href="#howitworks">How it works</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#application">Applications</a></li>
                <li><a href="#event_calendar">Events</a></li>
              </ul>
            </li>

            <li>
              <a href="#pricing_table">Pricing Plan</a>
            </li>
            <li>
              <a href="#pricing_table">Products</a>
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

          </ul>
          @endif

        </div>
      </div>
    </div>
  </header>
 

  