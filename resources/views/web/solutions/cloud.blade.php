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
                        Authenticate. Track. Protect.
                    </span>
                </div>

                <!-- LAYER 2 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="190"
                    data-start="1800" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
                        Stop Counterfeits. Secure Your Brand.
                    </div>
                </div>

                <!-- LAYER 3 -->
                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="300"
                    data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300" ;>
                    <div class="sl-italic sl-italic-2 text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
                        Assign unique digital identities to every product unit. Track its journey<br>
                        from factory floor to end consumer — powered by blockchain.
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
                    <h3>End-to-End Product Authentication & Traceability</h3>
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
                            Assign unique QR codes and digital identities to every product unit — making fakes impossible to pass off as genuine.
                        </p>
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInDown text-center">
                        <h3>Supply Chain Visibility</h3>
                        <h2><span>02.</span> Track</h2>
                        <p>
                            Blockchain-enabled tracking from manufacturer to end consumer — every scan, every movement, on record.
                        </p>
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInUp text-center">
                        <h3>Suspicious Activity Alerts</h3>
                        <h2><span>03.</span> Monitor</h2>
                        <p>
                            Real-time alerts for abnormal scan patterns, geographic anomalies and potential diversion of goods.
                        </p>
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInRight text-center">
                        <h3>GS1 Compliant</h3>
                        <h2><span>04.</span> Standardize</h2>
                        <p>
                            Fully GS1-compliant serialization that meets global regulatory and trade standards across industries.
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
                                Powered by <span style="color:#7a0d7d">Blockchain</span> — Authentic, Safe & Connected
                            </h2>
                        </div>
                    </div>
                    <div class="refresh-phone-content">
                        <div class="text-desc">
                            <p class="text-center">
                                Tracesci's SaaS platform gives brand owners a complete digital window into their supply chain.
                                Every product unit gets a unique QR code — scan it to instantly verify authenticity, view the full journey from production to delivery,
                                and receive alerts when something looks suspicious. From raw material intake to the consumer's hands,
                                every step is logged on an immutable blockchain ledger.
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
                    <h2>Powerful <span style="color:#7a0d7d;">Command Dashboard</span></h2>
                    <p style="color:#555; font-size:16px; margin-top:15px;">
                        Get a bird's-eye view of your entire product ecosystem. Monitor live serialization status,
                        track active shipments across the globe, flag suspicious scan activity and view consumer
                        engagement data — all from one unified dashboard.
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
                    <h3>Everything You Need to Secure Your Products</h3>
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
                        <p>Every product unit receives a cryptographically unique QR code at the point of manufacture — impossible to duplicate without detection...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Antenna2"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>Brand & Product Protection</h2>
                        <p>Non-additive digital authentication secures your packaging without changing your existing production line. Build consumer trust and eliminate revenue loss from fakes...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Shield"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>End-Consumer Engagement</h2>
                        <p>When a consumer scans your QR code to verify a product, you capture real-time data on location, profile and behaviour — connect them to loyalty programs instantly...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-MessageLeft"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
                        <h2>Supply Chain Traceability</h2>
                        <p>Track every product from raw material intake through manufacturing, packaging, distribution and delivery. Each step is immutably recorded on the blockchain...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Chart"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>Regulatory Compliance</h2>
                        <p>Stay ahead of government traceability mandates. Our GS1-compliant platform supports compliance requirements across pharma, food, tobacco and more — in multiple countries...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Tools"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>Seamless Hardware Integration</h2>
                        <p>Plug directly into your existing printing, labelling and conveyor systems. Compatible with vision inspection cameras, high-speed lines and all major label formats...</p>
                        <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
                        <span><i class="icon icon-Puzzle"></i></span>
                    </div>
                </div>
            </div>


            <div class="software-screen-section" style="padding: 60px 0; background: #fff;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 wow fadeInRight">
                            <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Tracesci Dashboard Screenshot" style="width:100%; height:80%; border-radius:8px; box-shadow: 0 10px 40px rgba(122,13,125,0.15);">
                        </div>
                        <div class="col-md-6">
                            <div class="main-title wow fadeInLeft">
                                <h2>
                                    Product <span style="color:#7a0d7d;">Serialization</span> at Scale
                                </h2>
                                <p style="color:#555; font-size:16px;">
                                    Assign a unique, tamper-evident digital identity to every single unit you produce —
                                    from a single carton to millions of SKUs. Our serialization engine supports all major
                                    barcode and QR formats, integrates directly with your production line hardware, and
                                    activates codes in real time as products roll off the line.
                                </p>

                            </div>
                        </div>

                    </div>
                </div>
            </div>



            
            

            <div class="row">
                <div class="col-md-12">
                    <div class="all-link solution-btn text-center">
                        <a href="#">More Features</a>
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
                        <h3>From Onboarding to Full Supply Chain Control in 4 Steps</h3>
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
                                                Step 1 — Brand Onboarding
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            Complete paperless onboarding for brand owners, manufacturers and supply chain partners.
                                            Submit your company details and product information, upload required documents, and once approved
                                            you gain full access to the Tracesci platform — ready to start serializing and tracking your products.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Step 2 — Set Up Products & Batches
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            Configure your product catalogue, define SKUs, packaging levels and batch parameters.
                                            Our FREE plan gives you all the tools to set up your solution and run a pilot.
                                            Scale to a paid plan when you're ready to go live across your full production volume — no lock-ins.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Step 3 — Serialize & Activate on the Line
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            Generate and print unique QR / barcode labels for every product unit directly from the Tracesci platform.
                                            Codes are activated the moment they're applied — creating an immutable blockchain record tied to that specific product,
                                            batch, manufacturing location, and timestamp.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                Step 4 — Track, Verify & Analyse
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                        <div class="panel-body">
                                            As products move through the supply chain — from warehouse to distributor to retailer to consumer —
                                            every scan is logged in real time. Receive instant alerts for suspicious activity, track GPS location,
                                            verify authenticity at any checkpoint, and analyse consumer scan data for strategic insights.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="help-question" style="margin-bottom: 50px;">
                            <p>Have questions about implementing Tracesci in your production environment? Our team will walk you through it.</p>
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
                                        <span style="font-weight: 800 !important;">Every Product</span> Deserves a Unique Identity
                                    </h2>
                                </div>
                            </div>
                            <div class="wpb_text_column wpb_content_element">
                                <div class="wpb_wrapper">
                                    <p style="color: #000 !important; font-weight: 300 !important;">
                                        Counterfeiting costs global businesses over $4 trillion a year. Tracesci makes serialization and
                                        supply chain traceability affordable for manufacturers of every size — so your customers always
                                        know they have the real thing.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Real-Time Tracking Screenshots -->
        <div class="software-screen-section" style="padding: 60px 0; background: #fff;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center wow zoomIn" style="margin-bottom:40px;">
                        <h2>Real-Time <span style="color:#7a0d7d;">Supply Chain Visibility</span></h2>
                        <p style="color:#555; font-size:16px; max-width:650px; margin:15px auto 0;">
                            Know exactly where every product is at any moment. From the moment a QR code is printed
                            and activated on your line to the instant a consumer scans it for authenticity verification —
                            every event is recorded, timestamped and tamper-proof.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 wow fadeInLeft" style="margin-bottom:20px;">
                        <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Live GPS Tracking" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                        <p style="text-align:center; margin-top:12px; color:#7a0d7d; font-weight:600;">Live GPS Location Tracking</p>
                    </div>
                    <div class="col-md-4 wow fadeInUp" style="margin-bottom:20px;">
                        <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Scan History Timeline" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                        <p style="text-align:center; margin-top:12px; color:#7a0d7d; font-weight:600;">Full Scan History Timeline</p>
                    </div>
                    <div class="col-md-4 wow fadeInRight" style="margin-bottom:20px;">
                        <img src="{{ asset('web/images/04/img-slider.png') }}" alt="Blockchain Verification Ledger" style="width:100%; height:auto; border-radius:8px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                        <p style="text-align:center; margin-top:12px; color:#7a0d7d; font-weight:600;">Immutable Blockchain Ledger</p>
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
                            <h3>Start Free — Scale as You Grow</h3>
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
                                    <p>Ideal for small manufacturers taking their first steps toward product authentication.</p>
                                </div>
                                <div class="pricing-table-list">
                                    <ul>
                                        <li><span>1</span> Brand</li>
                                        <li><span>Up to 5</span> Product SKUs</li>
                                        <li>QR Code Serialization</li>
                                        <li>Basic Scan Analytics</li>
                                        <li>Consumer Verification Portal</li>
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
                                    <p>For growing businesses needing deeper traceability and supply chain controls.</p>
                                </div>
                                <div class="pricing-table-list">
                                    <ul>
                                        <li><span>3</span> Brands</li>
                                        <li><span>Up to 25</span> Product SKUs</li>
                                        <li>QR + GS1 Barcode Serialization</li>
                                        <li>Supply Chain Tracking</li>
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
                                    <p>Full-scale traceability for large manufacturers with complex, multi-market supply chains.</p>
                                </div>
                                <div class="pricing-table-list">
                                    <ul>
                                        <li><span>Unlimited</span> Brands</li>
                                        <li><span>Unlimited</span> Product SKUs</li>
                                        <li>Full Serialization Suite</li>
                                        <li>Blockchain Ledger + GPS Tracking</li>
                                        <li>Regulatory Compliance Reports</li>
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
        <div class="software-screen-section" style="padding: 60px 0; ">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 wow fadeInLeft" style="padding-right:40px;">
                        <div class="main-title text-left">
                            <h2>Analytics & <span style="color:#7a0d7d;">Anti-Counterfeit Intelligence</span></h2>
                            <p style="color:#555; font-size:16px; margin-top:15px;">
                                Data is your best weapon against counterfeiting. Tracesci's analytics engine surfaces
                                patterns that reveal where fakes are entering your supply chain, which markets are
                                most at risk and how consumers are interacting with your products — so you can act fast.
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