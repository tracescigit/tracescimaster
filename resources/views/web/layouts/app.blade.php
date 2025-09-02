<!DOCTYPE html>
<html lang="en">
<head>
 <title>@yield('title','TRACESCI - A complete  track and trace solutions')</title>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
 <meta name="author" content="">
 <meta name="keywords" content="">
 <meta name="description" content="">
 <link rel="profile" href="http://gmpg.org/xfn/11" />
 <link type="image/x-icon" href="{{asset('web/images/favicon.ico')}}" rel="icon">
 <link href="{{asset('web/css/pe-icon/pe-icon-7-stroke.css')}}" rel="stylesheet" type="text/css"/>
 <link href="{{asset('web/css/plugins.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('web/css/theme.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('web/css/revolution/extralayers.css')}}" rel="stylesheet" type="text/css"/>
 <link href="{{asset('web/css/revolution/settings.css')}}" rel="stylesheet" type="text/css"/>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-SM33TFD3S8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-SM33TFD3S8');
</script>

 
</head>
<body class="home fixed-header">

  <div id="loading">
    <div id="loading-center">
      <div id="loading-center-absolute">
        <div class="object"></div>
      </div>
    </div>
  </div>
  
  <div id="page" class="hfeed site">    
    @include('web.partials.header')
    @yield('content')
    @include('web.partials.footer')
  </div>

  <a class="scroll-to-top"><i class="fa fa-chevron-up"></i></a>
  <!--- define script files -->
  <script type="text/javascript" src="{{asset('web/js/jquery.js')}}"></script>
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
  <script>
    cash('#subscribenow').on('submit',function(e) {
      e.preventDefault();
      var form = $(this);
      var url = form.attr('action');
      cash('#subsmessage').empty();

      axios.post(url,form.serialize()).then(res=>{
        cash('#subsmessage').html(res.data.message);
      }).catch(e=>{
        cash('#subsmessage').html('Something went wrong. Please try again.');
      });
    });
  </script>
  @yield('script')
</body>
</html>
