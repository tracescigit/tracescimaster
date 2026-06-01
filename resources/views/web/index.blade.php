@extends('web.layouts.app')
@section('content')
<style>
  .uranus.tparrows {
    cursor: pointer;
    background: #fff;
    min-width: 60px !important;
    min-height: 60px !important;
    position: absolute;
    display: block;
    z-index: 100;
    color: #222;
  }

  .uranus.tparrows:before {
    font-family: "revicons";
    font-size: 30px;
    color: #aaa;
    display: block;
    line-height: 70px;
    text-align: center;
    -webkit-transition: color 0.3s;
    -moz-transition: color 0.3s;
    transition: color 0.3s;
    z-index: 2;
    position: relative;
    background: #fff;
    min-width: 70px;
    min-height: 70px;
  }

  .trace-process-section {
    background: #f5f5f5;
    position: relative;
    overflow: hidden;
    padding: 0;
  }

  .section-title {
    margin-bottom: 40px;
  }

  .subtitle {
    display: inline-block;
    background: #7a0d7d;
    color: #fff;
    padding: 8px 20px;
    border-radius: 30px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 20px;
  }

  .section-title h2 {
    font-size: 48px;
    font-weight: 700;
    color: #111;
    margin-bottom: 20px;
  }

  .section-title p {
    max-width: 750px;
    margin: auto;
    color: #666;
    font-size: 18px;
    line-height: 1.8;
  }

  .center-image {
    margin-bottom: 70px;
    text-align: center;
  }

  .center-image img {
    width: 650px;
    max-width: 100%;
    height: auto;
  }

  /* ---- Card grid: flex row so all cards in a row share equal height ---- */
  .process-grid {
    display: flex;
    flex-wrap: wrap;
  }

  .process-grid>[class*="col-"] {
    display: flex;
    flex-direction: column;
    margin-bottom: 30px;
  }

  .process-card {
    background: #fff;
    border-radius: 20px;
    padding: 35px;
    text-align: center;
    flex: 1;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    border-top: 4px solid #7a0d7d;
  }

  .process-card:hover {
    transform: translateY(-8px);
  }

  .step-badge {
    width: 65px;
    height: 65px;
    margin: 0 auto 20px;
    background: #7a0d7d;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 700;
  }

  .process-card h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #111;
  }

  .process-card p {
    color: #666;
    line-height: 1.8;
    font-size: 16px;
    margin: 0;
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

  @media (max-width: 991px) {

    .trace-process-section {
      padding: 0;
    }

    .section-title h2 {
      font-size: 36px;
    }

    .center-image {
      margin-bottom: 50px;
    }

    .center-image img {
      width: 420px;
      max-width: 100%;
    }

    .process-grid>[class*="col-"] {
      margin-bottom: 30px;
    }

    .process-card {
      padding: 30px 25px;
    }

    .process-card h3 {
      font-size: 22px;
    }

    .process-card p {
      font-size: 15px;
      line-height: 1.7;
    }
  }

  @media (max-width: 767px) {

    .trace-process-section {
      padding: 0;
    }

    .section-title h2 {
      font-size: 30px;
    }

    .center-image {
      margin-bottom: 40px;
    }

    .center-image img {
      width: 280px;
      max-width: 100%;
    }

    .process-grid>[class*="col-"] {
      width: 100%;
      flex-direction: column;
      margin-bottom: 20px;
    }

    .process-card {
      padding: 25px 20px;
    }

    .process-card h3 {
      font-size: 20px;
    }

    .process-card p {
      font-size: 14px;
      line-height: 1.6;
    }

    .step-badge {
      width: 55px;
      height: 55px;
      font-size: 18px;
    }
  }

  @media (max-width: 480px) {

    .section-title h2 {
      font-size: 26px;
    }

    .center-image img {
      width: 220px;
    }

    .process-card {
      padding: 20px 15px;
    }

    .process-card h3 {
      font-size: 18px;
    }

    .process-card p {
      font-size: 13px;
    }

    .step-badge {
      width: 50px;
      height: 50px;
      font-size: 16px;
    }
  }
</style>
<!-- slider -->

<div class="rev_slider_wrapper">
  <div id="slider1" class="rev_slider" data-version="5.0">
    <ul>

      <!-- SLIDE 1 -->
      <li data-index="rs-1" data-transition="parallaxtoright" data-delay="6500">

        <!-- MAIN IMAGE -->
        <!-- <img src="{{asset('dist/images/slide1.png')}}" -->
        <img src="{{asset('dist/images/index-wallpaper4.png')}}"
          class="rev-slidebg"
          data-bgposition="center center"
          data-bgfit="cover"
          data-bgrepeat="no-repeat">

        <!-- LAYER 1 -->
        <div class="tp-caption tp-resizeme"
          data-x="center"
          data-y="top"
          data-voffset="120"
          data-start="1200"
          data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300" ;>
          <span class="sl-italic" style='transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px; font-family: "Lora", serif;'>
            Let us help you to authenticate and track your product
          </span>
        </div>

        <!-- LAYER 2 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="190"
          data-start="1800"
          data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300" ;>
          <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
            SUPPLY CHAIN TRACESCI PLATFORM
          </div>
        </div>

        <!-- LAYER 3 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="300"
          data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300" ;>
          <div class="sl-italic sl-italic-2 text-center" style='transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px; font-family: "Lora", serif;'>
            Our strategists will help you set an objective and choose your tools,<br>
            developing a plan that is custom-built for your business.
          </div>
        </div>

        <!-- LAYER 4 (Buttons) -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="430"
          data-start="2800" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300" ;>
          <div class="rev-slider-btn text-center">
            <a href="{{ url(Auth::check()?myDashboard():'/login') }}">Login</a>
            <a href="{{ url(Auth::check()?myDashboard():'/register') }}">Register</a>
          </div>
        </div>

      </li>

      <!-- SLIDE 2 -->

      <li data-index="rs-2" data-transition="parallaxtoright" data-delay="6500">

        <!-- MAIN IMAGE -->
        <!-- <img src="{{asset('dist/images/slide2.png')}}" -->
        <img src="{{asset('dist/images/index_wallpaper7.png')}}"
          class="rev-slidebg"
          data-bgposition="center center"
          data-bgfit="cover"
          data-bgrepeat="no-repeat">

        <!-- LAYER 1 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="120"
          data-start="1200"
          data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300" ;>
          <span class="sl-italic" style='transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;font-family: "Lora", serif;'>
            Informed decisions. Exceptional results
          </span>
        </div>

        <!-- LAYER 2 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="190"
          data-start="1800" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300" ;>
          <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
            Engage, Authenticate, and Protect
          </div>
        </div>

        <!-- LAYER 3 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="300"
          data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300" ;>
          <div class="sl-italic sl-italic-2 text-center" style='transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;font-family: "Lora", serif;'>
            Our strategists will help you set an objective and choose your tools,<br>
            developing a plan that is custom-built for your business.
          </div>
        </div>

        <!-- LAYER 4 (Buttons) -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="430"
          data-start="2800" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300" ;>
          <div class="rev-slider-btn text-center">
            <a href="{{ url(Auth::check()?myDashboard():'/login') }}">Login</a>
            <a href="{{ url(Auth::check()?myDashboard():'/register') }}">Register</a>
          </div>
        </div>

      </li>

      <!-- SLIDE 3 -->
      <li data-index="rs-3" data-transition="parallaxtoright" data-delay="6500">

        <!-- MAIN IMAGE -->
        <img src="{{asset('dist/images/slide3.png')}}"
          class="rev-slidebg"
          data-bgposition="center center"
          data-bgfit="cover"
          data-bgrepeat="no-repeat">

        <!-- LAYER 1 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="120"
          data-start="1200" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300" ;>
          <span class="sl-italic" style='transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;font-family: "Lora", serif;'>
            Informed decisions. Exceptional results
          </span>
        </div>

        <!-- LAYER 2 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="190"
          data-start="1800" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300" ;>
          <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
            Turn Consumers Into Brand Protectors
          </div>
        </div>

        <!-- LAYER 3 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="300"
          data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300" ;>
          <div class="sl-italic sl-italic-2 text-center" style='transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;font-family: "Lora", serif;'>
            Our strategists will help you set an objective and choose your tools,<br>
            developing a plan that is custom-built for your business.
          </div>
        </div>

        <!-- LAYER 4 (Buttons) -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="430"
          data-start="2800" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300" ;>
          <div class="rev-slider-btn text-center">
            <a href="{{ url(Auth::check()?myDashboard():'/login') }}">Login</a>
            <a href="{{ url(Auth::check()?myDashboard():'/register') }}">Register</a>
          </div>
        </div>

      </li>

    </ul>
  </div>
</div>


<!-- the content -->
<div class="welcome-area" style="background-color:#fff">
  <!-- MAIN TITLE AREA -->
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="main-title wow zoomIn">
          <div class="main-shadow-heading">
            <h2>Hello, We Are Tracesci</h2>
          </div>
          <h2>Hello, We Are <span style="color:#7a0d7d" ;>Tracesci</span></h2>
          <h3>Strengthen Your Brand With Smart Traceability</h3>
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



            <h3>Brand Protection</h3>
            <h2><span>01.</span> Secure</h2>

            <p>
              Ensure products are genuine with non-additive digital authentication
            </p>

          </div>
        </div>

        <!-- ITEM 2 -->
        <div class="col-sm-3 col-md-3">
          <div class="welcome-single-content wow fadeInDown text-center">

            <h3>Traceability</h3>
            <h2><span>02.</span> Track</h2>

            <p>
              Blockchain-driven supply chain tracking with real-time insights.

            </p>

          </div>
        </div>

        <!-- ITEM 3 -->
        <div class="col-sm-3 col-md-3">
          <div class="welcome-single-content wow fadeInUp text-center">

            <h3>Real Time Alerts</h3>
            <h2><span>03.</span> Monitor</h2>

            <p>
              Conditions to help prevent product damage, diversion or waste
            </p>

          </div>
        </div>

        <!-- ITEM 4 -->
        <div class="col-sm-3 col-md-3">
          <div class="welcome-single-content wow fadeInRight text-center">

            <h3>GS1 Compliant</h3>
            <h2><span>04.</span> Standardize</h2>

            <p>
              Fully customised solution in compliance with GS1 standards
            </p>

          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- refresh-phone -->
  <div id="application" class="refresh-phone padding-content">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="title-block">
            <div class="riven-heading text-center" data-sr="enter top wait 0.3s">
              <h2>
                Powered by <span style="color:#7a0d7d" ;>Block Chain</span> Authentic, safe and connected
              </h2>
            </div>
          </div>
          <div class="refresh-phone-content">

            <div class="text-desc">
              <p class="text-center">The SaaS platform provides brand owners deep consumer and supply chain insights regarding their products like <br>real-time GPS location, scanning pattern and suspicious activity alerts.<br>It will help to get actionable product data for strategic decision-making and operational excellence.</p>
            </div>
            <p class="industries-text">Industries we cater</p>

          </div>
          <div class="spacer-100"></div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.3s">
          <div class="thumbnail-game text-center">
            <img height="150" src="{{asset('dist/images/apprels.png')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="character-3" />
          </div>
          <div class="desc text-center">
            <h3>Apparel</h3>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.6s">
          <div class="thumbnail-game text-center">
            <img height="150" src="{{asset('dist/images/food.png')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="character-3" />
          </div>
          <div class="desc text-center">
            <h3>Food</h3>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.9s">
          <div class="thumbnail-game text-center">
            <img height="150" src="{{asset('dist/images/automobile.png')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="character-3" />
          </div>
          <div class="desc text-center">
            <h3>Automobile</h3>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 1.2s">
          <div class="thumbnail-game text-center">
            <img height="150" src="{{asset('dist/images/tobacco.png')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="character-3" />
          </div>
          <div class="desc text-center">
            <h3>Tobacco</h3>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.9s">
          <div class="thumbnail-game text-center">
            <img height="150" src="{{asset('dist/images/medicine.png')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="character-3" />
          </div>
          <div class="desc text-center">
            <h3>Pharma</h3>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 1.2s">
          <div class="thumbnail-game text-center">
            <img height="150" src="{{asset('dist/images/drink.png')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="character-3" />
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

<!-- features -->

<div class="solution-area" style="padding: 0px 0;background-color:#fff;">
  <!-- MAIN TITLE AREA -->
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="main-title wow zoomIn">
          <div class="main-shadow-heading">
            <h2>Amazing <span>Features</span></h2>
          </div>
          <h2>Amazing <span style="color:#7a0d7d" ;>Features</span></h2>
          <h3>Satisfy Your Needs</h3>
        </div>
      </div>
    </div>
  </div>


  <!-- END TITLE -->
  <div class="solution-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-md-4">
          <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
            <h2>Easy to use</h2>
            <p>Scalable solution enabling secure traceability, compliance, counterfeit prevention, operational efficiency, and supply chain visibility for Products.

            </p>
            <a href="#"></a>
            <span><i class="icon icon-Chart"></i></span>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="solution-single-content wow fadeInUp">
            <h2>Protect your Product</h2>
            <p>Secure packaging and authentication safeguard brands, protect consumers, prevent counterfeiting, build trust, and ensure product authenticity worldwide.
            </p>
            <a href="#"></a>
            <span><i class="icon icon-Shield"></i></span>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="solution-single-content wow fadeInRight">
            <h2>Engagement</h2>
            <p>Gain valuable consumer insights, understand end-user behavior, and connect customers seamlessly with loyalty and engagement programs.
            </p>
            <a href="#"></a>
            <span><i class="icon icon-MessageLeft"></i></span>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
            <h2>Product serialization</h2>
            <p>Serialization drives digital transformation by enabling secure traceability, operational transparency, smarter supply chains, and connected brand ecosystems.
            </p>
            <a href="#"></a>
            <span><i class="icon icon-Antenna2"></i></span>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="solution-single-content wow fadeInUp">
            <h2>Regulatory compliance</h2>
            <p>Access a unified solution supporting global compliance mandates, enabling secure operations, regulatory adherence, and seamless business integration worldwide.
            </p>
            <a href="#"></a>
            <span><i class="icon icon-Tools"></i></span>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="solution-single-content wow fadeInRight">
            <h2>Hardware integration</h2>
            <p>Built for seamless integration with printers, labeling equipment, conveyor systems, and intelligent vision inspection solutions for fully automated production environments.
            </p>
            <a href="#"></a>
            <span><i class="icon icon-Puzzle"></i></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="howitworks" style="background-color: #f5f5f5; margin-top: 50px; ">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <div class="main-title wow zoomIn">
            <div class="main-shadow-heading">
              <h2>Secure Product Traceability Workflow</h2>
            </div>
            <h2><span>Secure </span>Product <span style="color:#7a0d7d;">Traceability Workflow</span></h2>
            <h3> One connected platform for onboarding, serialization,
              authentication and real-time enforcement.</h3>
          </div>
        </div>
      </div>
    </div>
    <!-- END TITLE -->

    <section class="trace-process-section">
      <div class="container">

        <!-- SECTION TITLE -->

        <!-- CENTER IMAGE -->
        <div class="center-image text-center">
          <img src="{{ asset('dist/images/bbchain.png') }}"
            class="img-responsive center-block"
            alt="Blockchain Traceability">
        </div>

        <!-- PROCESS GRID -->
        <div class="row process-grid">

          <div class="col-md-6 col-sm-6 mb-4">
            <div class="process-card">
              <div class="step-badge">01</div>
              <h3>Enterprise Onboarding</h3>
              <p>
                Register manufacturers, verify compliance documents, and provide secure platform access with role-based controls, enabling seamless onboarding, authenticated operations, centralized management, and real-time visibility across the supply chain ecosystem while ensuring security, transparency, and regulatory compliance.

              </p>
            </div>
          </div>

          <div class="col-md-6 col-sm-6 mb-4">
            <div class="process-card">
              <div class="step-badge">02</div>
              <h3>Product Serialization</h3>
              <p>
                Create SKUs, define packaging hierarchies, and configure serialization workflows with ease, enabling accurate product identification, seamless aggregation, efficient inventory control, real-time traceability, and secure supply chain operations across manufacturing, distribution, and retail environments.

              </p>
            </div>
          </div>

          <div class="col-md-6 col-sm-6 mb-4">
            <div class="process-card">
              <div class="step-badge">03</div>
              <h3>Cryptographic Code Generation</h3>
              <p>
                Print and activate unique QR codes or barcode identities on every product, enabling secure authentication, real-time traceability, anti-counterfeiting protection, streamlined inventory management, seamless aggregation, and complete visibility across manufacturing, distribution, retail, and consumer verification processes.

              </p>
            </div>
          </div>

          <div class="col-md-6 col-sm-6 mb-4">
            <div class="process-card">
              <div class="step-badge">04</div>
              <h3>Supply Chain Surveillance & Enforcement</h3>
              <p>
                Monitor product movement, detect suspicious activity, and verify authenticity in real time, enabling faster fraud prevention, supply chain transparency, secure product tracking, intelligent risk detection, enforcement response, and trusted consumer engagement across manufacturing, distribution, and retail networks.

              </p>
            </div>
          </div>

        </div>

      </div>
    </section>
  </div>
</div>




<!-- Pricing Table -->




<!-- Event Calendar -->
<div id="event_calendar" class="padding-content content-section" style="background-color:#fff">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="riven-heading text-center" data-sr="enter bottom wait 0.3s">
          <h2>Events<span style="color:#7a0d7d" ;> Calendar</span></h2>
          <p class="text">Save the dates. We would love to see you..</p>
        </div>
      </div>
    </div>
    <div class="spacer-35"></div>
    <div class="event-container">
      <div class="event-contents row">

        <!-- 1st EVENT (LEFT) -->
        <div class="event-content col-md-6 col-sm-12 col-xs-12">
          <div class="row row-event">

            <div class="event-box-conner col-md-10 col-sm-10 col-xs-10">
              <div class="event_post_content bg-gradient">

                <div class="event-thumb">
                  <img src="{{asset('web/images/Gulf print pack logo.png')}}" class="event-img">
                </div>

                <div class="event-desc">
                  <h3 class="title-eventpost">
                    Gulf Print Pack
                  </h3>
                  <div class="event_post_desc">
                    28 September - 30 September,<br>
                    Dubai World Trade Centre, Dubai
                  </div>
                </div>

              </div>
            </div>

            <div class="event-box-center col-md-2 col-sm-2 col-xs-2">
              <div class="event_post_date">SEP 28</div>
            </div>

          </div>
        </div>

        <!-- 2nd EVENT (RIGHT) -->
        <div class="event-content col-md-6 col-sm-12 col-xs-12">
          <div class="row row-event">

            <div class="event-box-conner col-md-10 col-sm-10 col-xs-10">
              <div class="event_post_content bg-gradient">

                <div class="event-thumb">
                  <img src="{{asset('web/images/loupe.png')}}" class="event-img">
                </div>

                <div class="event-desc">
                  <h3 class="title-eventpost">
                    Loupe India 2026
                  </h3>
                  <div class="event_post_desc">
                    29 October - 1 November,<br>
                    Greater Noida, Delhi NCR, India
                  </div>
                </div>

              </div>
            </div>

            <div class="event-box-center col-md-2 col-sm-2 col-xs-2">
              <div class="event_post_date">OCT 29</div>
            </div>

          </div>
        </div>

        <!-- 3rd EVENT (LEFT again) -->

        <div class="event-content col-md-6 col-sm-12 col-xs-12" style="margin:0;">
          <div class="row row-event">
            <div class="event-box-conner col-md-10 col-sm-10 col-xs-10">
              <div class="event_post_content bg-gradient">

                <div class="event-thumb">
                  <iframe
                    src="https://www.google.com/maps?q=28.4739,77.5023&z=16&output=embed"
                    width="100%"
                    height="215"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                  </iframe>
                </div>
                <div class="event-desc">
                  <h3 class="title-eventpost">
                    <a href="event-lightbox.html" class="various fancybox.ajax">PMEC 2026</a>
                  </h3>
                  <div class="event_post_desc">
                    24 Nov - 26 Nov <br> India Expo Centre and Mart, Greater Noida, Delhi India
                  </div>
                </div>
              </div>
            </div>
            <div class="event-box-center col-md-2 col-sm-2 col-xs-2">
              <div class="event_post_date">APR 26</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="spacer-100"></div>
</div>
</div>
@if(!empty($blogs) && count($blogs) > 0)

<section class="solution-2-area grey-bg">

  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="main-title wow zoomIn">
          <div class="main-shadow-heading">
            <h2>Our Blog</h2>
          </div>
          <h2>Our <span style="color: #7a0d7d;">Blog</span></h2>
          <h3>A blog about analytics, marketing & testing</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="solution-2-content">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div id="solution-slider" class="owl-carousel all-carousel owl-theme">
            @foreach($blogs as $index => $blog)
            @if($index == 6)
            @break
            @endif
            <div class="solution-slider-content">
              <div class="solution-slider-img">
                <img src="{{ asset('storage/' . $blog->image_path) }}"
                  alt="Current blog image">
              </div>
              <div class="solution-slider-text">
                <div class="full-intro-head">
                  <p>
                    {{$blog->publish_date ?? '--'}} <span><a href="#">Business</a></span>.
                  </p>
                </div>
                <p>{{ $blog->title ?? 'Blog Title' }}</p>
                <!-- <p>{!!Str::limit($blog->description ?? 'Blog description', 100)!!}</p> -->
                <a href="{{route('blog')}}">Learn More <i class="fa fa-long-arrow-right"></i></a>
              </div>
            </div>
            @endforeach
          </div>

        </div>
      </div>
    </div>
  </div>

</section>

@endif
<!-- Testimonials -->
{{--<div id="review" class="">
  <div class="testimonials bg-gradient">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="testimonial">
            <div id="testimonial_slide" class=" owl-carousel">
              <div class="testimonial-content">
                <div class="testimonial-profile">
                  <img width="100" height="100" alt="testimonial" src="{{asset('web/images/150x150.jpg')}}" class="testimonial-img">
</div>
<h3 class="name"> Vikas Sethi</h3>
<p class="job">Product manager, Agro Company</p>
<div class="team_description">
  <p>Easy onboarding process, no technical knowledge required and seamless integration is the highlights of th solution. Good work.</p>
</div>
</div>
<div class="testimonial-content">
  <div class="testimonial-profile">
    <img width="100" height="100" alt="testimonial" src="{{asset('web/images/150x150.jpg')}}" class="testimonial-img">
  </div>
  <h3 class="name"> LyLy Parker</h3>
  <p class="job">MD, Label Printer</p>
  <div class="team_description">
    <p>We usually asked by our client to provide track and trace solution with different use cases, TRACESCI works well with maximum scenario and thats the reason we recommend this..</p>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>--}}

<!-- Get In Touch -->
{{--<div id="get_in_touch" class="contact-box padding-content content-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="riven-heading text-center" data-sr="enter bottom wait 0.3s">
              <h2><span>Get In</span> Touch</h2>
              <p class="text">Feel free to discuss your project with us, we assure you best of support...</p>
            </div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="contact-info">
              <ul>

                <li class="icon_list_item">
                  <div class="icon_list_icon">
                    <h5><i class="fa fa-map-marker" aria-hidden="true"></i> Office </h5>
                  </div>
                  Tracesci Pvt Ltd.,<br>
                  B-15, InfoCity Phase 1, Sector 34,<br>
                  Gurugram-122001, Haryana, India

                </li>
                <li class="icon_list_item">
                  <div class="icon_list_icon">
                    <h5><i class="fa fa-phone" aria-hidden="true"></i> Phone</h5>
                  </div>

                  <a href="callto:+911244226771">+91-124-422-6771</a>
                </li>
                <li class="icon_list_item">
                  <div class="icon_list_icon">
                    <h5><i class="fa fa-envelope" aria-hidden="true"> </i> Email</h5>
                  </div>

                  <a href="mailto:wecare@tracesci.in">wecare@tracesci.in</a>

                </li>
                <li>
                  <h5>Find us elsewhere</h5>
                  <ul class="social-networks">
                    <li class="social-fb first"><a href="https://www.facebook.com/jetsciglobal/"><i class="fa fa-facebook"></i></a></li>
                    <li class="social-linkedin"><a href="https://www.linkedin.com/company/jetsciglobal"><i class="fa fa-linkedin"></i></a></li>
                    <li class="social-youtube"><a href="https://www.youtube.com/channel/UCDnSaAwRgBssFuTUX_2iCJw"><i class="fa fa-youtube-play"></i></a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="wpcf7">
              <form id="#contact_form" class="wpcf7-form">
                @csrf
                <div class="contact-form">
                  <p class="inner-input mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                      Name
                    </label>
                    <span class="your-name"><input type="text" id="name" class="contact__input" name="name" required></span>
                  <div id="error-name" class="text-danger contact__input-error mb-3"></div>

                  </p>

                  <p class="inner-input mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-email">
                      Email
                    </label>
                    <span class="your-email"><input type="email" id="email" class="contact__input" name="email" required></span>
                  <div id="error-email" class="text-danger contact__input-error mb-3"></div>
                  </p>


                  <p class="inner-input mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-mobile">
                      Mobile
                    </label>
                    <span class="your-mobile"><input type="text" id="mobile" class="contact__input" name="mobile" required></span>
                  <div id="error-mobile" class="text-danger contact__input-error mb-3"></div>
                  </p>

                  <p class="inner-input mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-message">
                      Message
                    </label>
                    <span class="textarea"><textarea id="message" class="area contact__input" name="message" required></textarea></span>
                  <div id="error-message" class="text-danger contact__input-error mb-3"></div>

                  </p>

                  <p class="contact-submit"><button id="btn-contact" type="button" class="btn btn-default button" data-loading-text="Loading...">Submit</button></p>
                </div>
              </form>
              <div class="alert alert-warning hidden" id="contactwait">
                <strong>Please Wait!</strong>
              </div>
              <div class="alert alert-success hidden" id="contactSuccess">
                <strong>Success!</strong> Your message has been sent to us.
              </div>

              <div class="alert alert-error p-0 hidden" id="contactError">
                <strong>Error!</strong> There was an error sending your message.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="spacer-90"></div>
    </div>



    <!-- Map -->
    <div class="map-info map-contact">
      <div class="container-fluid no-padding">
        <div class="row">
          <div class="col-md-12 col-xs-12 col-sm-12">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3508.631880488345!2d77.01043561507808!3d28.430362582498017!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d181b33427c19%3A0x1d7f2dae6742eec3!2sJETSCI%C2%AE%20Global!5e0!3m2!1sen!2sin!4v1625823933261!5m2!1sen!2sin" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
        </div>
      </div>
    </div>--}}
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
        // showNotification('success','Success!',res.data.message)
        setTimeout(() => {
          window.location.reload()
        }, 3000)
      }).catch(err => {
        // showNotification('error','Error !',err.response.data.message)
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

      delay: 999999999, // ⛔ disable auto sliding

      navigation: {
        arrows: {
          enable: true,
          style: "uranus",
          hide_onleave: false
        }
      },

      stopLoop: "on",
      stopAfterLoops: 0,
      stopAtSlide: 1,

      disableProgressBar: "on",

      fullScreenOffsetContainer: "" // add header selector if needed
    });

    // ✅ extra safety: pause autoplay
    revapi.revpause();
  });
</script>


@endsection