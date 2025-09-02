@extends('web.layouts.app')
@section('content')
<!-- slider -->
<div class="main-slider">
  <div id="overview" class="slider-1 content-section">
    <div class="tp-banner-container">
      <div class="tp-banner-1">
        <ul>
          <li data-transition="fade" data-slotamount="7" data-masterspeed="300" data-saveperformance="on"  data-title="Riven">

            <img src="{{asset('web/images/03/banner-1.jpg')}}" alt="" data-bgposition="center center" data-duration="" data-ease="Power0.easeInOut" data-bgfit="cover" data-bgrepeat="no-repeat"/>
            <div class="tp-caption tp-resizeme" data-x="center" data-hoffset="0" data-y="center" data-voffset="-215" data-speed="500" data-start="500" data-easing="Power4.easeOut" data-splitin="none" data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.1" data-endspeed="500" data-endeasing="Power4.easeIn" style="z-index: 5; color:#fff; font-weight: 300; white-space: nowrap; line-height:100%; font-size:20px; text-transform:uppercase;">
              <h3 class="text-title ">Let us help you to authenticate and track your product
              </h3>
            </div>  
            <!-- LAYERS 3-->
            <div class="tp-caption tp-resizeme"
            data-x="center" data-hoffset="0"
            data-y="center" data-voffset="-150"
            data-speed="500"
            data-start="1300"
            data-easing="Power4.easeOut"
            data-splitin="none"
            data-splitout="none"
            data-elementdelay="0.01"
            data-endelementdelay="0.1"
            data-endspeed="500"
            data-endeasing="Power4.easeIn"
            style="z-index: 4; font-weight:900; text-transform: none;letter-spacing:0px; line-height:45px; color:#fff; text-align:center; max-width: auto; max-height: auto; white-space: nowrap;"><div class="text-bg" style="font-size: 36px; color: #d15688; padding: 6px 18px 7px; text-transform: uppercase;">Supply Chain TRACESCI Platform</div>
          </div>    
          <div class="tp-caption tp-resizeme btn-slider-1"
          data-x="center" data-hoffset="0"
          data-y="center" data-voffset="-80"
          data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
          data-speed="500"
          data-start="1500"
          data-easing="Power3.easeInOut"
          data-splitin="none"
          data-splitout="none"
          data-elementdelay="0.05"
          data-endelementdelay="0.1"
          data-endspeed="500"
          style="z-index: 7; white-space: nowrap;">
          <a class="btn btn-default btn-auth btn-icon" style="padding:8px 20px 7px; margin: 0 13px; color:#FFF;  line-height:20px;" href="{{url('register')}}"><i class="fa fa-flash"></i> Register now</a>            
          <a class="btn btn-default btn-auth btn-icon" style="padding:8px 20px 7px; margin: 0 13px; color:#FFF;  line-height:20px;" href="{{ url(Auth::check()?myDashboard():'/login') }}"><i class="fa fa-sign-in"></i> Sign in</a>           
        </div>
        <div class="tp-caption tp-resizeme"
        data-x="center" data-hoffset="0"
        data-y="bottom" data-voffset="0"
        data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
        data-speed="500"
        data-start="1500"
        data-easing="Power3.easeInOut"
        data-splitin="none"
        data-splitout="none"
        data-elementdelay="0.05"
        data-endelementdelay="0.1"
        data-endspeed="500"
        style="z-index: 3; white-space: nowrap; ">
        <img src="{{asset('web/images/04/img-slider.png')}}" alt=""/>
      </div>
    </li>
  </ul>
