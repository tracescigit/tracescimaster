@extends('web.layouts.app')
@section('content')


<div class="rev_slider_wrapper">
    <div id="slider1" class="rev_slider" data-version="5.0">
        <ul>
            <!-- SLIDE 1 -->
            <li data-index="rs-3" data-transition="parallaxtoright" data-delay="6500">

                <!-- MAIN IMAGE -->
                <img src="{{asset('dist/images/solution-bg.png')}}"
                    class="rev-slidebg"
                    data-bgposition="center center"
                    data-bgfit="cover"
                    data-bgrepeat="no-repeat">

                <!-- LAYER 1 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="120"
                    data-start="1200" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <span class="sl-italic" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
                        One Platform. Every Stakeholder. Zero Counterfeits.
                    </span>
                </div>

                <!-- LAYER 2 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="190"
                    data-start="1800" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
                        Cloud-Powered Track & Trace for Every Product.
                    </div>
                </div>

                <!-- LAYER 3 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="300"
                    data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="sl-italic sl-italic-2 text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
                        Serialize every product unit with a unique QR code. Track its complete journey<br>
                        from manufacturer to end consumer — accessible by brands, inspectors, and governments.
                    </div>
                </div>

            </li>

        </ul>
    </div>
</div>


<!-- the content -->
<div class="welcome-area">
    <!-- MAIN TITLE AREA -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="main-title wow zoomIn">
                    <div class="main-shadow-heading">
                        <h2>Hello, We Are Tracesci</h2>
                    </div>
                    <h2>Hello, We Are <span style="color:#7a0d7d">Tracesci</span></h2>
                    <h3>Cloud-Based Product Serialization, Authentication & Supply Chain Traceability</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="welcome-content">
        <div class="container">
            <div class="row">

                <!-- ITEM 1 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInLeft text-center">
                        <h3>Anti-Counterfeiting</h3>
                        <h2><span>01.</span> Authenticate</h2>
                        <p>
                            Every product unit gets a cryptographically unique QR code — making counterfeits instantly detectable by consumers, inspectors and brands alike.
                        </p>
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInDown text-center">
                        <h3>Supply Chain Visibility</h3>
                        <h2><span>02.</span> Track</h2>
                        <p>
                            Follow every product from raw material intake through manufacturing, packaging and distribution — right to the end consumer's scan.
                        </p>
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInUp text-center">
                        <h3>Real-Time Fraud Alerts</h3>
                        <h2><span>03.</span> Monitor</h2>
                        <p>
                            Behavior-based alert engine flags abnormal scan patterns, geo-location anomalies and suspected diversion — enabling instant enforcement action.
                        </p>
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInRight text-center">
                        <h3>GS1 Compliant</h3>
                        <h2><span>04.</span> Standardize</h2>
                        <p>
                            Fully GS1-compliant serialization that meets regulatory mandates across pharma, food, tobacco and more — in multiple countries.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Industries Section -->
    <div id="application" class="refresh-phone padding-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="title-block">
                        <div class="riven-heading text-center" data-sr="enter top wait 0.3s">
                            <h2>
                                Powered by <span style="color:#7a0d7d">Blockchain</span> — One Platform for Every Stakeholder
                            </h2>
                        </div>
                    </div>
                    <div class="refresh-phone-content">
                        <div class="text-desc">
                            <p class="text-center">
                                Tracesci's fully cloud-based Track &amp; Trace SaaS platform gives governments, brands, manufacturers,
                                inspectors and consumers a single unified system to authenticate and monitor products across the entire
                                supply chain. Every product unit is assigned a unique QR code at the point of manufacture —
                                scan it at any point to instantly verify authenticity, view the complete product journey,
                                and trigger real-time fraud alerts. Every event is logged on an immutable blockchain ledger,
                                accessible from anywhere, by any authorised stakeholder.
                            </p>
                        </div>
                        <a class="btn btn-primary ubtn">Industries We Serve</a>
                    </div>
                    <div class="spacer-100"></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.3s">
                    <div class="thumbnail-game text-center">
                        <img height="150" src="{{asset('web/images/Picture1.jpg')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="Apparel" />
                    </div>
                    <div class="desc text-center">
                        <h3>Apparel</h3>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.6s">
                    <div class="thumbnail-game text-center">
                        <img height="150" src="{{asset('web/images/Picture2.jpg')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="Food" />
                    </div>
                    <div class="desc text-center">
                        <h3>Food</h3>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.9s">
                    <div class="thumbnail-game text-center">
                        <img height="150" src="{{asset('web/images/Picture3.jpg')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="Automobile" />
                    </div>
                    <div class="desc text-center">
                        <h3>Automobile</h3>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 1.2s">
                    <div class="thumbnail-game text-center">
                        <img height="150" src="{{asset('web/images/Picture4.jpg')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="Tobacco" />
                    </div>
                    <div class="desc text-center">
                        <h3>Tobacco</h3>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.9s">
                    <div class="thumbnail-game text-center">
                        <img height="150" src="{{asset('web/images/Picture5.jpg')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="Pharma" />
                    </div>
                    <div class="desc text-center">
                        <h3>Pharma</h3>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 1.2s">
                    <div class="thumbnail-game text-center">
                        <img height="150" src="{{asset('web/images/Picture6.jpg')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="Beverages" />
                    </div>
                    <div class="desc text-center">
                        <h3>Beverages</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacer-100"></div>
    </div>
