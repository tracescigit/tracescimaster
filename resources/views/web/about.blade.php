@extends('web.layouts.app')
@section('content')
<style>
    /* Ensure columns behave properly */
    .progressbar {
        overflow: hidden;
        /* clears float issues */
    }

    /* Fix spacing between columns on smaller screens */
    .progressbar .col-md-6 {
        margin-bottom: 20px;
    }

    /* Space between each progress block */
    .progress_cont {
        margin-bottom: 25px;
    }

    /* Skill title alignment */
    .skill {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
        font-weight: 600;
    }

    /* Make sure progress bar container behaves properly */
    .progress {
        height: 5px;
        overflow: hidden;
        background-color: #eee;
    }

    /* Fix overlapping / stacking issues */
    .progress-bar {
        display: block;
        height: 100%;
    }

    /* Optional: show percentage on right properly */
    .skill .pull-right {
        float: right;
    }

    /* Section spacing */
    .our-story-area {
        position: relative;
        padding: 80px 0;
    }

    /* Left image */
    .contact-photo {
        position: absolute;
        left: 0;
        top: 0;
        width: 46%;
        height: 100%;
    }

    .story-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Content spacing */
    .our-story-2-head {
        margin-bottom: 30px;
    }

    .our-story-inner {
        padding: 15px;
    }

    /* 🔥 Responsive Fix */
    @media (max-width: 991px) {
        .contact-photo {
            position: relative;
            width: 100%;
            height: auto;
            margin-bottom: 30px;
        }

        .story-img {
            height: auto;
        }
    }
</style>
<section class="page-title-area aboout-1-head-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="about-head-content">
                    <h2>Who We Are</h2>
                    <p>We're a technology company dedicated to product authentication and anti-counterfeiting solutions.</p>
                </div>
                <div class="breadcrumbs text-center">
                    <ul class="page-breadcrumbs">
                        <li><a href="{{route('home')}}">home</a></li>
                        <li><a href="#">About Us</a></li>
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
      START WELCOME 2 SECTION
      ============================== -->
<section class="welcome-2">
    <!-- MAIN TITLE AREA -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left">
                <div class="main-title main-title-left wow fadeInLeft">
                    <div class="main-shadow-heading">
                        <h2>Hello, Welcome To TRACESCI</h2>
                    </div>
                    <h2>Hello, Welcome To <span style="color: #7a0d7d;">TRACESCI</span></h2>
                    <h3>Get To Know About Us</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- END TITLE -->
    <div class="welcome-2-content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="welcome-2-left-content wow fadeInLeft">
                        <p>We're TRACESCI, a product authentication and track & trace technology company based in Chennai, India. We provide a complete anti-counterfeiting ecosystem that helps governments, brands, and consumers combat illicit trade, protect revenue, and ensure the safety of products across the supply chain.</p>
                        <!-- <div class="all-link pricinig-head-btn">
                            <a href="#">More About Us</a>
                        </div> -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="welcome-2-right-content wow fadeInRight">
                        <div class="col-sm-4">
                            <div class="welcome-2-right-content-inner">
                                <span><i class="icon icon-Chart"></i></span>
                                <h2><span class="counter">100</span>%</h2>
                                <p>End-to-End Solution</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="welcome-2-right-content-inner w-r-l-border">
                                <span><i class="icon icon-Users"></i></span>
                                <h2><span class="counter">24</span>/7</h2>
                                <p>Customer Support</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="welcome-2-right-content-inner w-r-l-border">
                                <span><i class="icon icon-ChartUp"></i></span>
                                <h2><span class="counter">6</span>+</h2>
                                <p>Industry Verticals</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- =========================
      END  WELCOME 2 SECTION
      ============================== -->

<!-- =========================
      START OUR PHILOSOPHY SECTION
      ============================== -->
