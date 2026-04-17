<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>tracesci.</title>

  <!-- FAVICON -->
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

  <!-- CSS -->
  <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('dist/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('dist/css/menuzord.css') }}" rel="stylesheet">
  <link href="{{ asset('dist/css/animate.css') }}" rel="stylesheet">
  <link href="{{ asset('dist/css/main.css') }}" rel="stylesheet">

  <!-- jQuery (IMPORTANT FIRST) -->
  <script src="{{ asset('dist/js/jquery-1.11.3.min.js') }}"></script>
</head>

<body>

  <!-- ================= HEADER ================= -->
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

  <!-- ================= CONTENT ================= -->
  <div style="margin-top:100px;">
    @yield('content')
  </div>

  <!-- ================= SCRIPTS ================= -->

  <!-- Bootstrap -->
  <script src="{{ asset('dist/js/bootstrap.min.js') }}"></script>

  <!-- Plugins -->
  <script src="{{ asset('dist/js/menuzord.js') }}"></script>
  <script src="{{ asset('dist/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('dist/js/jquery.counterup.js') }}"></script>
  <script src="{{ asset('dist/js/waypoints.min.js') }}"></script>
  <script src="{{ asset('dist/js/countdown.js') }}"></script>
  <script src="{{ asset('dist/js/jquery.bootFolio.js') }}"></script>
  <script src="{{ asset('dist/js/jquery.magnific-popup.js') }}"></script>
  <script src="{{ asset('dist/js/jquery-ui.js') }}"></script>
  <script src="{{ asset('dist/js/jquery.bxslider.js') }}"></script>
  <script src="{{ asset('dist/js/smoothscroll.js') }}"></script>
  <script src="{{ asset('dist/js/wow.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('dist/js/main.js') }}"></script>

  <!-- INIT MENUZORD -->
  <script>
   jQuery(document).ready(function($) {
  $("#menuzord").menuzord();
});
  </script>

</body>

</html>