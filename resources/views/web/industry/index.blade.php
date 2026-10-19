@extends('web.layouts.app')
@section('content')
<style>
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

    .product_demo .container {
        position: relative;
        z-index: 2;
    }

    .product_demo h2 {
        color: #000000;
        font-weight: 800;
        font-size: 28px;
        line-height: 1.15;
        margin-bottom: 24px;
        position: relative;
        letter-spacing: -1px;
    }

    .product_demo p {
        color: #000000;
        font-size: 15px;
        line-height: 1.9;
        max-width: 760px;
        margin: 0 auto 45px;
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
        margin: 6px 8px;
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

    .industries-text {
        display: inline-block;
        padding: 10px 30px;
        font-size: 14px;
        line-height: 1.4em;
        text-transform: capitalize;
        color: #fff !important;
        background-color: #343434;
        border: 1px solid #343434;
        border-radius: 0.375rem;
        margin: 0;
        position: relative;
        z-index: 15;
        font-weight: 500;
    }

    /* Industry cards (overview) */
    .industry-link {
        display: block;
        color: inherit;
        text-decoration: none;
    }

    .industry-link:hover {
        color: inherit;
        text-decoration: none;
    }

    .industry-link .welcome-single-content {
        transition: transform .3s ease, box-shadow .3s ease;
    }

    .industry-link:hover .welcome-single-content {
        transform: translateY(-6px);
        box-shadow: 0 14px 34px rgba(122, 13, 125, 0.15);
    }

    .industry-more {
        display: inline-block;
        margin-top: 12px;
        color: #7a0d7d;
        font-weight: 700;
        font-size: 14px;
    }

    /* Key application chips */
    .app-chips {
        margin: 18px 0 22px;
    }

    .app-chips span {
        display: inline-block;
        border: 1px solid #7a0d7d;
        color: #7a0d7d;
        background: #fff;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 600;
        margin: 0 8px 8px 0;
        border-radius: 2px;
    }

    .app-label {
        font-size: 12px;
        letter-spacing: .14em;
        text-transform: uppercase;
        font-weight: 700;
        color: #777;
        margin-top: 20px;
    }

    .industry-cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #7a0d7d;
        color: #fff !important;
        font-size: 14px;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 4px;
        text-decoration: none;
        transition: background .3s ease;
    }

    .industry-cta:hover {
        background: #5a0a5c;
    }

    .industry-img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 10px 40px rgba(122, 13, 125, 0.15);
    }

    .industry-section {
        padding: 70px 0;
        scroll-margin-top: 90px;
    }

    .sub-list {
        color: #000;
        font-size: 15px;
        padding-left: 25px;
        line-height: 2;
        font-family: 'Raleway', sans-serif;
    }

    .sub-list li {
        list-style: disc;
    }

    .vdp-box {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        padding: 34px;
        box-shadow: 0 10px 40px rgba(122, 13, 125, 0.08);
    }

    .vdp-box h3 {
        font-size: 20px;
        font-weight: 800;
        margin: 0 0 18px;
    }

    /* Solutions dropdown (Explore Our Solutions) */
    .sol-dd {
        position: relative;
        display: inline-block;
        margin-right: 12px;
        vertical-align: top;
    }

    .sol-dd>button.industry-cta {
        border: 0;
        cursor: pointer;
    }

    .sol-dd>button i {
        transition: transform .3s ease;
    }

    .sol-dd:hover>button i,
    .sol-dd.open>button i {
        transform: rotate(180deg);
    }

    .sol-dd-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 240px;
        padding-top: 8px;
        z-index: 60;
        text-align: left;
    }

    .sol-dd:hover .sol-dd-menu,
    .sol-dd:focus-within .sol-dd-menu,
    .sol-dd.open .sol-dd-menu {
        display: block;
    }

    .sol-dd-panel {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 6px;
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.18);
        padding: 8px 0;
    }

    .sol-dd-group {
        display: block;
        padding: 10px 20px 4px;
        font-size: 12px;
        letter-spacing: .12em;
        text-transform: uppercase;
        font-weight: 800;
        color: #111;
        text-decoration: none;
    }

    .sol-dd-group:hover {
        color: #7a0d7d;
        text-decoration: none;
    }

    .sol-dd-link {
        display: block;
        padding: 7px 20px 7px 34px;
        font-size: 14px;
        font-weight: 500;
        color: #444;
        text-decoration: none;
        transition: background .2s ease, color .2s ease;
    }

    .sol-dd-link:hover {
        background: #f5f5f5;
        color: #7a0d7d;
        text-decoration: none;
    }

    .sol-dd-divider {
        height: 1px;
        background: #eee;
        margin: 6px 0;
    }

    /* Product identity band */
    .id-section {
        background: #111;
        color: #fff;
        padding: 90px 0;
        position: relative;
    }

    .id-eyebrow {
        font-size: 12px;
        letter-spacing: .22em;
        text-transform: uppercase;
        font-weight: 700;
        color: #bdbdbd;
        margin-bottom: 18px;
    }

    .id-section h2 {
        color: #fff;
        font-size: 38px;
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -.5px;
        margin: 0 0 22px;
    }

    .id-section h2 span {
        color: #d98ae0;
    }

    .id-section p.id-text {
        color: #cfcfcf;
        font-size: 16px;
        line-height: 1.8;
        margin: 0 0 32px;
        max-width: 480px;
    }

    .id-actions .industry-cta.outline {
        background: transparent;
        color: #fff !important;
        border: 1px solid #fff;
        padding: 11px 24px;
    }

    .id-actions .industry-cta.outline:hover {
        background: #fff;
        color: #000 !important;
    }

    .id-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-top: 1px solid rgba(255, 255, 255, .18);
        border-left: 1px solid rgba(255, 255, 255, .18);
    }

    .id-tile {
        padding: 28px 24px 30px;
        border-right: 1px solid rgba(255, 255, 255, .18);
        border-bottom: 1px solid rgba(255, 255, 255, .18);
        transition: background .3s ease;
        min-height: 190px;
    }

    .id-tile:hover {
        background: #7a0d7d;
    }

    .id-tile .num {
        display: block;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .12em;
        color: #d98ae0;
        margin-bottom: 26px;
        transition: color .3s ease;
    }

    .id-tile:hover .num {
        color: #fff;
    }

    .id-tile h3 {
        color: #fff;
        font-size: 18px;
        font-weight: 800;
        line-height: 1.25;
        margin: 0 0 8px;
    }

    .id-tile p {
        color: #b5b5b5;
        font-size: 13px;
        line-height: 1.6;
        margin: 0;
        transition: color .3s ease;
    }

    .id-tile:hover p {
        color: #f0e0f1;
    }

    @media (max-width: 991px) {
        .id-section {
            padding: 60px 0;
        }

        .id-section h2 {
            font-size: 30px;
        }

        .id-grid {
            grid-template-columns: repeat(2, 1fr);
            margin-top: 40px;
        }
    }

    @media (max-width: 480px) {
        .id-grid {
            grid-template-columns: 1fr;
        }

        .id-tile {
            min-height: 0;
        }
    }

    /* Moving industries bar */
    .marquee {
        overflow: hidden;
        width: 100%;
        -webkit-mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent);
        mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent);
    }

    .marquee-track {
        display: flex;
        width: max-content;
        animation: marqueeMove 30s linear infinite;
    }

    .marquee:hover .marquee-track {
        animation-play-state: paused;
    }

    .marquee-item {
        flex: 0 0 auto;
        width: 220px;
        margin: 0 14px;
        text-align: center;
    }

    .marquee-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(122, 13, 125, 0.12);
    }

    .marquee-item h3 {
        margin: 14px 0 0;
        font-size: 18px;
        font-weight: 700;
    }

    @keyframes marqueeMove {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .marquee-track {
            animation: none;
        }
    }

    .industry-cta.outline {
        background: #fff;
        color: #7a0d7d !important;
        border: 1px solid #7a0d7d;
    }

    .industry-cta.outline:hover {
        background: #7a0d7d;
        color: #fff !important;
    }
