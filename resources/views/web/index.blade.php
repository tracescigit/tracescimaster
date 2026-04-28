@extends('web.layouts.app')
@section('content')

<!-- slider -->

<div class="rev_slider_wrapper">
  <div id="slider1" class="rev_slider" data-version="5.0">
    <ul>

      <!-- SLIDE 1 -->
      <li data-index="rs-1" data-transition="parallaxtoright" data-delay="6500">

        <!-- MAIN IMAGE -->
        <img src="{{asset('dist/images/slide1.png')}}"
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
          data-transform_out="opacity:0;s:300";>
          <span class="sl-italic" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
            Let us help you to authenticate and track your product
          </span>
        </div>

        <!-- LAYER 2 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="190"
          data-start="1800"
          data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300";>
          <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
            SUPPLY CHAIN TRACESCI PLATFORM
          </div>
        </div>

        <!-- LAYER 3 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="300"
          data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300";>
          <div class="sl-italic sl-italic-2 text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
            Our strategists will help you set an objective and choose your tools,<br>
            developing a plan that is custom-built for your business.
          </div>
        </div>

        <!-- LAYER 4 (Buttons) -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="430"
          data-start="2800" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300";>
          <div class="rev-slider-btn text-center">
            <a a href="{{ url(Auth::check()?myDashboard():'/login') }}">Login</a>
            <a a href="{{ url(Auth::check()?myDashboard():'/register') }}">Register</a>
          </div>
        </div>

      </li>

      <!-- SLIDE 2 -->

      <li data-index="rs-2" data-transition="parallaxtoright" data-delay="6500">

        <!-- MAIN IMAGE -->
        <img src="{{asset('dist/images/slide2.png')}}"
          class="rev-slidebg"
          data-bgposition="center center"
          data-bgfit="cover"
          data-bgrepeat="no-repeat">

        <!-- LAYER 1 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="120"
          data-start="1200" 
          data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300"; >
          <span class="sl-italic" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
            Informed decisions. Exceptional results
          </span>
        </div>

        <!-- LAYER 2 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="190"
          data-start="1800" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300"; >
          <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
            We Measure The Social Web
          </div>
        </div>

        <!-- LAYER 3 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="300"
          data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300"; >
          <div class="sl-italic sl-italic-2 text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
            Our strategists will help you set an objective and choose your tools,<br>
            developing a plan that is custom-built for your business.
          </div>
        </div>

        <!-- LAYER 4 (Buttons) -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="430"
          data-start="2800" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300"; >
          <div class="rev-slider-btn text-center">
            <a href="#">Read More</a>
            <a href="#">Get Started</a>
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
          data-transform_out="opacity:0;s:300"; >
          <span class="sl-italic" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
            Informed decisions. Exceptional results
          </span>
        </div>

        <!-- LAYER 2 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="190"
          data-start="1800" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300"; >
          <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">
            We Measure The Social Web
          </div>
        </div>

        <!-- LAYER 3 -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="300"
          data-start="2400" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300"; >
          <div class="sl-italic sl-italic-2 text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
            Our strategists will help you set an objective and choose your tools,<br>
            developing a plan that is custom-built for your business.
          </div>
        </div>

        <!-- LAYER 4 (Buttons) -->
        <div class="tp-caption tp-resizeme"
          data-x="center" data-y="top" data-voffset="430"
          data-start="2800" data-transform_in="y:[100%];opacity:0;s:800;"
          data-transform_out="opacity:0;s:300"; >
          <div class="rev-slider-btn text-center">
            <a href="#">Read More</a>
            <a href="#">Get Started</a>
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
          <h2>Hello, We Are Tracesci</h2>
          <h3>Do More With Social Media</h3>
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
              Blockchain-enabled supply chain tracking with deep insights of each product
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
                Powered by <span>Block Chain</span> Authentic, safe and connected
              </h2>
            </div>
          </div>
          <div class="refresh-phone-content">

            <div class="text-desc">
              <p class="text-center">The SaaS platform provides brand owners deep consumer and supply chain insights regarding their products like <br>real-time GPS location, scanning pattern and suspicious activity alerts.<br>It will help to get actionable product data for strategic decision-making and operational excellence.</p>
            </div>
            <a class="btn btn-primary ubtn">Industries we cater</a>

          </div>
          <div class="spacer-100"></div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.3s">
          <div class="thumbnail-game text-center">
            <img height="150" src="{{asset('web/images/Picture1.jpg')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="character-3" />
          </div>
          <div class="desc text-center">
            <h3>Apparel</h3>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.6s">
          <div class="thumbnail-game text-center">
            <img height="150" src="{{asset('web/images/Picture2.jpg')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="character-3" />
          </div>
          <div class="desc text-center">
            <h3>Food</h3>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.9s">
          <div class="thumbnail-game text-center">
            <img height="150" src="{{asset('web/images/Picture3.jpg')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="character-3" />
          </div>
          <div class="desc text-center">
            <h3>Automobile</h3>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 1.2s">
          <div class="thumbnail-game text-center">
            <img height="150" src="{{asset('web/images/Picture4.jpg')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="character-3" />
          </div>
          <div class="desc text-center">
            <h3>Tobacco</h3>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 0.9s">
          <div class="thumbnail-game text-center">
            <img height="150" src="{{asset('web/images/Picture5.jpg')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="character-3" />
          </div>
          <div class="desc text-center">
            <h3>Pharma</h3>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6 mb-4" data-sr="enter left and move 20px wait 1.2s">
          <div class="thumbnail-game text-center">
            <img height="150" src="{{asset('web/images/Picture6.jpg')}}" class="attachment-post-thumbnail size-post-thumbnail w-100 wp-post-image" alt="character-3" />
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