</div>
</div>
</div>
</div>  
<!-- the content -->
<div id="main" class="wrapper"> 
  <div id="primary" class="content-area">
    <!-- icon services -->
    <div class="icon-services">
      <div class="spacer-60"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-6 col-xs-12" data-sr="enter left and move 20px wait 0.3s">
            <div class="icon-inner">
              <span class="pe-7s-key"></span>
            </div>
            <div class="desc text-center">
              <h3>Brand Protection</h3>
              <p>Ensure products are genuine with non-additive digital authentication</p>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12" data-sr="enter left and move 20px wait 0.6s">
            <div class="icon-inner">
              <span class=" pe-7s-map-2"></span>
            </div>
            <div class="desc text-center">
              <h3>Traceability</h3>
              <p>Block chain enabled supply chain tracking, Deep insights of each product</p>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12" data-sr="enter left and move 20px wait 0.9s">
            <div class="icon-inner">
              <span class="pe-7s-gleam"></span>
            </div>
            <div class="desc text-center">
              <h3>Real Time Alerts</h3>
              <p>Conditions to help prevent product damage, diversion or waste</p>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12" data-sr="enter left and move 20px wait 1.2s">
            <div class="icon-inner">
              <span class="pe-7s-link"></span>
            </div>
            <div class="desc text-center">
              <h3>GS1 Compliant</h3>
              <p>Fully customised solution, in complaintce with GS1</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- refresh-phone -->
    <div  id="application" class="refresh-phone padding-content">
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

    <!-- features -->
    <div id="features" class="features padding-content bg-gradient content-section">
      <div class="container">
        <div class="row">
          <div class="title-block">
            <div class="riven-heading text-center text-white" data-sr="enter bottom wait 0.3s">
              <h2>
                Amazing <span>Features</span>
              </h2>
            </div>
          </div>
          <div class="features-content">
            <div class="col-md-4 col-sm-6 col-xs-12">
              <ul class="smile_icon_list left circle with_bg">
                <li class="icon_list_item">
                  <div class="icon_list_icon">
                    <i class="fa fa-area-chart" aria-hidden="true"></i>
                  </div>
                  <div class="icon_description">
                    <h3>Easy to use</h3>
                    <div class="icon_description_text">
                      <p>Simple process driven solution, that suits from small to large manufacturers requirment.</p>
                    </div>
                  </div>
                </li>
                <li class="icon_list_item">
                  <div class="icon_list_icon">
                    <i class="fa fa-globe" aria-hidden="true"></i>
                  </div>
                  <div class="icon_description">
                    <h3>Protect your Product</h3>
                    <div class="icon_description_text">
                      <p>Secure packaging and authentication capabilities enable you to protect your brand and keep consumers safe while building brand trust.</p>
                    </div>
                  </div>
                </li>
                <li class="icon_list_item">
                  <div class="icon_list_icon">
                    <i class="fa fa-user-md" aria-hidden="true"></i>
                  </div>
                  <div class="icon_description">
                    <h3>Engage with end consumer</h3>
                    <div class="icon_description_text">
                      <p>Get access to valuable market insights, including the end user’s profile.Connect them with your loyality programs</p>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="col-md-4 hidden-sm hidden-xs text-center">
              <img src="{{asset('web/images/slider-11.png')}}" alt=""/>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
              <ul class="smile_icon_list right circle with_bg">
                <li class="icon_list_item">
                  <div class="icon_list_icon">
                    <i class="fa fa-shield" aria-hidden="true"></i>
                  </div>
                  <div class="icon_description">
                    <h3>Product serialization</h3>
                    <div class="icon_description_text">
                      <p>For digital transformation to take place, serialization will be a first step and a key enabler for every brand</p>
                    </div>
                  </div>
                </li>
                <li class="icon_list_item">
                  <div class="icon_list_icon">
                    <i class="fa fa-stethoscope" aria-hidden="true"></i>
                  </div>
                  <div class="icon_description">
                    <h3>Regulatory compliance</h3>
                    <div class="icon_description_text">
                      <p>Get a powerful one solution supporting various compliance mandates set by different countries for different businesses </p>
                    </div>
                  </div>
                </li>
                <li class="icon_list_item">
                  <div class="icon_list_icon">
                    <i class="fa fa-life-ring" aria-hidden="true"></i>
                  </div>
                  <div class="icon_description">
                    <h3>Seamless Hardware integration</h3>
                    <div class="icon_description_text">
                      <p>Easy to integrate with any printing/labelling device, speed conveyor systems, vision inspection cameras etc</p>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="spacer-100"></div>
    </div>
    <!-- some facts -->
    <div class="padding-content some-facts">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="title-block">
              <div class="riven-heading text-center" data-sr="enter bottom wait 0.3s">
                <h2> Some <span>Facts</span></h2>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="amount-content bg-gradient">
              <div class="amount">
                <div class="amount-desc">
                  <h3 id="">10+</h3>
                  <h5 >Countries</h5>
                </div>
              </div>
              <div class="img-icon">
               <i class="fa fa-globe"></i>
             </div>
           </div>
         </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="amount-content bg-gradient">
            <div class="amount">
              <div class="amount-desc">
                <h3 id="">300+</h3>
                <h5 >Users</h5>
              </div>
            </div>
            <div class="img-icon">
             <i class="fa fa-users"></i>
           </div>
         </div>
       </div>
       <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="amount-content bg-gradient">
          <div class="amount">
            <div class="amount-desc">
              <h3  id="">125+</h3>
              <h5>Clients</h5>
            </div>
          </div>
          <div class="img-icon">
           <i class="fa fa-trophy"></i>
         </div>
       </div>
     </div>
     <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="amount-content bg-gradient">
        <div class="amount">
          <div class="amount-desc">
            <h3  id="">97M</h3>
            <h5>Unique Codes</h5>
          </div>
        </div>
        <div class="img-icon">
         <i class="fa fa-qrcode"></i>
       </div>
     </div>
   </div>
 </div>