</div>


<!-- Dashboard Screenshot Section -->
<div class="software-screen-section" style="padding: 60px 0; background: #fff;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="main-title wow fadeInLeft">
                    <h2>Interactive <span style="color:#7a0d7d;">Analytics Dashboard</span></h2>
                    <p style="color:#555; font-size:16px; margin-top:15px;">
                        Get a real-time, bird's-eye view of your entire product ecosystem from one centralized dashboard.
                        Monitor live serialization status, track active shipments, generate enforcement reports,
                        visualise geo-location data and receive instant fraud alerts — all accessible by
                        manufacturers, brand owners, inspectors and government authorities from any device.
                    </p>
                </div>
            </div>
            <div class="col-md-6 wow fadeInRight">
                <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Tracesci Dashboard Screenshot" style="width:100%; height:80%; border-radius:8px; box-shadow: 0 10px 40px rgba(122,13,125,0.15);">
            </div>
        </div>
    </div>
</div>


<!-- Features Section -->
<div class="solution-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="main-title wow zoomIn">
                    <div class="main-shadow-heading">
                        <h2>Platform <span>Features</span></h2>
                    </div>
                    <h2>Platform <span style="color:#7a0d7d">Features</span></h2>
                    <h3>Cloud, Mobile & Software — Everything to Secure Your Supply Chain</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="solution-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
                        <h2>Unique QR Serialization</h2>
                        <p>Every product unit is assigned a cryptographically unique QR or barcode label at the point of manufacture. Codes are activated in real time on the production line and registered on an immutable blockchain record...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Antenna2"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>Brand & Product Protection</h2>
                        <p>Non-additive digital authentication secures your packaging without modifying your existing production line. Eliminate revenue loss from counterfeits and build lasting consumer trust in your brand...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Shield"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>Mobile Apps for All Stakeholders</h2>
                        <p>Dedicated Android and iOS apps for consumers to verify authenticity, and for inspectors to perform quick field audits. Works online and offline. Consumers can also report counterfeit products directly through the app...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-MessageLeft"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
                        <h2>End-to-End Supply Chain Traceability</h2>
                        <p>Track every product from raw material intake through manufacturing, packaging, distribution and last-mile delivery. Each checkpoint is immutably recorded — accessible to all authorised stakeholders in real time...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Chart"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>Regulatory Compliance</h2>
                        <p>Stay ahead of government traceability mandates. Our GS1-compliant platform supports compliance requirements across pharma, food, tobacco and more — with quick report generation built for enforcement agencies...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Tools"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>Seamless Hardware Integration</h2>
                        <p>Plug directly into your existing printing, labelling and conveyor systems. Compatible with vision inspection cameras, high-speed production lines and all major barcode formats — no production disruption...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Puzzle"></i></span>
                    </div>
                </div>
            </div>

            <!-- Serialization Feature Highlight -->
            <div class="software-screen-section" style="padding: 60px 0;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 wow fadeInLeft">
                            <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Product Serialization Screenshot" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 10px 40px rgba(122,13,125,0.15);">
                        </div>
                        <div class="col-md-6 wow fadeInRight" style="padding-left:40px;">
                            <div class="main-title text-left">
                                <h2>Product <span style="color:#7a0d7d;">Serialization</span> at Scale</h2>
                                <p style="color:#555; font-size:16px; margin-top:15px;">
                                    Assign a tamper-evident digital identity to every unit you produce — from a single carton
                                    to millions of SKUs. The serialization module integrates directly with your label supplier
                                    and printing hardware, generates codes on demand, and activates them in real time as
                                    products roll off the line. Scalable infrastructure handles large SKU volumes with ease.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="all-link solution-btn text-center">
                        <a href="#">View All Features</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- How It Works Section -->
    <div style="background-color: #f5f5f5; margin-top: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="main-title wow zoomIn">
                        <div class="main-shadow-heading">
                            <h2><span>How </span>It Works</h2>
                        </div>
                        <h2>How It <span style="color:#7a0d7d">Works</span></h2>
                        <h3>From Registration to Full Supply Chain Control in 4 Steps</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="help-content-area" style="background-color: #f5f5f5;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="help-accordion">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Step 1 — Brand & Manufacturer Onboarding
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            Complete paperless onboarding for brand owners, manufacturers and supply chain partners.
                                            Submit your company details, upload required documents and — once approved — gain full
                                            access to the Tracesci cloud platform. A FREE plan is activated by default, giving you
                                            all the essential tools to set up your solution and run a pilot at no cost, forever.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Step 2 — Configure Products, SKUs & Pricing Plan
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            Set up your product catalogue, define SKUs, packaging levels and batch parameters through
                                            the intuitive manufacturer interface. Choose a subscription plan that fits your volume —
                                            from the free tier for small businesses and startups all the way to enterprise plans
                                            for high-volume manufacturers. Upgrade anytime as your production scales, with no lock-in.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Step 3 — Serialize & Activate on the Production Line
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            Generate and print unique QR or barcode labels for every product unit directly through
                                            the Tracesci platform — integrated with your label supplier and printing hardware.
                                            Each code is activated the moment it's applied, creating an immutable blockchain record
                                            tied to that specific product, batch, manufacturing location and timestamp.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                Step 4 — Track, Verify, Report & Enforce
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                        <div class="panel-body">
                                            As products move through the supply chain — from warehouse to distributor to retailer to
                                            consumer — every scan is logged in real time with GPS location data. Governments and
                                            inspectors can verify authenticity in the field using the mobile app. Consumers can
                                            report counterfeits directly. The analytics dashboard surfaces fraud patterns and
                                            generates enforcement reports instantly — making every stakeholder a line of defence.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="help-question" style="margin-bottom: 50px;">
                            <p>Have questions about implementing Tracesci in your production environment or connecting it to your existing systems? Our team will walk you through every step.</p>
                            <span><a href="#">Talk to an Expert <i class="fa fa-long-arrow-right"> </i></a></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="help-slider-text">
                            <img src="{{ asset('dist/images/bbchain.png') }}" alt="Blockchain Traceability Diagram" style="left:-100px !important;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Section -->
        <div class="video-home" style="width: auto;">
            <div class="bg" style="background-image: url({{ asset('dist/images/logo_color.png') }}) !important; background-size: 10% !important; background-position: center !important; background-repeat: no-repeat !important; min-height: 500px !important; width: 100% !important; background:rgb(192, 192, 192);">
                <div class="riven-container container video-container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="top: 72px;">
                            <div class="wpb_text_column wpb_content_element">
                                <div class="wpb_wrapper">
                                    <p>
                                        <a class="fancybox btn-play" title="Watch Tracesci in action" href="{{asset('web/videos/tracesci_storyboard.mp4')}}" data-type="iframe"
                                            style="bottom: 132px;">
                                            Watch Now
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="spacer-20"></div>
                            <div class="title-block">
                                <div class="riven-heading text-center">
                                    <h2 style="color: #000 !important; font-weight: 400 !important;">
                                        <span style="font-weight: 800 !important;">Make Every Consumer</span> a Brand Protector
                                    </h2>
                                </div>
                            </div>
                            <div class="wpb_text_column wpb_content_element">
                                <div class="wpb_wrapper">
                                    <p style="color: #000 !important; font-weight: 300 !important;">
                                        Counterfeiting costs global businesses over $4 trillion a year. With Tracesci, every consumer who scans
                                        a QR code becomes an active participant in brand protection — verifying authenticity, reporting fakes
                                        and connecting with the brands they trust. Affordable for manufacturers of every size, from startups to enterprises.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Real-Time Tracking Screenshots -->
        <div class="software-screen-section" style="padding: 60px 0;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center wow zoomIn" style="margin-bottom:40px;">
                        <h2>Real-Time <span style="color:#7a0d7d;">Supply Chain Visibility</span></h2>
                        <p style="color:#555; font-size:16px; max-width:650px; margin:15px auto 0;">
                            Know exactly where every product is at every moment. From the instant a QR code is
                            activated on the production line to the moment a consumer or inspector scans it for
                            verification — every event is geo-tagged, timestamped and tamper-proof on the blockchain.
                            Accessible by all authorised stakeholders in real time.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 wow fadeInLeft" style="margin-bottom:20px;">
                        <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Live GPS Tracking" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                        <p style="text-align:center; margin-top:12px; color:#000000; font-weight:600;">Live GPS Location Tracking</p>
                    </div>
                    <div class="col-md-4 wow fadeInUp" style="margin-bottom:20px;">
                        <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Scan History Timeline" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                        <p style="text-align:center; margin-top:12px; color:#000000; font-weight:600;">Full Scan History Timeline</p>
                    </div>
                    <div class="col-md-4 wow fadeInRight" style="margin-bottom:20px;">
                        <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Blockchain Verification Ledger" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                        <p style="text-align:center; margin-top:12px; color:#000000; font-weight:600;">Immutable Blockchain Ledger</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Pricing Section -->
        <section class="pricing-table-section grey-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="main-title wow zoomIn">
                            <div class="main-shadow-heading">
                                <h2>Simple, Scalable Pricing</h2>
                            </div>
                            <h2>Simple, Scalable Pricing</h2>
                            <h3>Start Free — Pay as You Grow</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="all-link pricinig-head-btn text-center">
                            <a href="#">Monthly</a>
                            <a href="#">Yearly</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="pricing-table-content text-center wow fadeInLeft">
                            <div class="pricing-table-head">
                                <div class="pricing-head-top">
                                    <span>Starter Plan</span>
                                </div>
                                <div class="pricing-head-content">
                                    <span>$</span>
                                    <span>50</span>
                                    <span>/ Monthly</span>
                                </div>
                            </div>
                            <div class="pricing-table-inner-content">
                                <div class="pricing-table-title">
                                    <p>Perfect for small businesses, startups and printing vendors exploring product authentication for the first time.</p>
                                </div>
                                <div class="pricing-table-list">
                                    <ul>
                                        <li><span>1</span> Brand</li>
                                        <li><span>Up to 5</span> Product SKUs</li>
                                        <li>QR Code Serialization</li>
                                        <li>Consumer Verification App</li>
                                        <li>Basic Scan Analytics</li>
                                        <li><span>10,000</span> Codes / Month</li>
                                    </ul>
                                    <div class="all-link pricinig-bottom-btn text-center">
                                        <a href="#">Get Started Now <i class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="pricing-table-content text-center wow fadeInLeft">
                            <div class="pricing-table-head">
                                <div class="pricing-head-top">
                                    <span>Growth Plan</span>
                                </div>
                                <div class="pricing-head-content">
                                    <span>$</span>
                                    <span>70</span>
                                    <span>/ Monthly</span>
                                </div>
                            </div>
                            <div class="pricing-table-inner-content">
                                <div class="pricing-table-title">
                                    <p>For growing manufacturers needing multi-brand traceability, supply chain tracking and fraud detection.</p>
                                </div>
                                <div class="pricing-table-list">
                                    <ul>
                                        <li><span>3</span> Brands</li>
                                        <li><span>Up to 25</span> Product SKUs</li>
                                        <li>QR + GS1 Barcode Serialization</li>
                                        <li>End-to-End Supply Chain Tracking</li>
                                        <li>Suspicious Activity Alerts</li>
                                        <li><span>50,000</span> Codes / Month</li>
                                    </ul>
                                    <div class="all-link pricinig-bottom-btn text-center">
                                        <a href="#">Get Started Now <i class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="pricing-table-content text-center wow fadeInLeft">
                            <div class="pricing-table-head">
                                <div class="pricing-head-top">
                                    <span>Enterprise Plan</span>
                                </div>
                                <div class="pricing-head-content">
                                    <span>$</span>
                                    <span>90</span>
                                    <span>/ Monthly</span>
                                </div>
                            </div>
                            <div class="pricing-table-inner-content">
                                <div class="pricing-table-title">
                                    <p>Full-scale traceability for large manufacturers, government programs and multi-market supply chain operations.</p>
                                </div>
                                <div class="pricing-table-list">
                                    <ul>
                                        <li><span>Unlimited</span> Brands</li>
                                        <li><span>Unlimited</span> Product SKUs</li>
                                        <li>Full Serialization Suite</li>
                                        <li>Blockchain Ledger + GPS Tracking</li>
                                        <li>Inspector & Government Access</li>
                                        <li><span>Unlimited</span> Codes / Month</li>
                                    </ul>
                                    <div class="all-link pricinig-bottom-btn text-center">
                                        <a href="#">Get Started Now <i class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pricing-table-self">
                <img src="{{asset('dist/images/pricing-table-self.png')}}">
            </div>
        </section>

        <!-- Analytics & Reporting Section -->
        <div class="software-screen-section" style="padding: 60px 0;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 wow fadeInLeft" style="padding-right:40px;">
                        <div class="main-title text-left">
                            <h2>Analytics & <span style="color:#7a0d7d;">Anti-Counterfeit Intelligence</span></h2>
                            <p style="color:#555; font-size:16px; margin-top:15px;">
                                Data is your most powerful weapon against counterfeiting. Tracesci's analytics engine
                                surfaces geo-location heat maps, consumer scanning behaviour and behavior-based fraud
                                signals — revealing exactly where fakes are entering your supply chain and which markets
                                are most at risk, so brands, inspectors and governments can act fast.
                            </p>
                            
                        </div>
                    </div>
                    <div class="col-md-6 wow fadeInRight">
                        <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Tracesci Analytics Dashboard" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 10px 40px rgba(122,13,125,0.15);">
                    </div>
                </div>
            </div>
        </div>

        <x-notification></x-notification>
    </div>
