@extends('web.layouts.app')
@section('content')
<style>
    .product_demo {
        background: #f5f5f5;
        padding: 10px 0px 20px 0;
        /* reduced top padding from 30px to 10px */
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
                            Every deployment is tailored to your business needs with flexible workflows and customized solutions.

                        </p>
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInDown text-center">
                        <h3>Multi-Stakeholder</h3>
                        <h2><span>02.</span> Integrated</h2>
                        <p>
                            Integrated enterprise modules with centralized monitoring and secure role-based access.

                        </p>
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInUp text-center">
                        <h3>Deployment Flexibility</h3>
                        <h2><span>03.</span> On Your Terms</h2>
                        <p>
                            Flexible deployment options with complete control over your data, infrastructure, and operations.

                        </p>
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="col-sm-3 col-md-3">
                    <div class="welcome-single-content wow fadeInRight text-center">
                        <h3>Scalable at Volume</h3>
                        <h2><span>04.</span> Adaptive</h2>
                        <p>
                            Built for large-scale traceability with support for unlimited brands, SKUs, and product volumes.
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
                <img src="{{ asset('dist/images/analytics2.png')}}" alt="Tracesci Enterprise Dashboard" style="width:100%; height:80%; border-radius:8px; box-shadow: 0 10px 40px rgba(122,13,125,0.15);">
            </div>
        </div>
    </div>
</div>


<!-- Core Capabilities & Features Section -->
<div class="solution-area" style="background: #f5f5f5;">
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
                        <a href="#"></a>
                        <span><i class="icon icon-Chart"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>Product Authentication at All Levels</h2>
                        <p>Every product unit is assigned a cryptographically unique QR or barcode label. Authentication is available to consumers, inspectors, government authorities and brand teams — across the entire supply chain hierarchy.</p>
                        <a href="#"></a>
                        <span><i class="icon icon-Shield"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>Multi-Stakeholder Integration</h2>
                        <p>Dedicated modules for manufacturers, brand owners, government authorities and printers — each with role-based access, custom workflows and a unified view of the entire product ecosystem.</p>
                        <a href="#"></a>
                        <span><i class="icon icon-Puzzle"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
                        <h2>Custom Mobile Applications</h2>
                        <p>Bespoke Android and iOS apps built specifically for your enterprise workflows — supporting inspectors, auditors and consumers. Works online and offline. Consumers can report counterfeit products directly through the app.</p>
                        <a href="#"></a>
                        <span><i class="icon icon-MessageLeft"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInUp">
                        <h2>Real-Time Alerts &amp; Fraud Detection</h2>
                        <p>Behavior-based alert engine flags abnormal scan patterns, geo-location anomalies and suspected diversion the moment they occur — enabling instant enforcement action by inspectors and brand teams.</p>
                        <a href="#"></a>
                        <span><i class="icon icon-Antenna2"></i></span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="solution-single-content wow fadeInRight">
                        <h2>High-Level Security &amp; Data Control</h2>
                        <p>Secure, role-based access for every stakeholder. Hosted, on-premise or dedicated portal deployment options. Scalable for large product volumes — with full data sovereignty and compliance-ready audit trails.</p>
                        <a href="#"></a>
                        <span><i class="icon icon-Tools"></i></span>
                    </div>
                </div>
            </div>

            <!-- Serialization Feature Highlight -->
            
        </div>
    </div>
    <div class="solution-area" style="background:#fff;">
    <div class="software-screen-section" style="padding: 150px 0 0 0;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 wow fadeInLeft">
                            <img src="{{ asset('dist/images/enterprise.png') }}" alt="Enterprise Serialization"
                                style="width:100%; height:auto; border-radius:8px; box-shadow: 0 10px 40px rgba(122,13,125,0.15);">
                        </div>
                        <div class="col-md-6 wow fadeInRight" style="padding-left:40px; display:flex; align-items:center;">
                            <div class="main-title text-left">
                                <h2>Serialization <span style="color:#7a0d7d;">at Enterprise Scale</span></h2>
                                <p style="color:#555; font-size:16px; margin-top: 5px">
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
    </div>


    <!-- How It Works Section -->
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
                    Tracesci Enterprise Solution enables secure product serialization, anti-counterfeit
                    verification, mobile authentication, and end-to-end supply chain traceability
                    through a scalable blockchain-powered platform built for modern manufacturers,
                    regulators, and global distribution networks.
                </p>

                <div class="demo-actions">
                    <a href="{{route('demo-schedule-create')}}" class="enterprise-btn">
                        Schedule Enterprise Demo
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