<section class="our-philosophy-area wow fadeInLeft">
    <div class="container-fluid">
        <div class="row d-flex align-items-stretch">

            <div class="col-sm-6 col-md-4 no-padding d-flex">
                <div class="our-philosophy-inner our-philosophy-inner-bg-1 w-100">
                    <h2>Our Mission</h2>
                    <p>To combat illicit trade, counterfeiting, revenue leakage, and the circulation of unsafe products. We empower governments, brands, and consumers with intelligent traceability solutions that protect every link in the supply chain — from manufacturer to end user.</p>
                    <span><i class="icon icon-Flag"></i></span>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 no-padding d-flex">
                <div class="our-philosophy-inner our-philosophy-inner-bg-2 w-100">
                    <h2>Our Vision</h2>
                    <p>To build a world where every product is authentic, every supply chain is transparent, and every consumer is protected. We envision a global ecosystem where traceability is accessible and affordable for businesses of all sizes — from startups to large enterprises and governments.</p>
                    <span><i class="icon icon-Bulb"></i></span>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 no-padding d-flex">
                <div class="our-philosophy-inner our-philosophy-inner-bg-3 w-100">
                    <h2>Our Philosophy</h2>
                    <p>We believe in making every consumer a brand protector. By combining blockchain technology, serialization, and mobile intelligence, we create solutions that are not only powerful but also easy to adopt. Innovation, integrity, and impact drive everything we do at TRACESCI.</p>
                    <span><i class="icon icon-PaperClip"></i></span>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- =========================
      END OUR PHILOSOPHY SECTION
      ============================== -->

<!-- =========================
        START TEAM SECTION
      ============================== -->