</div>
@endsection


@section('script')
<script type="text/javascript">
    cash(function() {
        async function contact() {
            cash('.contact__input').removeClass('border-theme-6')
            cash('.contact__input-error').html('')
            cash('#contactError').addClass('hidden')

            let name = cash('#name').val()
            let email = cash('#email').val()
            let mobile = cash('#mobile').val()
            let message = cash('#message').val()

            cash('#contactwait').removeClass('hidden')
            axios.post('{{ url("send_inquiry") }}', {
                name: name,
                email: email,
                mobile: mobile,
                message: message
            }).then(res => {
                cash('#contactSuccess').removeClass('hidden')
                cash('#contactError').addClass('hidden')
                cash('#contactwait').addClass('hidden')
                setTimeout(() => {
                    window.location.reload()
                }, 3000)
            }).catch(err => {
                cash('#contactError').removeClass('hidden')
                cash('#contactSuccess').addClass('hidden')
                cash('#contactwait').addClass('hidden')
                cash('#btn-contact').html('Submit')
                if (err.response.data.errors) {
                    for (const [key, val] of Object.entries(err.response.data.errors)) {
                        cash(`#${key}`).addClass('border-theme-6')
                        cash(`#error-${key}`).html(val)
                    }
                }
            })
        }
        cash('#contact_form').on('keyup', function(e) {
            if (e.keyCode === 13) {
                contact()
            }
        })
        cash('#btn-contact').on('click', function() {
            contact()
        })
    })
</script>
<script>
    var revapi;
    jQuery(document).ready(function() {
        revapi = jQuery("#slider1").show().revolution({
            sliderType: "standard",
            sliderLayout: "fullscreen",
            delay: 999999999,
            stopLoop: "on",
            stopAfterLoops: 0,
            stopAtSlide: 1,
            disableProgressBar: "on",
            fullScreenOffsetContainer: ""
        });
        revapi.revpause();
    });
</script>
@endsection