</style>

{{-- HERO --}}
<div class="rev_slider_wrapper">
    <div id="slider1" class="rev_slider" data-version="5.0">
        <ul>
            <li data-index="rs-3" data-transition="parallaxtoright" data-delay="6500">

                <img src="{{asset('dist/images/industry_cover.jpg')}}"
                    class="rev-slidebg"
                    data-bgposition="center center"
                    data-bgfit="cover"
                    data-bgrepeat="no-repeat">

                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="120"
                    data-start="1200" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <span style='transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 200; font-size: 17px; font-family: "Lora", serif;'>
                        Print. Identify. Authenticate. Track. Trace.
                    </span>
                </div>

                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="190"
                    data-start="1800" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
                        Industry-Specific Traceability Solutions
                    </div>
                </div>

                <div class="tp-caption tp-resizeme"
                    data-x="center" data-y="top" data-voffset="300"
                    data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
                    data-transform_out="opacity:0;s:300">
                    <div class="text-center" style='transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 200; font-size: 17px; font-family: "Lora", serif;'>
                        From Variable Data Printing to Product Authentication and Track &amp; Trace —<br>
                        applications built around the way your industry makes and ships products.
                    </div>
                </div>

            </li>
        </ul>
    </div>
</div>


{{-- INDUSTRIES OVERVIEW (clickable cards) --}}
<div id="overview" class="welcome-area" style="background-color:#fff">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="main-title wow zoomIn">
                    <div class="main-shadow-heading">
                        <h2>Industries</h2>
                    </div>
                    <h2><span style="color:#7a0d7d">Solutions</span> Designed for Your Industry</h2>
                    <h3>Choose your industry to see how Tracesci applies</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="welcome-content">
        <div class="container">
            <div class="row">

                <div class="col-sm-3 col-md-3">
                    <a href="#wood" class="industry-link">
                        <div class="welcome-single-content wow fadeInLeft text-center">
                            <h3>Wood &amp; Interior</h3>
                            <h2><span>01.</span> Wood</h2>
                            <p>MDF | Plywood | Laminates | Formwork Shuttering</p>
                            <span class="industry-more">View applications &rarr;</span>
                        </div>
                    </a>
                </div>

                <div class="col-sm-3 col-md-3">
                    <a href="#pharmaceutical" class="industry-link">
                        <div class="welcome-single-content wow fadeInDown text-center">
                            <h3>Pharmaceutical</h3>
                            <h2><span>02.</span> Pharma</h2>
                            <p>Serialization | Authentication | Track &amp; Trace</p>
                            <span class="industry-more">View applications &rarr;</span>
                        </div>
                    </a>
                </div>

                <div class="col-sm-3 col-md-3">
                    <a href="#foam" class="industry-link">
                        <div class="welcome-single-content wow fadeInUp text-center">
                            <h3>Foam &amp; Industrial</h3>
                            <h2><span>03.</span> Foam</h2>
                            <p>Variable Data | Identification | Traceability</p>
                            <span class="industry-more">View applications &rarr;</span>
                        </div>
                    </a>
                </div>

                <div class="col-sm-3 col-md-3">
                    <a href="#other-industries" class="industry-link">
                        <div class="welcome-single-content wow fadeInRight text-center">
                            <h3>Other Industries</h3>
                            <h2><span>04.</span> Custom</h2>
                            <p>Customized traceability solutions for your product and process.</p>
                            <span class="industry-more">Learn more &rarr;</span>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- More than Track & Trace --}}
    <div id="application" class="id-section">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-md-5 wow fadeInLeft">
                    <div class="id-eyebrow">Print · Identify · Authenticate · Track · Trace</div>
                    <h2>
                        More Than Track &amp; Trace. <span>A Complete Product Identity Solution.</span>
                    </h2>
                    <p class="id-text">
                        From Variable Data Printing to Product Authentication and Track &amp; Trace, Tracesci helps businesses create a unique digital identity for every product.
                    </p>

                    <div class="id-actions">
                        <div class="sol-dd">
                            <button type="button" class="industry-cta" aria-haspopup="true">
                                Explore Our Solutions <i class="fa fa-angle-down"></i>
                            </button>
                            <div class="sol-dd-menu">
                                <div class="sol-dd-panel">
                                    <!-- 1) SOFTWARE -->
                                    <a href="{{ route('cloud-solution') }}" class="sol-dd-group">Software</a>
                                    <a href="{{ route('cloud-solution') }}" class="sol-dd-link">Cloud</a>
                                    <a href="{{ route('enterprise-solution') }}" class="sol-dd-link">Enterprise</a>

                                    <div class="sol-dd-divider"></div>

                                    <!-- 2) EQUIPMENTS -->
                                    <a href="{{ route('product-hyperloop') }}" class="sol-dd-group">Equipments</a>
                                    <a href="{{ route('product-hyperloop') }}" class="sol-dd-link">Hyperloop</a>
                                    <a href="{{ route('product-razor6') }}" class="sol-dd-link">Razor 6</a>
                                    <a href="{{ route('product-elite4') }}" class="sol-dd-link">Elite 4</a>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('demo-schedule-create')}}" class="industry-cta outline">Schedule a Demo</a>
                    </div>
                </div>

                <div class="col-md-7 wow fadeInRight">
                    <div class="id-grid">
                        <div class="id-tile">
                            <span class="num">01</span>
                            <h3>Variable Data Printing</h3>
                            <p>Unique data printed on every item.</p>
                        </div>
                        <div class="id-tile">
                            <span class="num">02</span>
                            <h3>Product Identification</h3>
                            <p>A distinct ID for every product.</p>
                        </div>
                        <div class="id-tile">
                            <span class="num">03</span>
                            <h3>Product Authentication</h3>
                            <p>Verify genuine products with a scan.</p>
                        </div>
                        <div class="id-tile">
                            <span class="num">04</span>
                            <h3>Serialization</h3>
                            <p>Codes managed by item, batch and lot.</p>
                        </div>
                        <div class="id-tile">
                            <span class="num">05</span>
                            <h3>Track &amp; Trace</h3>
                            <p>Follow products through the supply chain.</p>
                        </div>
                        <div class="id-tile">
                            <span class="num">06</span>
                            <h3>Anti-Counterfeit</h3>
                            <p>Spot fakes and misuse early.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