<!-- <section class="team-area team-no-bottom-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="main-title wow zoomIn">
                    <div class="main-shadow-heading">
                        <h2>Meet Metrics Core Team</h2>
                    </div>
                    <h2>Meet Metrics Core Team</h2>
                    <h3>We Love It Here. You Will, Too.</h3>
                </div>
            </div>
        </div>
    </div>
   
    <div class="container wow zoomIn">
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <article class="entry-team">
                    <div class="team-member">
                        <div class="team-member-featured">
                            <img src="images/team/team-1.jpg" class="img-responsive" alt="Ahmed Abd-Alhaleem">
                        </div>
                        <div class="team-member-main">
                            <div class="team-member-info">
                                <div class="team-member-header">
                                    <h3 class="team-member-title"><a href="#" title="Ahmed Abd-Alhaleem">Ahmed Abd-Alhaleem</a></h3>
                                    <p class="team-member-roles">Graphic Designer</p>
                                    <ul class="cms-social">
                                        <li class="facebook">
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li class="twitter">
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li class="google">
                                            <a href="#"><i class="fa fa-google-plus"></i></a>
                                        </li>
                                        <li class="linkedin">
                                            <a href="#"><i class="fa fa-linkedin"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="team-member-content">I am excited about helping companies make impactful decisions based on their data.</div>
                            </div>
                            <div class="team-member-brief">
                                <h3 class="team-member-title">Ahmed Abd-Alhaleem</h3>
                                <p class="team-member-roles font-alt-1">Graphic Designer</p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-sm-6 col-md-3">
                <article class="entry-team">
                    <div class="team-member">
                        <div class="team-member-featured">
                            <img src="images/team/team-2.png" class="img-responsive" alt="Ahmed Abd-Alhaleem">
                        </div>
                        <div class="team-member-main">
                            <div class="team-member-info">
                                <div class="team-member-header">
                                    <h3 class="team-member-title"><a href="#" title="Ahmed Abd-Alhaleem">Ahmed Hassan</a></h3>
                                    <p class="team-member-roles">Web Developer</p>
                                    <ul class="cms-social">
                                        <li class="facebook">
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li class="twitter">
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li class="google">
                                            <a href="#"><i class="fa fa-google-plus"></i></a>
                                        </li>
                                        <li class="linkedin">
                                            <a href="#"><i class="fa fa-linkedin"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="team-member-content">I am excited about helping companies make impactful decisions based on their data.</div>
                            </div>
                            <div class="team-member-brief">
                                <h3 class="team-member-title">Ahmed Abd-Alhaleem</h3>
                                <p class="team-member-roles font-alt-1">Web Developer</p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-sm-6 col-md-3">
                <article class="entry-team">
                    <div class="team-member">
                        <div class="team-member-featured">
                            <img src="images/team/team-3.png" class="img-responsive" alt="Ahmed Abd-Alhaleem">
                        </div>
                        <div class="team-member-main">
                            <div class="team-member-info">
                                <div class="team-member-header">
                                    <h3 class="team-member-title"><a href="#" title="Ahmed Abd-Alhaleem">Mohamed Habaza</a></h3>
                                    <p class="team-member-roles">Lead Dev Ops</p>
                                    <ul class="cms-social">
                                        <li class="facebook">
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li class="twitter">
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li class="google">
                                            <a href="#"><i class="fa fa-google-plus"></i></a>
                                        </li>
                                        <li class="linkedin">
                                            <a href="#"><i class="fa fa-linkedin"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="team-member-content">I am excited about helping companies make impactful decisions based on their data.</div>
                            </div>
                            <div class="team-member-brief">
                                <h3 class="team-member-title">Mohamed Habaza</h3>
                                <p class="team-member-roles font-alt-1">Lead Dev Ops</p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-sm-6 col-md-3">
                <article class="entry-team">
                    <div class="team-member">
                        <div class="team-member-featured">
                            <img src="images/team/team-4.png" class="img-responsive" alt="Ahmed Abd-Alhaleem">
                        </div>
                        <div class="team-member-main">
                            <div class="team-member-info">
                                <div class="team-member-header">
                                    <h3 class="team-member-title"><a href="#" title="Ahmed Abd-Alhaleem">Amr Gamal Sadeq</a></h3>
                                    <p class="team-member-roles">Design expert</p>
                                    <ul class="cms-social">
                                        <li class="facebook">
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li class="twitter">
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li class="google">
                                            <a href="#"><i class="fa fa-google-plus"></i></a>
                                        </li>
                                        <li class="linkedin">
                                            <a href="#"><i class="fa fa-linkedin"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="team-member-content">I am excited about helping companies make impactful decisions based on their data.</div>
                            </div>
                            <div class="team-member-brief">
                                <h3 class="team-member-title">Amr Gamal Sadeq</h3>
                                <p class="team-member-roles font-alt-1">Design expert</p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section> -->
<!-- <div class="progress-bar-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="progressbar">
                    <div class="col-md-6">
                        <div class="progress_cont">
                            <div class="skill">Authentication<span class="pull-right"></span></div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span class="sr-only">98% Complete (success)</span></div>
                            </div>
                        </div>
                        <div class="progress_cont">
                            <div class="skill">Consumer Engagement <span class="pull-right"></span></div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span class="sr-only">85% Complete (success)</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="progress_cont">
                            <div class="skill">Supply Chain Security <span class="pull-right"></span></div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span class="sr-only">95% Complete (success)</span></div>
                            </div>
                        </div>
                        <div class="progress_cont">
                            <div class="skill">Data Analytics <span class="pull-right"></span></div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span class="sr-only">92% Complete (success)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- =========================
        END TEAM SECTION
      ============================== -->

<!-- =========================
      START OUR STORY 2 SECTION
      ============================== -->
