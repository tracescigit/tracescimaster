<!DOCTYPE html>
<html lang="en">

<head>
  <title>@yield('title','TRACESCI - A complete track and trace solutions')</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link type="image/x-icon" href="{{asset('web/images/favicon.ico')}}" rel="icon">
  <link href="{{asset('web/css/pe-icon/pe-icon-7-stroke.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('web/css/plugins.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('web/css/theme.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('web/css/revolution/extralayers.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('web/css/revolution/settings.css')}}" rel="stylesheet" type="text/css" />

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>tracesci.</title>
  <!-- FAVICON -->
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
  <!-- Bootstrap -->
  <link href="{{asset('dist/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- FONT AWESOME ICON -->
  <link href="{{asset('dist/css/font-awesome.min.css')}}" rel="stylesheet">
  <!-- STROKE GAP ICON -->
  <link href="{{asset('dist/css/stroke-icon.css')}}" rel="stylesheet">
  <link href="{{asset('dist/css/ie7.css')}}" rel="stylesheet">
  <!-- MENU -->
  <!-- <link rel="stylesheet" href="{{asset('dist/css/menuzord.css')}}"> -->
  <!-- ANIMATE CSS -->
  <link rel="stylesheet" href="{{asset('dist/css/animate.css')}}">
  <!-- RS5.0 Main Stylesheet -->
  <link rel="stylesheet" type="text/css" href="{{asset('dist/css/settings.css')}}">
  <!-- RS5.0 Layers and Navigation Styles -->
  <link rel="stylesheet" type="text/css" href="{{asset('dist/css/layers.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('dist/css/navigation.css')}}">
  <!-- OWL CSS -->
  <link href="{{asset('dist/css/owl.theme.default.css')}}" rel="stylesheet">
  <link href="{{asset('dist/css/owl.carousel.css')}}" rel="stylesheet">
  <!-- Portfolio Filter -->
  <link rel="stylesheet" href="{{asset('dist/css/bootFolio.css')}}">
  <!-- Popup -->
  <link rel="stylesheet" href="{{asset('dist/css/magnific-popup.css')}}">
  <!-- Box slider css -->
  <link rel="stylesheet" href="{{asset('dist/css/jquery.bxslider.css')}}">
  <!-- JQUERY UI STYLE -->
  <link rel="stylesheet" href="{{asset('dist/css/jquery-ui.css')}}">
  <!-- MAIN STYLE -->
  <link href="{{asset('dist/css/main.css')}}" rel="stylesheet">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

  <!-- CSS -->
  <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('dist/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('dist/css/menuzord.css') }}" rel="stylesheet">
  <link href="{{ asset('dist/css/animate.css') }}" rel="stylesheet">
  <link href="{{ asset('dist/css/main.css') }}" rel="stylesheet">

  <!-- jQuery (IMPORTANT FIRST) -->
  <script src="{{ asset('dist/js/jquery-1.11.3.min.js') }}"></script>
  <!-- GOOGLE FONT -->
  <!-- Google Fonts (All in One) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,700;1,400;1,700&family=Raleway:wght@100;200;300;400;500;600;700;800;900&family=Droid+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
  <!-- <script type="text/javascript" src="{{asset('web/js/jquery.js')}}"></script> -->
  <script src="{{asset('dist/js/jquery-1.11.3.min.js')}}"></script>
  <!-- RS5.0 Core JS Files -->
<script type="text/javascript" src="{{asset('dist/js/jquery.themepunch.tools.min.js?rev=5.0')}}"></script>
<script type="text/javascript" src="{{asset('dist/js/jquery.themepunch.revolution.min.js?rev=5.0')}}"></script>
<script type="text/javascript" src="{{asset('dist/js/revolution.extension.slideanims.min.js')}}"></script>
<script type="text/javascript" src="{{asset('dist/js/revolution.extension.layeranimation.min.js')}}"></script>
<script type="text/javascript" src="{{asset('dist/js/revolution.extension.navigation.min.js')}}"></script>
<script type="text/javascript" src="{{asset('dist/js/revolution.extension.parallax.min.js')}}"></script>
<script type="text/javascript" src="{{asset('dist/js/revolution.extension.actions.min.js')}}"></script>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   <!-- [if lt IE 9]> -->
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-SM33TFD3S8"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-SM33TFD3S8');
  </script>


</head>

<body class="home fixed-header">

  <!-- <div id="loading">
    <div id="loading-center">
      <div id="loading-center-absolute">
        <div class="object"></div>
      </div>
    </div>
  </div> -->

  <div id="page" class="hfeed site">
    @include('web.partials.header')
    @yield('content')
    @include('web.partials.footer')
  </div>

  <a class="scroll-to-top"><i class="fa fa-chevron-up"></i></a>
  <!--- define script files -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cash/8.1.0/cash.min.js" integrity="sha512-sgDgZX/GgfD7qSeMjPN/oE9EQgXZJW55FIjdexVT60QerG2gAWhR9QDQEGt3O90Dy9jVcwMWsoTMhLgldIiKXw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="{{asset('web/js/bootstrap.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/isotope.pkgd.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/imagesloaded.pkgd.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/owl.carousel.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/custom-carousel.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/revolution/jquery.themepunch.tools.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/revolution/jquery.themepunch.revolution.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/revolution/extensions/revolution.extension.video.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/revolution/extensions/revolution.extension.slideanims.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/revolution/extensions/revolution.extension.actions.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/revolution/extensions/revolution.extension.layeranimation.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/revolution/extensions/revolution.extension.kenburn.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/revolution/extensions/revolution.extension.navigation.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/revolution/extensions/revolution.extension.migration.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/revolution/extensions/revolution.extension.parallax.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/customs-slider.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/jquery.fancybox.pack.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/cascade-slider.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/jquery.scrollbar.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/scrollReveal.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/jquery.nav.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/jquery.validate.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/functions.js')}}"></script>
  <script type="text/javascript" src="{{asset('dist/js/menuzord.js')}}"></script>
  <script type="text/javascript" src="{{asset('dist/js/main.js')}}"></script>
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
  <script>
    cash('#subscribenow').on('submit', function(e) {
      e.preventDefault();
      var form = $(this);
      var url = form.attr('action');
      cash('#subsmessage').empty();

      axios.post(url, form.serialize()).then(res => {
        cash('#subsmessage').html(res.data.message);
      }).catch(e => {
        cash('#subsmessage').html('Something went wrong. Please try again.');
      });
    });
  </script>
  @yield('script')
</body>

</html>