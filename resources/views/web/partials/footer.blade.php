@if (request()->route()->uri!='p/{code}')
<a target="_blank" href="https://wa.me/+919999585324" class="whatsapp-button" title="Connect on whatsapp">
  <img src="{{asset('web/images/wa.png')}}" alt="">
</a>
@endif
<!--Footer-->

<div class="footer-area">
  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="join-team footer-subscribe clearfix">
            <div class="col-md-7">
              <p>Our social marketing solutions help more than 2500 companies around the world deliver great results. We can't stand average, and our clients can't either.</p>
            </div>
            <div class="col-md-5">
              <div class="all-link pricinig-head-btn footer-top-btn">
                <a href="#">Take The Tour</a>
                <a href="#">Get Started</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-main-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-md-3">
          <div class="footer-main-content-inner footer-first-content">
            <h2>About Metrics</h2>
            <ul>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Careers</a></li>
              <li><a href="#">In the Press</a></li>
              <li><a href="#">Marketing Reports</a></li>
              <li><a href="#">SEO Tools</a></li>
            </ul>
            <a href="#"><img src="images/logo.png" alt=""></a>
          </div>
        </div>
        <div class="col-sm-6 col-md-2">
          <div class="footer-main-content-inner">
            <h2>Our Products</h2>
            <ul>
              <li><a href="#">Take The Tour</a></li>
              <li><a href="#">Plans & Pricing</a></li>
              <li><a href="#">Influencer Marketing</a></li>
              <li><a href="#">Social Media Monitoring</a></li>
              <li><a href="#">Free Tools</a></li>
              <li><a href="#">API</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-4 col-md-2">
          <div class="footer-main-content-inner">
            <h2>Explore</h2>
            <ul>
              <li><a href="#">Free Tools</a></li>
              <li><a href="#">Find Influencers By Skill</a></li>
              <li><a href="#">PDF Social Analysis</a></li>
              <li><a href="#">Dashboard</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-4 col-md-2">
          <div class="footer-main-content-inner">
            <h2>Need Help</h2>
            <ul>
              <li><a href="#">Contact Us</a></li>
              <li><a href="#">Our Blog</a></li>
              <li><a href="#">Metrics Help Desk</a></li>
              <li><a href="#">Metrics System Status</a></li>
              <li><a href="#">FAQs</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-4 col-md-3">
          <div class="footer-main-content-inner footer-last-content">
            <h2>Newsletter</h2>
            <ul>
              <li><a href="#">Don’t miss to subscribe to our news feeds,</a></li>
              <li><a href="#">kindly fill the form below.</a></li>
            </ul>
            <form>
              @if (request()->route()->uri!='p/{code}')
              <div class="form-group footer-subscription">
                <input type="email" placeholder="Enter your email" name="email" class="form-control" id="email">
                <input type="submit" name="send" value="Submit" class="btn btn-default">
              </div>
              <div id="subsmessage" class="text-center text-white" style="margin-top: 20px;"></div>
              @endif
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="footer-bottom-content clearfix">
            <div class="col-sm-6 col-md-6 no-padding-left">
              <div class="footer-bottom-left">
                <a class="text-white" href="{{ url('/about-monotech-systems-limited') }}">About Tracesci Global Pvt Ltd |</a>
                <a class="text-white" href="{{ url('/privacy-policy') }}"> Privacy Policy |</a>
                <a class="text-white" href="{{ url('/terms-of-use') }}"> Terms of Use |</a>
                <a class="text-white" href="{{ url('/cancellation-or-refund-policy') }}"> Cancellation/Refund Policy </a>
              </div>
            </div>
            <div class="col-sm-6 col-md-6 no-padding-right">
              <div class="footer-bottom-right">
                <p>Powered by <a class="text-white" href="https://tracesci.in">tracesci.</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>