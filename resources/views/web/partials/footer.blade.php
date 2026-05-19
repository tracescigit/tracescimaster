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
    text-align: center;
}

.newsletter-wrapper h2 {
    font-size: 28px;
    font-weight: bold;
    color: #ffffff;
    margin-bottom: 15px;
    font-family: 'Raleway', sans-serif;;
}

.newsletter-wrapper p {
    font-size: 15px;
    color: rgba(255,255,255,0.8);
    margin-bottom: 50px;
    font-family: 'Raleway', sans-serif;
}

.newsletter-form {
    position: relative;
    max-width: 400px;
    margin: 0 auto;
}

.newsletter-input {
    width: 100%;
    height: 60px;
    border: none;
    border-radius: 0px;
    padding: 0 60px 0 40px;
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
    right: 25px;
    transform: translateY(-50%);
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: 2px solid #cfcfcf;
    background: transparent;
    color: #999;
    font-size: 15px;
    transition: 0.3s;
}

.newsletter-btn:hover {
    background: #7a0d7d;
    border-color: #7a0d7d;
    color: #fff;
}

@media (max-width: 767px) {

    .newsletter-section {
        padding: 70px 20px;
    }

    .newsletter-wrapper h2 {
        font-size: 38px;
    }

    .newsletter-wrapper p {
        font-size: 18px;
        margin-bottom: 35px;
    }

    .newsletter-input {
        height: 70px;
        font-size: 18px;
        padding: 0 90px 0 25px;
    }

    .newsletter-btn {
        width: 50px;
        height: 50px;
        right: 12px;
        font-size: 26px;
    }
}


</style>

<div class="footer-area">
  
    <section class="newsletter-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="newsletter-wrapper text-center">

                    <h2>Join Our Newsletter</h2>
                    <p>Get latest news and updates from us</p>

                    @if (request()->route()->uri!='p/{code}')
                    <form class="newsletter-form">
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
                         class="text-center text-white"
                         style="margin-top:20px;">
                    </div>
                    @endif

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
                <a class="text-white" href="{{ url('/about-monotech-systems-limited') }}">About Tracesci Global Pvt Ltd |</a>
                <a class="text-white" href="{{ url('/privacy-policy') }}"> Privacy Policy |</a>
                <a class="text-white" href="{{ url('/terms-of-use') }}"> Terms of Use |</a>
                <a class="text-white" href="{{ url('/cancellation-or-refund-policy') }}"> Cancellation/Refund Policy </a>
              </div>
            </div>
            <div class="col-sm-6 col-md-6 no-padding-right">
              <div class="footer-bottom-right">
                <p>Powered by <a class="text-white" href="{{route('home')}}">tracesci.</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>