</div>
</div>
<!--app screenshot-->
<div class="app_screenshot">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12 title-block">
        <div class="riven-heading text-left" data-sr="enter bottom wait 0.1s">
          <h2>Powerful <span>Mobile</span> Applications</h2>
        </div>
      </div>
    </div>
  </div>
  <div class="slider-app bg-gray">
    <div class="spacer-35"></div>
    <div class="tp-banner-container">
      <div class="tp-banner-app">
        <ul>
          <li data-saveperformance="on" data-masterspeed="500" data-slotamount="7" data-title="Slide" data-ssop="true"  data-hideslideonmobile="off" data-hideafterloop="0" data-transition="slideremoveleft">            
            <div class="tp-caption tp-resizeme"
            data-x="59"
            data-y="164"
            data-speed="1000"
            data-start="500"
            data-easing="Power4.easeOut"
            data-splitin="none"
            data-splitout="none"
            data-elementdelay="0.01"
            data-endelementdelay="0.1"
            data-endspeed="500"
            data-endeasing="Power4.easeIn"
            style="z-index: 4; font-weight:400; max-height: 96px; min-height: 96px;  min-width: 445px; max-width: 445px; letter-spacing: 0; text-transform: none; font-size: 14px; line-height:22px; color:#fff; max-width: auto; white-space: normal;">
            <div class="screen-default app-screen-1 open">
              <h3>Citizen's App</h3>
              <p>Provides instantaneous authentication </p>
              <p>Can be linked to brand promotion, loyalty, warranty programs</p>
              <p>See Product Journey</p>
              <p>Report product issues</p>

              <h3>Brand / Authority App</h3>
              <p>
              More insights of all scans </p>
              <p>
                Track & trace all supply chain points
              </p>
              <p>
                Fraud Investigation
              </p>
              <p>
                Get all scan history
              </p>
            </div>

          </div>
          <div class="tp-caption tp-resizeme"
          data-x="566"
          data-y="123"
          data-speed="1000"
          data-start="500"
          data-easing="Power4.easeOut"
          data-splitin="none"
          data-splitout="none"
          data-elementdelay="0.01"
          data-endelementdelay="0.1"
          data-endspeed="500"
          data-endeasing="Power4.easeIn"
          style="z-index: 5; border-color: rgb(36, 36, 36); border-width: 0px; line-height: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 14px; white-space: normal; min-height: 0px; min-width: 0px; max-height: none; max-width: none;">
          <img src="{{asset('web/images/04/11.png')}}" alt=""/>  
        </div>
        <div class="tp-caption tp-resizeme"
        data-x="848"
        data-y="129"
        data-speed="1000"
        data-start="500"
        data-easing="Power4.easeOut"
        data-splitin="none"
        data-splitout="none"
        data-elementdelay="0.01"
        data-endelementdelay="0.1"
        data-endspeed="500"
        data-endeasing="Power4.easeIn"
        style="z-index: 6; box-shadow: 10px 15px 25px 0px rgba(0, 0, 0, 0.35); line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 14px; white-space: nowrap; min-height: 0px; min-width: 0px; max-height: none; max-width: none;">
        <img src="{{asset('web/images/04/2.png')}}" alt=""/> 
      </div>      
      <div class="tp-caption tp-resizeme"
      data-x="1075"
      data-y="131"
      data-speed="1000"
      data-start="500"
      data-easing="Power4.easeOut"
      data-splitin="none"
      data-splitout="none"
      data-elementdelay="0.01"
      data-endelementdelay="0.1"
      data-endspeed="500"
      data-endeasing="Power4.easeIn"
      style="z-index: 7;box-shadow: 10px 15px 25px 0px rgba(0, 0, 0, 0.35); line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 14px; white-space: nowrap; min-height: 0px; min-width: 0px; max-height: none; max-width: none;">
      <img src="{{asset('web/images/04/3.png')}}" alt=""/> 
    </div>
  </li>

