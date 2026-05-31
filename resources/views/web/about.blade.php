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
        padding: 0px 0;
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
        margin-top: 210px;
        width: 90%;
        height: 70%;
        object-fit: cover;
        margin-left: 60px;

        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Content spacing */
    .our-story-2-head {
        margin-bottom: 30px;
        text-align: center;
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
            margin-top: 0px;
            margin-bottom: 60px;
        }
    }

    @media (max-width: 767px) {
        .contact-photo {
            width: 100%;
            margin-bottom: 20px;
        }

        .story-img {
            width: 100%;
            margin-top: 0px;
            margin-left: 0px;
            margin-bottom: 60px;
            height: auto;
        }
    }

    @media (max-width: 575px) {
        .contact-photo {
            width: 100%;
            margin-bottom: 15px;
        }

        .story-img {
            width: 100%;
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
                                <h2>100%</h2>
                                <p>End-to-End Solution</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="welcome-2-right-content-inner w-r-l-border">
                                <span><i class="icon icon-Users"></i></span>
                                <h2>24/7</h2>
                                <p>Customer Support</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="welcome-2-right-content-inner w-r-l-border">
                                <span><i class="icon icon-ChartUp"></i></span>
                                <h2>6+</h2>
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

<section class="our-story-area our-story-2 grey-bg position-relative">

    <!-- Left Image -->


    <div class="container">
        <div class="row align-items-center">
            <div class="our-story-2-head" style="margin-bottom: 60px;">
                <h3>Our Story</h3>
                <h2>How It All <span style="color: #7a0d7d;">Began!</span></h2>

            </div>
            <div class="contact-photo reveal">
                <img src="{{asset('web/images/how_started.jpg')}}"
                    alt="Man and woman working together"
                    class="story-img">
            </div>

            <!-- Empty space for image on desktop -->
            <div class="col-md-6 d-none d-md-block"></div>

            <!-- Content -->
            <div class="col-md-6">
                <p>
                    We're TRACESCI, a product authentication and track & trace technology company headquartered in Chennai with branches also on Gurugram and Mumbai,Established to combat the rising challenges of illicit trade and counterfeiting.
                </p>


                <!-- Inner Grid -->
                <div class="row mt-4">

                    <div class="col-sm-6 mb-2">
                        <div class="our-story-inner">
                            <h2>Who We Are</h2>
                            <p>A dynamic team of technology and supply chain experts dedicated to transforming how products are authenticated and tracked. </p>
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
                            <h3>TRACESCI helped us eliminate blind spots in our distribution network. With end-to-end traceability, we can now verify every product movement and quickly identify supply chain issues.</h3>
                            <img src="images/client/client-user-1.png" alt="">
                        </div>
                        <h2>Rajesh Sharma</h2>
                        <h3>Supply Chain Director, FMCG Company</h3>
                    </div>

                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>The serialization and authentication platform has significantly strengthened our anti-counterfeiting efforts. Our customers can now verify products instantly using a simple scan.</h3>
                            <img src="images/client/client-user-2.png" alt="">
                        </div>
                        <h2>Priya Nair</h2>
                        <h3>Brand Protection Manager, Pharmaceutical Company</h3>
                    </div>

                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>TRACESCI's tax stamp and track-and-trace solution has improved compliance monitoring and provided greater visibility into product movement across multiple regions.</h3>
                            <img src="images/client/client-user-3.png" alt="">
                        </div>
                        <h2>Michael Anderson</h2>
                        <h3>Compliance Officer, Government Revenue Authority</h3>
                    </div>

                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>The platform enabled us to monitor our agricultural products from production to retail shelves. This transparency has strengthened customer confidence in our brand.</h3>
                            <img src="images/client/client-user-1.png" alt="">
                        </div>
                        <h2>Sophia Williams</h2>
                        <h3>Operations Head, Agro Company</h3>
                    </div>

                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>Implementing TRACESCI's blockchain-powered traceability system has improved product authentication and helped us build stronger trust with distributors and retailers.</h3>
                            <img src="images/client/client-user-2.png" alt="">
                        </div>
                        <h2>Neha Agarwal</h2>
                        <h3>Quality Assurance Director, Cosmetics Company</h3>
                    </div>

                    <div class="client-2-slider">
                        <div class="client-2-slider-content">
                            <span><i class="fa fa-quote-left"></i></span>
                            <h3>Our manufacturing and logistics teams now have access to real-time product tracking. The insights generated by TRACESCI have improved efficiency and reduced operational risks.</h3>
                            <img src="images/client/client-user-3.png" alt="">
                        </div>
                        <h2>Vikram Reddy</h2>
                        <h3>Logistics Manager, Consumer Electronics Company</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- =========================
      END CLIENT 2 SECTION
      ============================== -->




@endsection