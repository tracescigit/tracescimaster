@extends('web.layouts.app')
@section('content')
<style>
    /* Section spacing */
    .help-content-area {
        padding: 60px 0;
    }

    /* Accordion spacing */
    .help-accordion {
        margin-bottom: 30px;
    }

    /* Fix panel spacing */
    .panel {
        margin-bottom: 10px;
    }

    /* Improve readability */
    .panel-body {
        font-size: 14px;
        line-height: 1.7;
    }

    /* Fix image alignment */
    .help-slider-text {
        display: flex;
        align-items: start;
        justify-content: start;
        height: 100%;
    }

    /* Image fix */
    .help-img {
        max-width: 100%;
        height: auto;
        position: absolute;
        right: -220px !important;
    }

    .product_demo {
        background: #f5f5f5;
        padding: 10px 0px 20px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        min-height: 60vh;
    }

    .product_demo::before {
        content: "";
        position: absolute;
        width: 700px;
        height: 700px;
        border-radius: 50%;
        background: radial-gradient(rgba(255, 255, 255, 0.08), transparent 70%);
        top: -320px;
        left: -180px;
        animation: floatGlow 10s ease-in-out infinite;
    }

    .product_demo::after {
        content: "";
        position: absolute;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        background: radial-gradient(rgba(255, 255, 255, 0.05), transparent 70%);
        bottom: -220px;
        right: -140px;
        animation: floatGlow 12s ease-in-out infinite;
    }

    .product_demo .container {
        position: relative;
        z-index: 2;
    }

    .demo-badge {
        display: inline-block;
        background: #fff;
        border: 1px solid #000000;
        color: #000000;
        padding: 10px 22px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 30px;
        backdrop-filter: blur(8px);
        animation: fadeUp 0.8s ease;
    }

    .product_demo h2 {
        color: #000000;
        font-weight: 800;
        font-size: 28px;
        line-height: 1.15;
        margin-bottom: 24px;
        position: relative;
        animation: fadeUp 1s ease;
        letter-spacing: -1px;
    }

    .product_demo p {
        color: #000000;
        font-size: 15px;
        line-height: 1.9;
        max-width: 760px;
        margin: 0 auto 45px;
        animation: fadeUp 1.2s ease;
    }

    .demo-actions {
        animation: fadeUp 1.4s ease;
    }

    .product_demo .enterprise-btn {
        background: #fff;
        color: #7a0d7d !important;
        font-weight: 700;
        font-size: 16px;
        padding: 18px 42px;
        display: inline-flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
        transition: all 0.35s ease;
        position: relative;
        overflow: hidden;
        z-index: 1;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.28);
    }

    .product_demo .enterprise-btn::before {
        content: "";
        position: absolute;
        width: 0%;
        height: 100%;
        left: 0;
        top: 0;
        background: #7a0d7d;
        transition: width 0.4s ease;
        z-index: -1;
    }

    .product_demo .enterprise-btn:hover::before {
        width: 100%;
    }

    .product_demo .enterprise-btn:hover {
        color: #fff !important;
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 22px 45px rgba(0, 0, 0, 0.35);
    }

    .product_demo .enterprise-btn i {
        transition: 0.35s ease;
    }

    .product_demo .enterprise-btn:hover i {
        transform: translateX(7px);
    }

    /* ================= RESPONSIVE ================= */

    /* Tablet */
    @media (max-width: 991px) {

        .help-content-area .row {
            display: block;
        }

        .help-content-area .col-md-6 {
            width: 100%;
            margin-bottom: 30px;
        }

        .help-slider-text {
            margin-top: 20px;
        }
    }

    /* Mobile */
    @media (max-width: 576px) {

        .panel-title a {
            font-size: 14px;
            line-height: 1.4;
            display: block;
        }

        .panel-body {
            font-size: 13px;
        }

        .help-question {
            text-align: center;
        }

        .help-question a {
            display: inline-block;
            margin-top: 10px;
        }
    }

    /* ================= ADDED: GLOBAL RESPONSIVE FIXES ================= */

    /* Ensure containers don't overflow on small screens */
    .container {
        padding-left: 15px;
        padding-right: 15px;
        box-sizing: border-box;
    }

    /* ---- Hero / Revolution slider ---- */
    @media (max-width: 767px) {
        .rev_slider_wrapper {
            min-height: 300px;
        }

        .heading-rp-small {
            font-size: 26px !important;
            line-height: 1.3 !important;
            letter-spacing: 0 !important;
        }

        .tp-caption span {
            font-size: 13px !important;
        }
    }

    /* ---- Welcome section – 4-column grid ---- */
    @media (max-width: 991px) {
        .welcome-single-content {
            margin-bottom: 30px;
        }

        /* 2-up on tablet */
        .welcome-content .col-sm-3 {
            width: 50%;
            float: left;
        }
    }

    @media (max-width: 575px) {

        /* 1-up on mobile */
        .welcome-content .col-sm-3 {
            width: 100%;
            float: none;
        }
    }

    /* ---- Industries grid – 6 columns ---- */
    /* Bootstrap col-xs-6 already renders 2-per-row on mobile — no override needed */
    /* Ensure industry images scale but respect the height="150" attribute */
    #application .wp-post-image {
        max-width: 100%;
        width: auto !important;
        height: 150px;
        object-fit: contain;
    }

    @media (max-width: 480px) {
        #application .wp-post-image {
            height: 100px;
        }
    }

    /* ---- Software screenshot rows (image + text side-by-side) ---- */
    @media (max-width: 767px) {
        .software-screen-section .row.align-items-center {
            display: flex;
            flex-direction: column;
        }

        .software-screen-section .col-md-6 {
            width: 100%;
            padding-left: 15px !important;
            padding-right: 15px !important;
            margin-bottom: 25px;
        }

        .software-screen-section .col-md-6 img {
            width: 100% !important;
            height: auto !important;
        }

        .software-screen-section .row.align-items-center .col-md-6:first-child img {
            margin-bottom: 0;
        }
    }

    /* ---- Real-time tracking – 3-column screenshots ---- */
    @media (max-width: 767px) {
        .software-screen-section .col-md-4 {
            width: 100%;
            margin-bottom: 20px;
        }
    }

    /* ---- Solution / Features section – 3-column grid ---- */
    @media (max-width: 767px) {
        .solution-content .col-sm-6 {
            width: 100%;
            margin-bottom: 20px;
        }
    }

    /* ---- Pricing section – 3-column grid ---- */
    @media (max-width: 767px) {

        #pricing_table .col-sm-6,
        #pricing_table .col-md-4 {
            width: 100%;
            margin-bottom: 25px;
        }

        .pricing-table-self {
            display: none;
        }
    }

    @media (max-width: 991px) and (min-width: 768px) {
        #pricing_table .col-sm-6 {
            width: 50%;
        }
    }

    /* ---- Product demo section ---- */
    @media (max-width: 767px) {
        .product_demo {
            min-height: auto;
            padding: 40px 15px;
        }

        .product_demo h2 {
            font-size: 22px !important;
            letter-spacing: 0;
        }

        .product_demo p {
            font-size: 14px;
        }

        .product_demo .enterprise-btn {
            font-size: 14px;
            padding: 14px 24px;
        }
    }

    /* ---- Video section ---- */
    @media (max-width: 767px) {
        .video-home .bg {
            background-size: 30% !important;
            min-height: 360px !important;
            padding: 0 15px;
        }

        .video-home .riven-heading h2 {
            font-size: 20px !important;
        }

        .video-home .wpb_text_column p {
            font-size: 14px !important;
        }
    }

    /* ---- Help / How it works image – remove off-screen absolute on mobile ---- */
    @media (max-width: 991px) {
        .help-img {
            position: relative !important;
            right: auto !important;
            display: block;
            margin: 20px auto 0;
            max-width: 90%;
        }
    }

    /* ---- Analytics & Anti-counterfeit row ---- */
    @media (max-width: 767px) {
        .software-screen-section .col-md-6[style*="padding-right"] {
            padding-right: 15px !important;
        }
    }

    /* ---- Main titles ---- */
    @media (max-width: 575px) {
        .main-title h2 {
            font-size: 22px !important;
        }

        .main-title h3 {
            font-size: 15px !important;
        }

        .riven-heading h2 {
            font-size: 20px !important;
        }
    }

    /* ---- Hero / Revolution slider ---- */
    @media (max-width: 1199px) {
        .heading-rp-small {
            font-size: 36px !important;
            line-height: 1.3 !important;
        }
    }

    @media (max-width: 991px) {
        .rev_slider_wrapper {
            min-height: 400px;
        }

        .heading-rp-small {
            font-size: 28px !important;
            line-height: 1.3 !important;
            letter-spacing: 0 !important;
        }

        .tp-caption span {
            font-size: 14px !important;
        }

        .tp-caption div {
            font-size: 14px !important;
            line-height: 1.5 !important;
        }
    }

    @media (max-width: 767px) {
        .rev_slider_wrapper {
            min-height: 320px;
        }

        .heading-rp-small {
            font-size: 50px !important;
            line-height: 1.2 !important;
            letter-spacing: 0 !important;
        }

        .tp-caption span {
            font-size: 12px !important;
            line-height: 1.4 !important;
        }

        .tp-caption div {
            font-size: 12px !important;
            line-height: 1.4 !important;
        }

        /* Force layers to not overflow horizontally */
        .tp-caption {
            width: 90vw !important;
            left: 5vw !important;
            white-space: normal !important;
            text-align: center !important;
        }

        /* Hide the <br> so subtext wraps naturally on small screens */
        .tp-caption br {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .rev_slider_wrapper {
            min-height: 260px;
        }

        .heading-rp-small {
            font-size: 16px !important;
            line-height: 1.2 !important;
        }

        .tp-caption span,
        .tp-caption div {
            font-size: 11px !important;
        }
    }

    /* ---- General: prevent horizontal overflow ---- */
    /* Scoped to content images — excludes .wp-post-image (industry icons) and slider images */
    .software-screen-section img,
    .solution-area img,
    .welcome-area img:not(.wp-post-image):not(.rev-slidebg),
    .video-home img,
    .product_demo img {
        max-width: 100%;
        height: auto;
    }

    /* box-sizing scoped to layout elements only — avoids breaking Revolution Slider / plugins */
    .container,
    .row,
    [class*="col-"] {
        box-sizing: border-box;
    }
</style>
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
                    <span style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 600; font-size: 17px;">
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
                    <div class="text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 600; font-size: 17px;">
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
                        <h2><span>01.</span> Verify</h2>
                        <p>
                            Detect suspicious scans and diversion risks with advanced analytics for faster enforcement response and stronger supply chain protection.

                        </p>
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInDown text-center">
                        <h3>Supply Chain Visibility</h3>
                        <h2><span>02.</span> Trace</h2>
                        <p>
                            Track legitimate products with real-time supply chain transparency on one unified platform for governments, brands, and distributors.
                        </p>
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInUp text-center">
                        <h3>Real-Time Fraud Alerts</h3>
                        <h2><span>03.</span> Observe</h2>
                        <p>
                            Flag abnormal scans, geo-location anomalies, and product diversion risks with instant intelligence for brands and enforcement agencies.
                        </p>
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInRight text-center">
                        <h3>GS1 Compliant</h3>
                        <h2><span>04.</span> Unify</h2>
                        <p>
                            Enable governments to prevent illicit trade, secure tax revenues, and help brands protect markets while driving innovation and economic growth.
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
                                Unified <span style="color:#7a0d7d">Blockchain Platform</span> for Complete Supply Chain Visibility
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
                        <img height="150" src="{{asset('web/images/fmcg.png')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="Apparel" />
                    </div>
                    <div class="desc text-center">
                        <h3>FMCG</h3>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.6s">
                    <div class="thumbnail-game text-center">
                        <img height="150" src="{{asset('web/images/dairy.png')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="Food" />
                    </div>
                    <div class="desc text-center">
                        <h3>Dairy</h3>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.9s">
                    <div class="thumbnail-game text-center">
                        <img height="150" src="{{asset('web/images/chemicals.png')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="Automobile" />
                    </div>
                    <div class="desc text-center">
                        <h3>Chemicals</h3>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 1.2s">
                    <div class="thumbnail-game text-center">
                        <img height="150" src="{{asset('web/images/textiles.png')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="Tobacco" />
                    </div>
                    <div class="desc text-center">
                        <h3>Textiles</h3>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.9s">
                    <div class="thumbnail-game text-center">
                        <img height="150" src="{{asset('web/images/packaging.png')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="Pharma" />
                    </div>
                    <div class="desc text-center">
                        <h3>Packaging</h3>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 1.2s">
                    <div class="thumbnail-game text-center">
                        <img height="150" src="{{asset('web/images/warehousing.png')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="Beverages" />
                    </div>
                    <div class="desc text-center">
                        <h3>Warehousing</h3>
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
                <img src="{{ asset('dist/images/analytics.png') }}" alt="Tracesci Dashboard Screenshot" style="width:100%; height:80%; border-radius:8px; box-shadow: 0 10px 40px rgba(122,13,125,0.15);">
            </div>
        </div>
    </div>
</div>


<!-- Features Section -->
<div class="solution-area" style="background-color: #f5f5f5;">
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
                        <h2>Encrypted QR Authentication</h2>
                        <p>Every product unit is assigned a cryptographically unique QR or barcode label at the point of manufacture. Codes are activated in real time on the production line and registered on an immutable blockchain record...</p>
                        <a href="#"></a>
                        <span><i class="icon icon-Antenna2"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>Advanced Brand Protection</h2>
                        <p>Non-additive digital authentication secures your packaging without modifying your existing production line. Eliminate revenue loss from counterfeits and build lasting consumer trust in your brand...</p>
                        <a href="#"></a>
                        <span><i class="icon icon-Shield"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>Stakeholder Mobile Applications</h2>
                        <p>Dedicated Android and iOS apps for consumers to verify authenticity, and for inspectors to perform quick field audits. Works online and offline. Consumers can also report counterfeit products directly through the app...</p>
                        <a href="#"></a>
                        <span><i class="icon icon-MessageLeft"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
                        <h2>Complete Supply Traceability</h2>
                        <p>Track every product from raw material intake through manufacturing, packaging, distribution and last-mile delivery. Each checkpoint is immutably recorded — accessible to all authorised stakeholders in real time...</p>
                        <a href="#"></a>
                        <span><i class="icon icon-Chart"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>Regulatory Compliance Management</h2>
                        <p>Stay ahead of government traceability mandates. Our GS1-compliant platform supports compliance requirements across pharma, food, tobacco and more — with quick report generation built for enforcement agencies...</p>
                        <a href="#"></a>
                        <span><i class="icon icon-Tools"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>Integrated Hardware Connectivity</h2>
                        <p>Plug directly into your existing printing, labelling and conveyor systems. Compatible with vision inspection cameras, high-speed production lines and all major barcode formats — no production disruption...</p>
                        <a href="#"></a>
                        <span><i class="icon icon-Puzzle"></i></span>
                    </div>
                </div>
            </div>

            <!-- Serialization Feature Highlight -->



        </div>
    </div>
</div>

<div class="software-screen-section" style="padding: 60px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 wow fadeInLeft">
                <img src="{{ asset('dist/images/serialization.png') }}" alt="Product Serialization Screenshot" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 10px 40px rgba(122,13,125,0.15);">
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

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="help-slider-text">
                            <img src="{{ asset('dist/images/bbchain.png') }}"
                                alt="Blockchain Traceability Diagram"
                                class="help-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>-->

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
                <img src="{{ asset('dist/images/gps_tracking.png') }}" alt="Live GPS Tracking" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                <p style="text-align:center; margin-top:12px; color:#000000; font-weight:600;">Live GPS Location Tracking</p>
            </div>
            <div class="col-md-4 wow fadeInUp" style="margin-bottom:20px;">
                <img src="{{ asset('dist/images/supply_chain3.png') }}" alt="Scan History Timeline" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                <p style="text-align:center; margin-top:12px; color:#000000; font-weight:600;">Full Scan History Timeline</p>
            </div>
            <div class="col-md-4 wow fadeInRight" style="margin-bottom:20px;">
                <img src="{{ asset('dist/images/blockchain.png') }}" alt="Blockchain Verification Ledger" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                <p style="text-align:center; margin-top:12px; color:#000000; font-weight:600;">Immutable Blockchain Ledger</p>
            </div>
        </div>
    </div>
</div>


<!-- Pricing Section -->



<!-- Pricing Section -->
<section id="pricing_table" class="pricing-table-section grey-bg">
    <!-- MAIN TITLE AREA -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="main-title wow zoomIn">
                    <div class="main-shadow-heading">
                        <h2>Join Our Successful Customers</h2>
                    </div>
                    <h2>Join Our Successful Customers</h2>
                    <h3>Choose Your Plan</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- END TITLE -->
    <!-- <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="all-link pricinig-head-btn text-center">
                            <a href="#">Monthly</a>
                            <a href="#">Yearly</a>
                        </div>
                    </div>
                </div>
            </div> -->
    <!-- PRICING TABLE CONTENT -->
    @foreach(getPlan() as $plan)
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="pricing-table-content text-center wow fadeInLeft">
                    <div class="pricing-table-head">
                        <div class="pricing-head-top">
                            <span>{{$plan->title}}</span>
                        </div>
                        <div class="pricing-head-content">
                            <span> @if ($country=='India')
                                &#8377; {{$plan->price_inr}}/-
                                @else
                                $ {{$plan->price_usd}}
                                @endif
                                <br>
                                <span>Monthly</span>
                            </span>
                        </div>

                    </div>
                    <div class="pricing-table-inner-content">
                        <div class="pricing-table-title">
                            <p>All plans are include Funnel Report, Cohort Report, Revenue Report, People Search, and A/B Testing Report.</p>
                        </div>
                        <div class="pricing-table-list">
                            <ul>
                                {!!$plan->description!!}
                            </ul>
                            <div class="all-link pricinig-bottom-btn text-center">
                                <a href="{{route('register-view')}}">Sign Up Now <i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endforeach
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
                <img src="{{ asset('dist/images/conterfied.png') }}" alt="Tracesci Analytics Dashboard" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 10px 40px rgba(122,13,125,0.15);">
            </div>
        </div>
    </div>

    <x-notification></x-notification>
    <!-- </div> -->
</div>
<div class="product_demo">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!-- <div class="demo-badge">
                    Elite4 High-Speed Inkjet System
                </div> -->

                <h2>
                    Blockchain-Powered Product &amp; <span style="color: #7a0d7d;">Traceability & Authentication</span>
                </h2>

                <p>
                    Tracesci Cloud Solution enables secure product serialization, anti-counterfeit
                    verification, mobile authentication, and end-to-end supply chain traceability
                    through a scalable blockchain-powered platform built for modern manufacturers,
                    regulators, and global distribution networks.
                </p>

                <div class="demo-actions">
                    <a href="{{route('demo-schedule-create')}}" class="enterprise-btn">
                        Schedule Cloud Demo
                        <i class="fa fa-long-arrow-right"></i>
                    </a>
                </div>

            </div>
        </div>
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