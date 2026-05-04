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
                        <li><a href="#">home</a></li>
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
                        <div class="all-link pricinig-head-btn">
                            <a href="#">More About Us</a>
                        </div>
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
        <div class="row">
            <div class="col-sm-6 col-md-4 no-padding">
                <div class="our-philosophy-inner our-philosophy-inner-bg-1">
                    <h2>Our Mission</h2>
                    <p>To combat illicit trade, counterfeiting, revenue leakage, and the circulation of unsafe products. We empower governments, brands, and consumers with intelligent traceability solutions that protect every link in the supply chain — from manufacturer to end user.</p>
                    <span><i class="icon icon-Flag"></i></span>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 no-padding">
                <div class="our-philosophy-inner our-philosophy-inner-bg-2">
                    <h2>Our Vision</h2>
                    <p>To build a world where every product is authentic, every supply chain is transparent, and every consumer is protected. We envision a global ecosystem where traceability is accessible and affordable for businesses of all sizes — from startups to large enterprises and governments.</p>
                    <span><i class="icon icon-Bulb"></i></span>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 no-padding">
                <div class="our-philosophy-inner our-philosophy-inner-bg-3">
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
<div class="progress-bar-area">
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
</div>

<!-- =========================
        END TEAM SECTION
      ============================== -->

<!-- =========================
      START OUR STORY 2 SECTION
      ============================== -->
<section class="our-story-area our-story-2 grey-bg">
    <img class="wow fadeInLeft"
        src="{{ asset('web/images/about.jpg') }}"
        alt="Image"
        style="
            position: absolute;
            left: 0;
            top: 0;
            width: 46%;
            height: 100%;
         ">
    <div class="container">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="our-story-2-head">
                    <h3>Our Story</h3>
                    <h2>How It All <span style="color: #7a0d7d;">Began!</span></h2>
                    <p>We're TRACESCI, a product authentication and track & trace technology company headquartered in Chennai, Tamil Nadu. Born out of a growing need to fight illicit trade and counterfeiting, we set out to build a one-stop ecosystem that protects brands, governments, and consumers — making traceability affordable and accessible for everyone.</p>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="our-story-inner">
                        <h2>Who We Are</h2>
                        <p>A young and enthusiastic team of technology professionals leveraging the latest innovations in blockchain, serialization, and mobile intelligence to secure global supply chains.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="our-story-inner">
                        <h2>What We <span style="color: #7a0d7d;">Do</span></h2>
                        <p>We provide an end-to-end cloud-based track & trace platform combining serialization, authentication, mobile apps, real-time dashboards, and third-party integrations for brands and governments.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="our-story-inner">
                        <h2>Why We Do <span style="color: #7a0d7d;">It</span></h2>
                        <p>Illicit trade costs economies billions and puts lives at risk. We are driven by the belief that every product should be verifiable and every consumer should be safe from counterfeit goods.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="our-story-inner">
                        <h2>Our Values</h2>
                        <p>Integrity, innovation, and impact. We work in a 3-way partnership model with brands, label printers, and our platform — ensuring seamless integration, fast ROI, and long-term support for every client.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!-- =========================
      END OUR STORY 2 SECTION
      ============================== -->

<!-- =========================
      START CLIENT 2 SECTION
      ============================== -->
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
                            <h3>TRACESCI's platform gave us complete visibility across our supply chain. Counterfeiting incidents dropped dramatically after we deployed their serialization system.</h3>
                            <img src="images/client/client-user-1.png" alt="">
                        </div>
                        <h2>Supply Chain Director</h2>
                        <h3>FMCG Brand</h3>
                    </div>
                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>The blockchain-based track & trace solution from TRACESCI has significantly improved our tax compliance monitoring and reduced revenue leakage across the region.</h3>
                            <img src="images/client/client-user-2.png" alt="">
                        </div>
                        <h2>Revenue Authority Official</h2>
                        <h3>Government Body</h3>
                    </div>
                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>We were impressed by how quickly customers adopted scanning. TRACESCI’s mobile app turned consumers into active participants in protecting our brand.</h3>
                            <img src="images/client/client-user-3.png" alt="">
                        </div>
                        <h2>Brand Manager</h2>
                        <h3>Pharmaceutical Company</h3>
                    </div>
                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>TRACESCI's platform gave us complete visibility across our supply chain. Counterfeiting incidents dropped dramatically after we deployed their serialization system.</h3>
                            <img src="images/client/client-user-1.png" alt="">
                        </div>
                        <h2>Supply Chain Director</h2>
                        <h3>FMCG Brand</h3>
                    </div>
                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>The blockchain-based track & trace solution from TRACESCI has significantly improved our tax compliance monitoring and reduced revenue leakage across the region.</h3>
                            <img src="images/client/client-user-2.png" alt="">
                        </div>
                        <h2>Revenue Authority Official</h2>
                        <h3>Government Body</h3>
                    </div>
                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>We were impressed by how quickly customers adopted scanning. TRACESCI’s mobile app turned consumers into active participants in protecting our brand.</h3>
                            <img src="images/client/client-user-3.png" alt="">
                        </div>
                        <h2>Brand Manager</h2>
                        <h3>Pharmaceutical Company</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- =========================
      END CLIENT 2 SECTION
      ============================== -->

<!-- =========================
      START SUBSCRIBE SECTION
      ============================== -->
{{--<div class="subscribe-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="join-team subscribe-content clearfix wow zoomIn">
                    <div class="col-md-7">
                        <p>
                            <span><i class="icon icon-MessageLeft"></i></span> Metrics enterprise SEO and content marketing platform provides competitive insight and market analysis no one can duplicate.
                        </p>
                    </div>
                    <div class="col-md-5">
                        <div class="all-link pricinig-head-btn subscribe-btn">
                            <a href="#">Take The Tour</a>
                            <a href="#">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>--}}
<!-- =========================
      END SUBSCRIBE SECTION
      ============================== -->

<!-- =========================
        START CLIENT SECTION
      ============================== -->
{{--<section class="client-area">
    <!-- MAIN TITLE AREA -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="main-title wow zoomIn">
                    <div class="main-shadow-heading">
                        <h2>Our Partners Trust Us With Their Projects</h2>
                    </div>
                    <h2>Our Partners Trust Us With Their Projects</h2>
                    <h3>Customer success always comes first.</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- END TITLE -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="client-slider" class="owl-carousel all-carousel owl-theme">
                    <div class="client-slider">
                        <img src="images/client/client-1.png" alt="">
                    </div>
                    <div class="client-slider">
                        <img src="images/client/client-2.png" alt="">
                    </div>
                    <div class="client-slider">
                        <img src="images/client/client-3.png" alt="">
                    </div>
                    <div class="client-slider">
                        <img src="images/client/client-4.png" alt="">
                    </div>
                    <div class="client-slider">
                        <img src="images/client/client-5.png" alt="">
                    </div>
                    <div class="client-slider">
                        <img src="images/client/client-6.png" alt="">
                    </div>
                    <div class="client-slider">
                        <img src="images/client/client-1.png" alt="">
                    </div>
                    <div class="client-slider">
                        <img src="images/client/client-2.png" alt="">
                    </div>
                    <div class="client-slider">
                        <img src="images/client/client-3.png" alt="">
                    </div>
                    <div class="client-slider">
                        <img src="images/client/client-4.png" alt="">
                    </div>
                    <div class="client-slider">
                        <img src="images/client/client-5.png" alt="">
                    </div>
                    <div class="client-slider">
                        <img src="images/client/client-6.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>--}}
<!-- =========================
        END CLIENT SECTION
      ============================== -->


@endsection