{{-- WOOD --}}
<div id="wood" class="software-screen-section industry-section" style="background:#fff;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 wow fadeInLeft" style="padding-right:40px;">
                <div class="main-title text-left">
                    <h2>Wood <span style="color:#7a0d7d;">&amp; Interior</span></h2>
                    <p style="color:#555; font-size:16px; margin-top:15px;">
                        Mark every board with its own identity. Tracesci brings variable data printing and traceability to wood-based panels, so each one can be identified, authenticated and tracked from the factory to the site.
                    </p>
                    <ul class="sub-list">
                        <li>MDF</li>
                        <li>Shuttering / Plywood</li>
                        <li>Mica / Ply</li>
                    </ul>
                    <div class="app-label">Key applications</div>
                    <div class="app-chips">
                        <span>Variable Data</span><span>Product Identification</span><span>QR / Barcode</span><span>Authentication</span><span>Traceability</span>
                    </div>
                    <a href="mailto:wecare@tracesci.in?subject=Wood%20Industry%20Enquiry" class="industry-cta">
                        <i class="fa fa-envelope"></i> Discuss Your Application
                    </a>
                </div>
            </div>
            <div class="col-md-6 wow fadeInRight">
                <img src="{{ asset('dist/images/Wood_Interior.jpg') }}" alt="Wood and interior panels with variable data marking" class="industry-img" style="margin-top:70px;">
            </div>
        </div>
    </div>
