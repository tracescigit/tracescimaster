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
                        Full Control. Every Stakeholder. Zero Counterfeits.
                    </span>
                </div>

                <!-- LAYER 2 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="190"
                    data-start="1800" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
                        Enterprise-Grade Track &amp; Trace — Built for You.
                    </div>
                </div>

                <!-- LAYER 3 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="300"
                    data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="sl-italic sl-italic-2 text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
                        A fully customized, large-scale serialization and authentication platform<br>
                        for governments, large brands and enterprises — hosted, on-premise or dedicated portal.
                    </div>
                </div>

            </li>

        </ul>
    </div>
</div>


<!-- Overview -->
<div class="welcome-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="main-title wow zoomIn">
                    <div class="main-shadow-heading">
                        <h2>Enterprise Solution</h2>
                    </div>
                    <h2><span style="color:#7a0d7d">Enterprise Solution</span> — Tracesci</h2>
                    <h3>Fully Customized, Large-Scale Track &amp; Trace Infrastructure</h3>
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
                        <h3>Customized Platform</h3>
                        <h2><span>01.</span> Tailored</h2>
                        <p>
                            Every deployment is built around your specific business or government requirements — flexible architecture, custom workflows and a dedicated portal configured to your use case.
                        </p>
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInDown text-center">
                        <h3>Multi-Stakeholder</h3>
                        <h2><span>02.</span> Integrated</h2>
                        <p>
                            Manufacturer, brand, authority, printer and inspector modules — all connected in one unified system with role-based access control and centralized monitoring.
                        </p>
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInUp text-center">
                        <h3>Deployment Flexibility</h3>
                        <h2><span>03.</span> On Your Terms</h2>
                        <p>
                            Choose client-server, hosted cloud, on-premise or a fully dedicated portal. Your data, your infrastructure, your control — with Tracesci powering it all.
                        </p>
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInRight text-center">
                        <h3>Scalable at Volume</h3>
                        <h2><span>04.</span> Enterprise-Ready</h2>
                        <p>
                            Built for large product volumes, multi-market supply chains and government-scale traceability programs — with unlimited brands, SKUs and serialization capacity.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Platform Overview Section -->
    <div id="application" class="refresh-phone padding-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="title-block">
                        <div class="riven-heading text-center" data-sr="enter top wait 0.3s">
                            <h2>
                                One Platform. Every Stakeholder. Powered by <span style="color:#7a0d7d">Blockchain</span>.
                            </h2>
                        </div>
                    </div>
                    <div class="refresh-phone-content">
                        <div class="text-desc">
                            <p class="text-center">
                                Tracesci's Enterprise Solution delivers a fully customized track &amp; trace platform for organizations
                                that require deep control, security and integration at scale. Whether you are a government authority,
                                a large brand or an enterprise manufacturer, we configure a dedicated system — complete with
                                manufacturer, brand, authority and printer modules — tailored to your workflows, your infrastructure
                                and your regulatory environment. Every product event is logged on an immutable blockchain ledger,
                                accessible in real time by every authorised stakeholder.
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
                    <h2>Centralized <span style="color:#7a0d7d;">Analytics Dashboard</span></h2>
                    <p style="color:#555; font-size:16px; margin-top:15px;">
                        Get a real-time, bird's-eye view of your entire enterprise product ecosystem from one centralized command center.
                        Monitor live serialization status, track active shipments, generate enforcement reports,
                        visualise geo-location heat maps and receive instant fraud alerts — accessible by
                        manufacturers, brand owners, inspectors and government authorities from any device.
                    </p>
                </div>
            </div>
            <div class="col-md-6 wow fadeInRight">
                <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Tracesci Enterprise Dashboard" style="width:100%; height:80%; border-radius:8px; box-shadow: 0 10px 40px rgba(122,13,125,0.15);">
            </div>
        </div>
    </div>
</div>