<div class="solution-area">
  <!-- MAIN TITLE AREA -->
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="main-title wow zoomIn">
          <div class="main-shadow-heading">
            <h2>Amazing <span>Features</span></h2>
          </div>
          <h2>Amazing <span>Features</span></h2>
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
            <p>Simple process driven solution, that suits from small to large manufacturers requirment. ...</p>
            <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
            <span><i class="icon icon-Chart"></i></span>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="solution-single-content wow fadeInUp">
            <h2>Protect your Product</h2>
            <p>Secure packaging and authentication capabilities enable you to protect your brand and keep consumers safe while building brand trust...</p>
            <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
            <span><i class="icon icon-Shield"></i></span>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="solution-single-content wow fadeInRight">
            <h2>Engage with end consumer</h2>
            <p>Get access to valuable market insights, including the end user’s profile.Connect them with your loyality programs ...</p>
            <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
            <span><i class="icon icon-MessageLeft"></i></span>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="solution-single-content solution-single-content-no-border wow fadeInLeft">
            <h2>Product serialization</h2>
            <p>For digital transformation to take place, serialization will be a first step and a key enabler for every brand ...</p>
            <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
            <span><i class="icon icon-Antenna2"></i></span>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="solution-single-content wow fadeInUp">
            <h2>Regulatory compliance</h2>
            <p>Get a powerful one solution supporting various compliance mandates set by different countries for different businesses ...</p>
            <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
            <span><i class="icon icon-Tools"></i></span>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="solution-single-content wow fadeInRight">
            <h2>Seamless Hardware integration</h2>
            <p>Easy to integrate with any printing/labelling device, speed conveyor systems, vision inspection cameras etc ...</p>
            <a href="#">Learn More <i class="fa fa-long-arrow-right"></i></a>
            <span><i class="icon icon-Puzzle"></i></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="all-link solution-btn text-center">
            <a href="#">More Services</a>
          </div>
        </div>
      </div>
    </div>
  </div>








  <div style="background-color: #f5f5f5; margin-top: 50px; ">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <div class="main-title wow zoomIn">
            <div class="main-shadow-heading">
              <h2><span>How </span>it works??</h2>
            </div>
            <h2><span>How </span>it works??</h2>
            <h3>Trusted By The Best Marketers</h3>
          </div>
        </div>
      </div>
    </div>
    <!-- END TITLE -->

    <div class="help-content-area" style="background-color: #f5f5f5;">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="help-accordion">
              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Brand Onboarding </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">Complete paperless on-boarding of brands, manufacturers and solution providers. submit details and upload documents required and after approval, you will get access of the platform.Fill in your information accurately as it impacts your future communication, billing information and free support.</div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Select a subscription plan</a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body"> By default, Free plan will be activated. The FREE plan gives you all the essential features & tools to setup your solution and continue using the platform for a few things / items free forever. You can always upgrade your account to a paid plan if you’re ready to scale beyond the limits of the FREE plan.</div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Manage product, batch and serialisation </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">Flexible Management of your brand, product, batches serialization.</div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingFour">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseTwo"> Activate as production goes</a>
                    </h4>
                  </div>
                  <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                    <div class="panel-body"> Activate products and keep a track on your raw materials, ingredients, supply chain, shipments, manufacturing batches, product SKUs right down to product level. Thats it</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="help-question" style="margin-bottom: 50px;">
              <p>Feel free to get in touch with any enquiries or questions and one of our members will get back to you as soon as possible !</p>
              <span><a href="#">Ask A Question <i class="fa fa-long-arrow-right"> </i></a></span>
            </div>
          </div>
          <div class="col-md-6">
            <div id="help-slider" class="owl-carousel all-carousel owl-theme">
              <div>
                <div class="help-slider-content">
                  <div class="help-slider-text">
                    <i class="fa fa-quote-left"></i>
                    <i class="fa fa-quote-right"></i>
                    <p>In my job as social media strategist, I've tried pretty much every analytics product on the market and when I came across Tracesci, I was blown away! Tracesci is one of the most impressive social media website efforts I've ever seen.</p>
                    <img src="{{ asset('dist/images/home-slider-img-left.png') }}" alt="">
                  </div>
                  <div class="help-slider-img">
                    <h2>Mahmoud Baghagho</h2>
                    <h3>Art Director</h3>
                  </div>
                </div>
              </div>
              <div>
                <div class="help-slider-content">
                  <div class="help-slider-text">
                    <i class="fa fa-quote-left"></i>
                    <i class="fa fa-quote-right"></i>
                    <p>In my job as social media strategist, I've tried pretty much every analytics product on the market and when I came across Tracesci, I was blown away! Tracesci is one of the most impressive social media website efforts I've ever seen.</p>
                    <img src="{{ asset('dist/images/home-slider-img-left.png') }}" alt="">
                  </div>
                  <div class="help-slider-img">
                    <h2>Mahmoud Baghagho</h2>
                    <h3>Art Director</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </section>




    <!--how it works -->
    <!-- video-->
    <div class="video-home">
      <div class="bg-gradient">
        <div class="riven-container container  video-container">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="wpb_text_column wpb_content_element ">
                <div class="wpb_wrapper">
                  <p><a class="fancybox btn-play" title="Play video" href="{{asset('web/videos/tracesci_storyboard.mp4')}}" data-type="iframe">Watch Now</a></p>
                </div>
              </div>
              <div class="spacer-20"></div>
              <div class="title-block">
                <div class="riven-heading text-center">
                  <h2> <span>Now </span> Everyone can afford product traceability</h2>
                </div>
              </div><!-- END riven_heading -->

              <div class="wpb_text_column wpb_content_element ">
                <div class="wpb_wrapper">
                  <p>A solution to deter counterfeiters from stealing your revenue & damaging your brand reputation.</p>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- Pricing Table -->
    <section class="pricing-table-section grey-bg">
      <!-- MAIN TITLE AREA -->
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="main-title wow zoomIn">
              <div class="main-shadow-heading">
                <h2>Pricing <span>Plans</span></h2>
              </div>
              <h2>Pricing <span>Plans</span></h2>
              <h3>Our pay as you go pricing plans are driven by usage of platform resources, premium features, support & service levels. Select which suits to you</h3>
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
                  <span>
                    @if ($country=='India')
                    &#8377; {{$plan->price_inr}}
                    @else
                    $ {{$plan->price_usd}}
                    @endif
                  </span>
                  <span>/ Monthly</span>
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
                    <a class="btn btn-default" href="{{url('register')}}">Sign up</a>
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



    <!-- Event Calendar -->
    <div id="event_calendar" class="padding-content content-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="riven-heading text-center" data-sr="enter bottom wait 0.3s">
              <h2><span>Event</span> Calendar</h2>
              <p class="text">Save the dates. We would love to see you..</p>
            </div>
          </div>
        </div>
        <div class="spacer-35"></div>
        <div class="event-container">
          <div class="event-contents row">
            <div class="event event_post event-entries-wrap has-loadmore">
              <div class="event-content col-md-6 col-sm-12 col-xs-12">
                <div class="row row-event">
                  <div class="event-box-conner col-md-10 col-sm-10 col-xs-10">
                    <div class="event_post_content bg-gradient">
                      <div class="event-thumb">
                        <img width="456" height="215" alt="event" src="{{asset('web/images/PAMEX2021.jpg')}}" class="event-img">
                      </div>
                      <div class="event-desc">
                        <h3 class="title-eventpost">
                          <a href="event-lightbox.html" class="various fancybox.ajax">Pamex India 2022</a>
                        </h3>
                        <div class="event_post_desc">
                          23 - 26 March 2022, Mumbai.
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="event-box-center col-md-2 col-sm-2 col-xs-2">
                    <div class="event_post_date">MAR 23</div>
                  </div>
                </div>
              </div>

              <div class="event-content col-md-6 col-sm-12 col-xs-12" style="margin:0;">
                <div class="row row-event">
                  <div class="event-box-conner col-md-10 col-sm-10 col-xs-10">
                    <div class="event_post_content bg-gradient">

                      <div class="event-thumb">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10065.462847026438!2d4.3336038!3d50.8984489!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xde9326a4546954ab!2sBrussels%20Expo!5e0!3m2!1sen!2sin!4v1625808010325!5m2!1sen!2sin" width="455" height="215" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                      </div>
                      <div class="event-desc">
                        <h3 class="title-eventpost">
                          <a href="event-lightbox.html" class="various fancybox.ajax">Label Expo Europe 2022</a>
                        </h3>
                        <div class="event_post_desc">
                          26 - 29 April 2022 <br> Brussels Expo
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="event-box-center col-md-2 col-sm-2 col-xs-2">
                    <div class="event_post_date">APR 26</div>
                  </div>
                </div>
              </div>

              <div class="event-content col-md-6 col-sm-12 col-xs-12">
                <div class="row row-event">
                  <div class="event-box-conner col-md-10 col-sm-10 col-xs-10">
                    <div class="event_post_content bg-gradient">
                      <div class="event-thumb">
                        <img width="456" height="215" alt="event" src="{{asset('web/images/Labelexpo2022.jpg')}}" class="event-img">
                      </div>
                      <div class="event-desc">
                        <h3 class="title-eventpost">
                          <a href="event-lightbox.html" class="various fancybox.ajax">Label Expo India 2022</a>
                        </h3>
                        <div class="event_post_desc">
                          10 - 13 November 2022, India Expo Centre & Mart, Greater Noida, Delhi NCR
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="event-box-center col-md-2 col-sm-2 col-xs-2">
                    <div class="event_post_date">NOV 10</div>
                  </div>
                </div>
              </div>

              <div class="event-content col-md-6 col-sm-12 col-xs-12">
                <div class="row row-event">
                  <div class="event-box-conner col-md-10 col-sm-10 col-xs-10">
                    <div class="event_post_content bg-gradient">
                      <div class="event-thumb">
                        <img width="456" height="215" alt="event" src="{{asset('web/images/cphi2022.jpg')}}" class="event-img">
                      </div>
                      <div class="event-desc">
                        <h3 class="title-eventpost">
                          <a href="event-lightbox.html" class="various fancybox.ajax">PMEC India 2022</a>
                        </h3>
                        <div class="event_post_desc">
                          29 Nov - 1 Dec 2022, India Expo Centre & Mart, Greater Noida, Delhi NCR
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="event-box-center col-md-2 col-sm-2 col-xs-2">
                    <div class="event_post_date">NOV 29</div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="spacer-100"></div>
      </div>
    </div>
    <!-- Testimonials -->
    <div id="review" class="">
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
    </div>

    <!-- Get In Touch -->
    <div id="get_in_touch" class="contact-box padding-content content-section">
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