</div>


{{-- PHARMACEUTICAL --}}
<div id="pharmaceutical" class="software-screen-section industry-section" style="background:#f5f5f5;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 wow fadeInLeft" style="padding-right:40px;">
                <div class="main-title text-left">
                    <h2>Pharmaceutical <span style="color:#7a0d7d;">Serialization &amp; Authentication</span></h2>
                    <p style="color:#555; font-size:16px; margin-top:15px;">
                        Give every pack a unique code that can be verified and traced. Tracesci supports serialization, batch and lot identification, and authentication to help keep counterfeits out of the pharmaceutical supply chain.
                    </p>
                    <div class="app-label">Key applications</div>
                    <div class="app-chips">
                        <span>Serialization</span><span>QR / 2D Codes</span><span>Product Authentication</span><span>Batch / Lot Identification</span><span>Track &amp; Trace</span><span>Anti-Counterfeit</span>
                    </div>
                    <a href="mailto:wecare@tracesci.in?subject=Pharmaceutical%20Enquiry" class="industry-cta">
                        <i class="fa fa-envelope"></i> Discuss Your Application
                    </a>
                </div>
            </div>
            <div class="col-md-6 wow fadeInRight">
                {{-- Replace with a dedicated pharma image if you have one --}}
                <img src="{{ asset('web/images/pharma_image.jpg') }}" alt="Pharmaceutical serialization and authentication" class="industry-img" style="margin-top:70px;">
            </div>
        </div>
    </div>