<!-- Core Capabilities & Features Section -->
<div class="solution-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="main-title wow zoomIn">
                    <div class="main-shadow-heading">
                        <h2>Core <span>Capabilities</span></h2>
                    </div>
                    <h2>Core <span style="color:#7a0d7d">Capabilities</span></h2>
                    <h3>Everything You Need to Secure Your Supply Chain at Scale</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="solution-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
                        <h2>Full Track &amp; Trace System</h2>
                        <p>End-to-end product traceability from raw material intake through manufacturing, packaging, distribution and last-mile delivery. Every checkpoint is immutably recorded and accessible to all authorised stakeholders in real time.</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Chart"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>Product Authentication at All Levels</h2>
                        <p>Every product unit is assigned a cryptographically unique QR or barcode label. Authentication is available to consumers, inspectors, government authorities and brand teams — across the entire supply chain hierarchy.</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Shield"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>Multi-Stakeholder Integration</h2>
                        <p>Dedicated modules for manufacturers, brand owners, government authorities and printers — each with role-based access, custom workflows and a unified view of the entire product ecosystem.</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Puzzle"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
                        <h2>Custom Mobile Applications</h2>
                        <p>Bespoke Android and iOS apps built specifically for your enterprise workflows — supporting inspectors, auditors and consumers. Works online and offline. Consumers can report counterfeit products directly through the app.</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-MessageLeft"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>Real-Time Alerts &amp; Fraud Detection</h2>
                        <p>Behavior-based alert engine flags abnormal scan patterns, geo-location anomalies and suspected diversion the moment they occur — enabling instant enforcement action by inspectors and brand teams.</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Antenna2"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>High-Level Security &amp; Data Control</h2>
                        <p>Secure, role-based access for every stakeholder. Hosted, on-premise or dedicated portal deployment options. Scalable for large product volumes — with full data sovereignty and compliance-ready audit trails.</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Tools"></i></span>
                    </div>
                </div>
            </div>

            <!-- Serialization Feature Highlight -->
            <div class="software-screen-section" style="padding: 60px 0;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 wow fadeInLeft">
                            <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Enterprise Serialization" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 10px 40px rgba(122,13,125,0.15);">
                        </div>
                        <div class="col-md-6 wow fadeInRight" style="padding-left:40px;">
                            <div class="main-title text-left">
                                <h2>Serialization <span style="color:#7a0d7d;">at Enterprise Scale</span></h2>
                                <p style="color:#555; font-size:16px; margin-top:15px;">
                                    Assign a tamper-evident digital identity to every unit you produce — from a single carton
                                    to millions of SKUs across multiple brands and markets. The serialization module integrates
                                    directly with your label supplier and printing hardware, generates codes on demand and
                                    activates them in real time as products roll off the line. Unlimited capacity, zero production disruption.
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
                        <h3>From Onboarding to Full Enterprise Supply Chain Control in 4 Steps</h3>
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
                                                Step 1 — Consultation &amp; Custom Configuration
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            Our enterprise team works with you to map your exact requirements — business processes,
                                            regulatory environment, stakeholder roles and integration points. We design a platform
                                            architecture tailored to your use case, whether that is a government track &amp; trace mandate,
                                            a multi-brand manufacturer deployment or a security document system.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Step 2 — Module Setup &amp; Stakeholder Onboarding
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            Configure your manufacturer, brand, authority and printer modules with tailored access controls
                                            for every stakeholder group. Onboard manufacturers, inspectors, auditors and government users
                                            through a fully paperless process. Custom mobile applications are built and deployed for your
                                            specific inspector and consumer workflows.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Step 3 — Serialize &amp; Activate at Scale
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            Generate and print unique QR or barcode labels for every product unit — integrated directly
                                            with your label supplier and existing printing hardware. Each code is activated the moment
                                            it is applied, creating an immutable blockchain record tied to that specific product, batch,
                                            manufacturing location and timestamp. Handles unlimited volume across multiple production sites.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                Step 4 — Monitor, Enforce &amp; Report in Real Time
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                        <div class="panel-body">
                                            As products move through the supply chain, every scan is logged with GPS location data.
                                            Government inspectors verify authenticity in the field using the custom mobile app.
                                            The centralized dashboard surfaces geo-data analysis, consumer engagement insights and
                                            fraud patterns — generating enforcement reports instantly for regulatory authorities
                                            and brand protection teams. Every stakeholder is an active line of defence.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="help-question" style="margin-bottom: 50px;">
                            <p>Ready to implement Tracesci Enterprise in your organization? Our team will guide you through every step — from architecture design to go-live.</p>
                            <!-- <span><a href="#">Talk to an Expert <i class="fa fa-long-arrow-right"> </i></a></span> -->
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
                                        <span style="font-weight: 800 !important;">Built for Organizations</span> That Demand Full Control
                                    </h2>
                                </div>
                            </div>
                            <div class="wpb_text_column wpb_content_element">
                                <div class="wpb_wrapper">
                                    <p style="color: #000 !important; font-weight: 300 !important;">
                                        Counterfeiting costs global businesses over $4 trillion a year. Tracesci's Enterprise Solution gives governments,
                                        large brands and enterprises the customized, large-scale infrastructure they need to eradicate fakes — with full
                                        control over data, deployment and stakeholder access. Every consumer who scans a QR code becomes an active
                                        participant in brand protection.
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
                            activated on the production line to the moment an inspector or consumer scans it —
                            every event is geo-tagged, timestamped and tamper-proof on the blockchain.
                            Accessible by all authorised stakeholders in real time, from anywhere.
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


        <!-- Ideal For Section -->
        <section style="padding: 60px 0; background: #fff;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="main-title wow zoomIn">
                            <div class="main-shadow-heading">
                                <h2>Ideal For</h2>
                            </div>
                            <h2>Who Is It <span style="color:#7a0d7d">Ideal For?</span></h2>
                            <h3>Built for Organizations That Require Full Control, Customization and Scale</h3>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px;">
                    <div class="col-sm-6 col-md-3 text-center wow fadeInLeft" style="margin-bottom:30px;">
                        <div style="border-radius:10px; padding:30px 20px;">
                            <i class="icon icon-Shield" style="font-size:40px; color:#7a0d7d;"></i>
                            <h3 style="margin-top:15px; color:#7a0d7d;">Governments</h3>
                            <p style="color:#555;">National and regional authorities running large-scale product traceability, tax stamp or regulatory compliance mandates.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 text-center wow fadeInUp" style="margin-bottom:30px;">
                        <div style="border-radius:10px; padding:30px 20px;">
                            <i class="icon icon-Antenna2" style="font-size:40px; color:#7a0d7d;"></i>
                            <h3 style="margin-top:15px; color:#7a0d7d;">Large Brands &amp; Enterprises</h3>
                            <p style="color:#555;">Multi-brand manufacturers and brand owners needing full supply chain visibility across complex, multi-market operations.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 text-center wow fadeInUp" style="margin-bottom:30px;">
                        <div style="border-radius:10px; padding:30px 20px;">
                            <i class="icon icon-Tools" style="font-size:40px; color:#7a0d7d;"></i>
                            <h3 style="margin-top:15px; color:#7a0d7d;">Security Document Systems</h3>
                            <p style="color:#555;">Organizations issuing secure, serialized documents — from certificates and licenses to regulated product labels requiring anti-tampering.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 text-center wow fadeInRight" style="margin-bottom:30px;">
                        <div style="border-radius:10px; padding:30px 20px;">
                            <i class="icon icon-MessageLeft" style="font-size:40px; color:#7a0d7d;"></i>
                            <h3 style="margin-top:15px; color:#7a0d7d;">Education Sector</h3>
                            <p style="color:#555;">Institutions authenticating academic credentials, certificates and secure documentation to prevent fraud and forgery.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Analytics & Reporting Section -->
        <div class="software-screen-section" style="padding: 60px 0;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 wow fadeInLeft" style="padding-right:40px;">
                        <div class="main-title text-left">
                            <h2>Geo-Data Analysis &amp; <span style="color:#7a0d7d;">Anti-Counterfeit Intelligence</span></h2>
                            <p style="color:#555; font-size:16px; margin-top:15px;">
                                Data is your most powerful weapon against counterfeiting. Tracesci's analytics engine
                                surfaces geo-location heat maps, consumer scanning behaviour and behavior-based fraud
                                signals — revealing exactly where fakes are entering your supply chain and which markets
                                are most at risk. Enforcement reports generated instantly for government authorities
                                and brand protection teams.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 wow fadeInRight">
                        <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Tracesci Analytics Dashboard" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 10px 40px rgba(122,13,125,0.15);">
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div style="background: #333; padding: 60px 0; text-align:center;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 style="color:#fff; font-weight:800; font-size:34px; margin-bottom:15px;">Ready to Deploy Enterprise Track &amp; Trace?</h2>
                        <p style="color:rgba(255,255,255,0.85); font-size:17px; max-width:600px; margin:0 auto 30px;">
                            Talk to our enterprise team. We will assess your requirements, design the right architecture
                            and walk you through every step — from pilot to full-scale deployment.
                        </p>
                        <a href="{{route('demo-schedule-create')}}" class="btn btn-primary" style="background:#fff; color:#7a0d7d; font-weight:700; font-size:16px; padding:14px 36px;">
                            Request a Demo <i class="fa fa-long-arrow-right"></i>
                        </a>
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