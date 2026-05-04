@extends('web.layouts.app')
@section('content')
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tracesci</title>
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <!-- Bootstrap -->
    <link href="{{asset('dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- FONT AWESOME ICON -->
    <link href="{{asset('dist/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- STROKE ICON -->
    <link href="{{asset('dist/css/pe-icon-7-stroke.css')}}" rel="stylesheet">
    <!-- MENU -->
    <link rel="stylesheet" href="{{asset('dist/css/menuzord.css')}}">
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

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
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
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- =========================
        START HEADER SECTION
      ============================== -->


    <!-- =========================
        END HEADER SECTION
      ============================== -->

    <!-- =========================
      START PAGE TITLE SECTION
      ============================== -->
    <section class="page-title-area blog-standard-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="about-head-content">
                        <h2>Our Blog</h2>
                        <p>Tracesci insights & articles, A blog about analytics, marketing & testing</p>
                    </div>
                    <div class="breadcrumbs text-center">
                        <ul class="page-breadcrumbs">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="#">Blog</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =========================
      END PAGE TITLE SECTION
      ============================== -->

    <!-- =========================
        START FULL INTRO SECTION
      ============================== -->
    @if(!empty($blogs) && count($blogs) > 0)
    <section class="full-intro-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 no-padding text-left">
                    <div class="blog-2-column-left-content">
                        @foreach($blogs as $index => $blog)
                        @if($index == 6)
                        @break
                        @endif
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{ asset('storage/' . $blog->image_path) }}" alt="" class="Blog-Image">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        {{$blog->publish_date ?? '--'}} <span><a href="#">Business</a></span>.
                                    </p>
                                    <h3>{{ $blog->title ?? 'Blog Title' }}</h3>
                                </div>
                                <div class="full-intro-content">
                                    <p>{{!! $blog->description ?? 'Blog description'!!}}</p>
                                    <p>
                                        By:<span>{{ $blog->publish_by ?? 'Blog Published By' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-2.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 15, 2015 . <span><a href="#">Tools, News</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">At Last, You Can Now Add Users to Your Pro Account!</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>How would you like to leave work early on Fridays? Raven’s set-it-and-forget-it reports prove to be a major time saver for this marketing agency.With the ability to show progress.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-2.png')}}" alt="">By:<span><a href="#"> Ahmed Ali</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-3.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 15, 2015 . <span><a href="#">Tools, News</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">At Last, You Can Now Add Users to Your Pro Account!</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>We all know that no user is the same. Aside from the basics such as age, gender, socio-economic background and so every person differs in life experiences, interests, and preferences.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-2.png')}}" alt="">By:<span><a href="#"> Ahmed Ali</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-1.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 30, 2015 . <span><a href="#">Tools, Videos</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">How to Hack the Amplification Process - Whiteboard Friday</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>How would you like to leave work early on Fridays? Raven’s set-it-and-forget-it reports prove to be a major time saver for this marketing agency.With the ability to show</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-3.png')}}" alt="">By:<span><a href="#"> Ahmed Ebraheem</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-4.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 30, 2015 . <span><a href="#">Tools, Videos</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">Google Glossary: Revenge of Mega-SERP</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>We all know that no user is the same. Aside from the basics such as age, gender, socio-economic background and so every person differs in life experiences, interests, and preferences.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-3.png')}}" alt="">By:<span><a href="#"> Ahmed Ebraheem</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-5.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 30, 2015 . <span><a href="#">Tools, Videos</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">Why Meaning Will Ultimately Determine Your Brand</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>We all know that no user is the same. Aside from the basics such as age, gender, socio-economic background and so every person differs in life experiences, interests, and preferences.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-3.png')}}" alt="">By:<span><a href="#"> Ahmed Emad</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-1.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 16, 2015 . <span><a href="#">Business</a></span>. Comments : <span><a href="#">80</a></span>
                                    </p>
                                    <h2><a href="#">Beyond the SEO: After Optimizing Your Website</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>We all know that no user is the same. Aside from the basics such as age, gender, socio-economic background and so every person differs in life experiences, interests, and preferences.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-1.png')}}" alt="">By:<span><a href="#"> Ahmed Ebraheem</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-2.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 15, 2015 . <span><a href="#">Tools, News</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">At Last, You Can Now Add Users to Your Pro Account!</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>How would you like to leave work early on Fridays? Raven’s set-it-and-forget-it reports prove to be a major time saver for this marketing agency.With the ability to show progress</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-2.png')}}" alt="">By:<span><a href="#"> Ahmed Ali</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-4.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 30, 2015 . <span><a href="#">Tools, Videos</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">Google Glossary: Revenge of Mega-SERP</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>We all know that no user is the same. Aside from the basics such as age, gender, socio-economic background and so every person differs in life experiences, interests, and preferences.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-3.png')}}" alt="">By:<span><a href="#"> Ahmed Ebraheem</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-1.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 16, 2015 . <span><a href="#">Business</a></span>. Comments : <span><a href="#">80</a></span>
                                    </p>
                                    <h2><a href="#">Beyond the SEO: After Optimizing Your Website</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>We all know that no user is the same. Aside from the basics such as age, gender, socio-economic background and so every person differs in life experiences, interests, and preferences.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-1.png')}}" alt="">By:<span><a href="#"> Ahmed Ebraheem</a></span>
                                    </p>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-12 matrics-pagination matrics-blog-pagination text-center clearfix">
                            <nav>
                                <ul class="pagination">
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li>
                                        <a href="#" aria-label="Next">
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif


    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist/js/menuzord.js') }}"></script>
    <script src="{{ asset('dist/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.counterup.js') }}"></script>
    <script src="{{ asset('dist/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('dist/js/countdown.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.bootFolio.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.magnific-popup.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="{{ asset('dist/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('dist/js/rev-function.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.bxslider.js') }}"></script>
    <script src="{{ asset('dist/js/smoothscroll.js') }}"></script>
    <script src="{{ asset('dist/js/wow.js') }}"></script>
    <script src="{{ asset('dist/js/main.js') }}"></script>


</body>

</html>