<section class="our-story-area our-story-2 grey-bg position-relative">

    <!-- Left Image -->
    <div class="contact-photo reveal">
        <img src="{{asset('web/images/how_started.jpg')}}"
            alt="Man and woman working together"
            class="story-img">
    </div>

    <div class="container">
        <div class="row align-items-center">

            <!-- Empty space for image on desktop -->
            <div class="col-md-6 d-none d-md-block"></div>

            <!-- Content -->
            <div class="col-md-6">
                <div class="our-story-2-head">
                    <h3>Our Story</h3>
                    <h2>How It All <span style="color: #7a0d7d;">Began!</span></h2>
                    <p>
                        We're TRACESCI, a product authentication and track & trace technology company headquartered in Chennai with branches also on Gurugram and Mumbai,Established to combat the rising challenges of illicit trade and counterfeiting.
                    </p>
                </div>

                <!-- Inner Grid -->
                <div class="row mt-4">

                    <div class="col-sm-6 mb-2">
                        <div class="our-story-inner">
                            <h2>Who We Are</h2>
                            <p>Skilled team of technology and supply chain professionals focused on redefining product authentication,traceability,visibility through Smart digital solutions.
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-2">
                        <div class="our-story-inner">
                            <h2>What We <span style="color: #7a0d7d;">Do</span></h2>
                            <p>Driven by innovation and purpose, we collaborate with brands, governments, and industry partners to combat counterfeiting and illicit trade.</p>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-2">
                        <div class="our-story-inner">
                            <h2>Why We Do <span style="color: #7a0d7d;">It</span></h2>
                            <p>We do this to address the growing threat of illicit trade and counterfeiting, which not only causes massive revenue losses but also puts consumer safety at serious risk.</p>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-2">
                        <div class="our-story-inner">
                            <h2>Our Values</h2>
                            <p>Our values are rooted in integrity, innovation, and impact. We believe in building trust through transparent and secure systems that protect brands, governments, and consumers alike.</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</section>

<section class="client-2-area">
    <!-- MAIN TITLE AREA -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="main-title wow zoomIn">
                    <div class="main-shadow-heading">
                        <h2>Don't Just Take Our Word For It</h2>
                    </div>
                    <h2>Don't Just Take <span style="color: #7a0d7d;">Our Word</span> For It</h2>
                    <h3>Trusted By Brands & Governments</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- END TITLE -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="client-bg-2-slider" class="owl-carousel all-carousel owl-theme">

                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>TRACESCI streamlined our product tracking process and improved visibility across the entire supply chain.

                            </h3>
                            <img src="images/client/client-user-1.png" alt="">
                        </div>
                        <h2>LyLy Parker</h2>
                        <h3>MD, Label Printer</h3>
                    </div>

                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>The blockchain-enabled traceability solution streamlined our compliance process and gave us accurate real-time product movement insights.</h3>
                            <img src="images/client/client-user-2.png" alt="">
                        </div>
                        <h2>Vikas Sethi</h2>
                        <h3>Product Manager, Agro Company</h3>
                    </div>

                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>Customer engagement improved significantly after implementing TRACESCI’s QR authentication system for our retail products.</h3>
                            <img src="images/client/client-user-3.png" alt="">
                        </div>
                        <h2>Varun Sehgal</h2>
                        <h3>Sales Director, Retail Brand</h3>
                    </div>

                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>TRACESCI gave us end-to-end visibility from manufacturing to distribution, helping us strengthen brand protection and reduce counterfeit risks.</h3>
                            <img src="images/client/client-user-1.png" alt="">
                        </div>
                        <h2>Rohan Malhotra</h2>
                        <h3>Operations Head, FMCG Company</h3>
                    </div>

                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>Their smart traceability platform made inventory monitoring faster and improved our warehouse efficiency with real-time scanning capabilities.</h3>
                            <img src="images/client/client-user-2.png" alt="">
                        </div>
                        <h2>Ananya Kapoor</h2>
                        <h3>Supply Chain Manager, Logistics Firm</h3>
                    </div>

                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>Implementing TRACESCI’s digital authentication solution increased consumer confidence and gave us stronger control over product verification.</h3>
                            <img src="images/client/client-user-3.png" alt="">
                        </div>
                        <h2>Karan Mehra</h2>
                        <h3>Brand Protection Lead, Pharma Company</h3>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


@endsection