</div>


{{-- FOAM & INDUSTRIAL --}}
<div id="foam" class="software-screen-section industry-section" style="background:#fff;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 wow fadeInLeft">
                {{-- Add this image to public/dist/images/ --}}
                <img src="{{ asset('dist/images/industry-foam.jpg') }}" alt="Variable data marking on foam and industrial products" class="industry-img" style="margin-top:70px;">
            </div>
            <div class="col-md-6 wow fadeInRight" style="padding-left:40px;">
                <div class="main-title text-left">
                    <h2>Foam <span style="color:#7a0d7d;">&amp; Industrial Products</span></h2>
                    <p style="color:#555; font-size:16px; margin-top:15px;">
                        Identify each unit as it leaves the line. Tracesci adds variable data, serial numbers and batch information to foam and industrial products, creating a traceable record for every item.
                    </p>
                    <div class="app-label">Key applications</div>
                    <div class="app-chips">
                        <span>Variable Data</span><span>Product Identification</span><span>QR / Barcode</span><span>Serial Numbers</span><span>Batch Information</span><span>Traceability</span>
                    </div>
                    <a href="mailto:wecare@tracesci.in?subject=Foam%20%26%20Industrial%20Enquiry" class="industry-cta">
                        <i class="fa fa-envelope"></i> Discuss Your Application
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- VARIABLE DATA PRINTING --}}
<div id="vdp" class="software-screen-section" style="padding: 70px 0; background:#f5f5f5; scroll-margin-top:90px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 wow fadeInLeft">
                <div class="main-title text-left">
                    <h2>Variable Data Printing <span style="color:#7a0d7d;">at the Core</span></h2>
                    <p style="color:#555; font-size:16px; margin-top:15px;">
                        Every Tracesci application starts with printing the right data on the right product. Whatever your industry, we can print the information that makes each item unique.
                    </p>
                    <a href="mailto:wecare@tracesci.in?subject=Talk%20to%20an%20Expert" class="industry-cta">
                        <i class="fa fa-comments"></i> Talk to Our Experts
                    </a>
                </div>
            </div>
            <div class="col-md-6 wow fadeInRight">
                <div class="vdp-box" style="margin-top:50px;">
                    <h3>What we can print</h3>
                    <div class="app-chips" style="margin:0;">
                        <span>QR Codes</span><span>1D / 2D Barcodes</span><span>Serial Numbers</span><span>Unique Product IDs</span><span>Batch Numbers</span><span>Lot Numbers</span><span>Product-Specific Data</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- OTHER INDUSTRIES --}}