</ul>
<div class="tp-static-layers">
  <div class="tp-caption tp-resizeme tp-static-layer rev-static-visbile"
  data-x="556"
  data-y="66"
  data-speed="1000"
  data-start="500"
  data-easing="Power4.easeOut"
  data-splitin="none"
  data-splitout="none"
  data-elementdelay="0.01"
  data-endelementdelay="0.1"
  data-endspeed="500"
  data-endeasing="Power4.easeIn"
  style="z-index:3; width: 273px; height: 578px; line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 14px;">
  <img src="{{asset('web/images/04/1.png')}}" alt=""/> 
</div>
</div>
</div>
</div>
<div class="spacer-50"></div>
</div>
</div>
<!-- Get App -->
<div class="get-app bg-gradient">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="get-app-content">
          <a href="#" class="btn btn-default btn-icon btn-icon-1">Download for<br><span>IOS</span></a>
          <a href="https://play.google.com/store/apps/details?id=com.tracesci.citizenapp" class="btn btn-default btn-icon btn-icon-2">Download for<br><span>Android</span></a>
        </div>
      </div>
    </div>
  </div>
</div>
<!--how it works -->
<div  id="howitworks" class="choose-riven">
  <div class="spacer-95"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12"></div>
      <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
        <div class="title-block">
          <div class="riven-heading text-left " data-sr="enter left wait 0.3s">
            <h2>
              <span>How </span>it works??
            </h2>
          </div>
          <div class="spacer-50"></div>
        </div>
        <div id="accordion" class="panel-group">
          <div class="panel panel-default">
            <div class="panel-heading ">
             <h4 class="panel-title  active ">
              <a class="accordion-toggle" href="#collapse1" data-parent="#accordion" data-toggle="collapse">Brand Onboarding <span class="indicator indicator-mimus pe-7s-angle-down"></span></a>
            </h4>
          </div>
          <div class="panel-collapse collapse in" id="collapse1">
           <div class="panel-body"> 
            <p>
            Complete paperless on-boarding of brands, manufacturers and solution providers. submit details and upload documents required and after approval, you will get access of the platform.Fill in your information accurately as it impacts your future communication, billing information and free support.</p>
          </div>
        </div>   
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
         <h4 class="panel-title">
          <a class="accordion-toggle" href="#collapse2" data-parent="#accordion" data-toggle="collapse">Select a subscription plan<span class="indicator pe-7s-angle-down"></span></a>
        </h4>
      </div>
      <div class="panel-collapse collapse " id="collapse2">
       <div class="panel-body">
        <p>
        By default, Free plan will be activated. The FREE plan gives you all the essential features & tools to setup your solution and continue using the platform for a few things / items free forever. You can always upgrade your account to a paid plan if you’re ready to scale beyond the limits of the FREE plan.</p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">  
     <h4 class="panel-title">
      <a class="accordion-toggle" href="#collapse3" data-parent="#accordion" data-toggle="collapse">Manage product, batch and serialisation<span class="indicator pe-7s-angle-down"></span></a> 
    </h4>
  </div>
  <div class="panel-collapse collapse" id="collapse3">
   <div class="panel-body">
    <p>
    Flexible Management of your brand, product, batches  serialization. </p>
  </div>
</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">  
   <h4 class="panel-title">
    <a class="accordion-toggle" href="#collapse4" data-parent="#accordion" data-toggle="collapse">Activate as production goes<span class="indicator pe-7s-angle-down"></span></a> 
  </h4>
</div>
<div class="panel-collapse collapse" id="collapse4">
 <div class="panel-body">
  <p>
  Activate products and keep a track on your raw materials, ingredients, supply chain, shipments, manufacturing batches, product SKUs right down to product level. Thats it</p>
</div>
</div>
</div>
</div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="image-choose wpb_single_image"> 
    <img src="{{asset('web/images/background/bbchain.png')}}" alt="">
  </div>
</div>
</div>
</div>
</div>
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
<div id="pricing_table" class="padding-content pricing-table bg-gray content-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="riven-heading text-center" data-sr="enter bottom wait 0.3s">
         <h2>Pricing <span>Plans</span></h2>
         <p class="text">Our pay as you go pricing plans are driven by usage of platform resources, premium features, support & service levels. Select which suits to you</p>
       </div>
     </div>
     @foreach(getPlan() as $plan)
     <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="pricing-content bg-gradient">
        <div class="box-info">
          <div class="pricing-title text center">
            <h3>{{$plan->title}}</h3>
          </div>
          <div class="price bg-gradient">
            <div class="price-box">
              <div class="price-center">
                <span> 
                  @if ($country=='India')
                  &#8377; {{$plan->price_inr}}
                  @else
                  $ {{$plan->price_usd}}
                  @endif
                </span>
                <p>monthly</p>
              </div>
            </div>
          </div>
          <div class="pricing-desc mb-2">
            {!!$plan->description!!}
          </div>
          <div class="pricing-sign">
            <a class="btn btn-default" href="{{url('register')}}">Sign up</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
