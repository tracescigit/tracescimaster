@if (request()->route()->uri!='p/{code}')
<a target="_blank" href="https://wa.me/+919999585324" class="whatsapp-button" title="Connect on whatsapp">
  <img src="{{asset('web/images/wa.png')}}" alt="">
</a>
@endif
<!--Footer-->
<style>
  .newsletter-section {
    background: #222222;
    padding: 40px 0;
  }

  .newsletter-wrapper {
    width: 100%;
  }

  .newsletter-content {
    text-align: left;
  }

  .newsletter-wrapper h2 {
    font-size: 28px;
    font-weight: bold;
    color: #ffffff;
    margin-bottom: 10px;
    font-family: 'Raleway', sans-serif;
  }

  .newsletter-wrapper p {
    font-size: 15px;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 0;
    font-family: 'Raleway', sans-serif;
  }

  .newsletter-form {
    position: relative;
    max-width: 450px;
    margin-left: auto;
    margin-right: 0;
  }

  .newsletter-input {
    width: 100%;
    height: 60px;
    border: none;
    border-radius: 0;
    padding: 0 60px 0 25px;
    font-size: 15px;
    color: #777;
    background: #f3f3f3;
    outline: none;
    box-shadow: none;
  }

  .newsletter-input::placeholder {
    color: #999;
  }

  .newsletter-btn {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: 2px solid #cfcfcf;
    background: transparent;
    color: #999;
    font-size: 15px;
    transition: all 0.3s ease;
  }

  .newsletter-btn:hover {
    background: #7a0d7d;
    border-color: #7a0d7d;
    color: #fff;
  }

  #subsmessage {
    text-align: right;
  }

  /* Mobile */
  @media (max-width: 767px) {

    .newsletter-section {
      padding: 50px 20px;
    }

    .newsletter-content {
      text-align: center;
      margin-bottom: 25px;
    }

    .newsletter-wrapper h2 {
      font-size: 32px;
    }

    .newsletter-wrapper p {
      font-size: 16px;
      margin-bottom: 0;
    }

    .newsletter-form {
      max-width: 100%;
      margin: 0 auto;
    }

    .newsletter-input {
      height: 60px;
      font-size: 16px;
      padding: 0 60px 0 20px;
    }

    .newsletter-btn {
      width: 40px;
      height: 40px;
      right: 10px;
      font-size: 18px;
    }

    #subsmessage {
      text-align: center;
    }
  }
</style>

<div class="footer-area">

  <section class="newsletter-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="newsletter-wrapper">
            <div class="row align-items-center">

              <!-- Left Content -->
              <div class="col-lg-6 col-md-6">
                <div class="newsletter-content">
                  <h2>
                    Join Our <span style="color:#7a0d7d;">Newsletter</span>
                  </h2>
                  <p>Get latest news and updates from us</p>
                </div>
              </div>

              <!-- Right Form -->
              <div class="col-lg-6 col-md-6">
                @if (request()->route()->uri!='p/{code}')
                <form class="newsletter-form" style="margin-top: 20px">
                  <input type="email"
                    placeholder="Enter your email"
                    name="email"
                    class="newsletter-input"
                    id="email">

                  <button type="submit" class="newsletter-btn">
                    <i class="fa fa-angle-right"></i>
                  </button>
                </form>

                <div id="subsmessage"
                  class="text-white mt-3">
                </div>
                @endif
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- <div class="footer-main-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-md-3">
          <div class="footer-main-content-inner footer-first-content">
            <h2>About Metrics</h2>
            <ul>
              <li><a href="{{route('about')}}">About Us</a></li>
            </ul>
            <a href="#"><img src="images/logo.png" alt=""></a>
          </div>
        </div>
        <div class="col-sm-6 col-md-2">
          <div class="footer-main-content-inner">
            <h2>Our Products</h2>
            <ul>
              <li><a href="{{ route('home') }}#howitworks">Take The Tour</a></li>
              <li><a href="{{ route('cloud-solution') }}#pricing_table">Plans & Pricing</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-4 col-md-2">
          <div class="footer-main-content-inner">
            <h2>Explore</h2>
            <ul>
              <li><a href="{{route('cloud-solution')}}">Cloud Solution</a></li>
              <li><a href="{{route('enterprise-solution')}}">Enterprise Solution</a></li>
              <li><a href="{{route('home')}}">Custom Solution</a></li>
              <li><a href="{{route('home')}}">Dashboard</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-4 col-md-2">
          <div class="footer-main-content-inner">
            <h2>Need Help</h2>
            <ul>
              <li><a href="{{route('contact-us')}}">Contact Us</a></li>
              <li><a href="{{route('blog')}}">Our Blog</a></li>
              <li><a href="{{ route('home') }}#howitworks">FAQs</a></li>
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
  </div> -->
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="footer-bottom-content clearfix">
            <div class="col-sm-6 col-md-6 no-padding-left">
              <div class="footer-bottom-left">
                <a class="text-white" href="{{ url('/privacy-policy') }}"> Privacy Policy |</a>
                <a class="text-white" href="{{ url('/terms-of-use') }}"> Terms of Use |</a>
                <a class="text-white" href="{{ url('/cancellation-or-refund-policy') }}"> Cancellation/Refund Policy </a>
              </div>
            </div>
            <div class="col-sm-6 col-md-6 no-padding-right">
              <div class="footer-bottom-right">
                <p>© {{$year}}. All rights reserved by <a class="text-white" href="{{route('home')}}">tracesci.</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>