<div id="other-industries" class="refresh-phone padding-content" style="background:#fff; padding-top:70px; scroll-margin-top:90px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="title-block">
                    <div class="riven-heading text-center" data-sr="enter top wait 0.3s">
                        <h2>Other Industries — <span style="color:#7a0d7d">Customized Traceability Solutions</span></h2>
                    </div>
                </div>
                <div class="refresh-phone-content">
                    <div class="text-desc">
                        <p class="text-center">
                            Don't see your industry? Tracesci tailors its printing, identification and traceability solutions to your product, process and goals.
                        </p>
                    </div>
                    <p class="industries-text">Industries We Also Serve</p>
                </div>
                <div class="spacer-100"></div>
            </div>
        </div>
    </div>
    <div class="marquee">
        <div class="marquee-track">
            <div class="marquee-item">
                <img src="{{asset('web/images/industry-apparel.jpg')}}" alt="Apparel">
                <h3>Apparel</h3>
            </div>
            <div class="marquee-item">
                <img src="{{asset('web/images/Picture2.jpg')}}" alt="Food">
                <h3>Food</h3>
            </div>
            <div class="marquee-item">
                <img src="{{asset('web/images/Picture3.jpg')}}" alt="Automobile">
                <h3>Automobile</h3>
            </div>
            <div class="marquee-item">
                <img src="{{asset('web/images/Picture4.jpg')}}" alt="Tobacco">
                <h3>Tobacco</h3>
            </div>
            <div class="marquee-item">
                <img src="{{asset('web/images/industry-pharma.jpg')}}" alt="Pharma">
                <h3>Pharma</h3>
            </div>
            <div class="marquee-item">
                <img src="{{asset('web/images/Picture6.jpg')}}" alt="Beverages">
                <h3>Beverages</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture1.jpg')}}" alt="Apparel">
                <h3>Apparel</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture2.jpg')}}" alt="Food">
                <h3>Food</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture3.jpg')}}" alt="Automobile">
                <h3>Automobile</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture4.jpg')}}" alt="Tobacco">
                <h3>Tobacco</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture5.jpg')}}" alt="Pharma">
                <h3>Pharma</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture6.jpg')}}" alt="Beverages">
                <h3>Beverages</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture1.jpg')}}" alt="Apparel">
                <h3>Apparel</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture2.jpg')}}" alt="Food">
                <h3>Food</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture3.jpg')}}" alt="Automobile">
                <h3>Automobile</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture4.jpg')}}" alt="Tobacco">
                <h3>Tobacco</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture5.jpg')}}" alt="Pharma">
                <h3>Pharma</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture6.jpg')}}" alt="Beverages">
                <h3>Beverages</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture1.jpg')}}" alt="Apparel">
                <h3>Apparel</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture2.jpg')}}" alt="Food">
                <h3>Food</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture3.jpg')}}" alt="Automobile">
                <h3>Automobile</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture4.jpg')}}" alt="Tobacco">
                <h3>Tobacco</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture5.jpg')}}" alt="Pharma">
                <h3>Pharma</h3>
            </div>
            <div class="marquee-item" aria-hidden="true">
                <img src="{{asset('web/images/Picture6.jpg')}}" alt="Beverages">
                <h3>Beverages</h3>
            </div>
        </div>
    </div>
</div>


{{-- CTA --}}
<div class="product_demo">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>
                    Print. Identify. <span style="color: #7a0d7d;">Authenticate. Track. Trace.</span>
                </h2>
                <p>
                    Whether you make MDF and plywood, pharmaceutical packs, foam products or something entirely different,
                    Tracesci can print unique data on every item and link it to a digital identity you can verify and track.
                    Tell us about your product and your industry, and our team will walk you through a solution that fits
                    your line — from variable data printing and serialization to authentication and track &amp; trace.
                </p>
                <div class="demo-actions">
                    <a href="{{route('demo-schedule-create')}}" class="enterprise-btn">
                        Schedule a Demo
                        <i class="fa fa-long-arrow-right"></i>
                    </a>
                    <!-- <a href="mailto:wecare@tracesci.in" class="enterprise-btn">
                        Get in Touch
                        <i class="fa fa-long-arrow-right"></i>
                    </a> -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')
<script>
    // Solutions dropdown: tap to open on touch devices, tap outside to close
    document.addEventListener('click', function(e) {
        var dd = document.querySelector('.sol-dd');
        if (!dd) return;
        if (e.target.closest('.sol-dd > button')) {
            dd.classList.toggle('open');
        } else if (!e.target.closest('.sol-dd')) {
            dd.classList.remove('open');
        }
    });
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