</div>


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

          <div class="event-content col-md-6 col-sm-12 col-xs-12">
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
                      26 - 29 April 2022  <br> Brussels Expo
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
              Monotech Systems Ltd.,<br>
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
          <form id="#contact_form" class="wpcf7-form" >
            @csrf
            <div class="contact-form">
              <p class="inner-input mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                  Name
                </label>
                <span class="your-name"><input type="text" id="name" class="contact__input"  name="name" required></span>
                <div id="error-name" class="text-danger contact__input-error mb-3"></div>

              </p>

              <p class="inner-input mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-email">
                  Email
                </label>
                <span class="your-email"><input type="email" id="email"  class="contact__input" name="email" required></span>
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

{{-- <div id="features" class="features padding-content bg-gradient content-section">
  <div class="container">
    <div class="row">
      <div class="title-block">
        <div class="riven-heading text-center text-white" data-sr="enter bottom wait 0.3s">
          <h2>
            About <span> Monotech Systems Limited</span>
          </h2>
        </div>
      </div>
      <div class="features-content">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <ul class="smile_icon_list mt-0 left circle with_bg">
            <li class="icon_list_item" style="margin-bottom: 20px !important;">
              <div class="icon_description">
                <div class="icon_description_text">
                  <p>Monotech Systems Ltd is a leading manufacturer and one-stop solution provider of high end, high performance and reliable products and solutions for the printing, and packaging industry globally. The company represents many world-renowned companies and have pioneered the introduction of modern and innovative technologies to the Printing industry. </p>
                </div>
              </div>
            </li>

            <li class="icon_list_item" style="margin-bottom: 20px !important;">
              <div class="icon_description">
                <div class="icon_description_text">
                  <p>Established in 1999, the company has been consistently achieving sound growth in the business year by year and has become the market leader in its field and in an array of segments. This growth comes from the company’s ardent commitment to customers, genuine intention to succeed, meticulous teamwork, consistent attentiveness to customers and outstanding professionalism. The company is backed by a highly skilled and committed employee base focused on total customer satisfaction by providing efficient, superior products and solutions with customer friendly services. </p>
                </div>
              </div>
            </li>

            <li class="icon_list_item" style="margin-bottom: 20px !important;">
              <div class="icon_description">
                <div class="icon_description_text">
                  <p>Monotech has its corporate and registered office in 8B "Chaitanya Exotica", 24-Venkatnarayana Road, T.Nagar, Chennai - 600017, Tamilnadu, India, +91 44 2815 7928/7894/7933 and has extensive sales and service support across the nation. </p>
                </div>
              </div>
            </li>

            <li class="icon_list_item" style="margin-bottom: 20px !important;">
              <div class="icon_description">
                <div class="icon_description_text">
                  <p>TRACESCI is a trademark product  and a complete Track and Trace Solution by Monotech Systems Limited.</p>
                  <p>For further information please visit <a href="www.monotech.in" target="_blank">www.monotech.in</a></p>
                </div>
              </div>
            </li>
            
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="spacer-100"></div>
</div> --}}

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
</div>  
<x-notification></x-notification>
</div>
@endsection


@section('script')
<script type="text/javascript">
  cash(function () {
    async function contact() {
      cash('.contact__input').removeClass('border-theme-6')
      cash('.contact__input-error').html('')
      cash('#contactError').addClass('hidden')

      let name = cash('#name').val()
      let email = cash('#email').val()
      let mobile = cash('#mobile').val()
      let message = cash('#message').val()

      cash('#contactwait').removeClass('hidden')
      axios.post('{{ url('send_inquiry') }}', {
        name : name , 
        email : email ,
        mobile : mobile,
        message: message
      }).then(res => {
        cash('#contactSuccess').removeClass('hidden')
        cash('#contactError').addClass('hidden')
        cash('#contactwait').addClass('hidden')
        // showNotification('success','Success!',res.data.message)
        setTimeout(()=>{
          window.location.reload()  
        },3000)
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

@endsection

