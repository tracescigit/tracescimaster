@if (request()->route()->uri!='p/{code}') 
<a target="_blank" href="https://wa.me/+919999585324" class="whatsapp-button" title="Connect on whatsapp">
  <img src="{{asset('web/images/wa.png')}}" alt="">
</a>
@endif
<!--Footer-->
<footer  id="colophon" class="footer">
  <!-- the footer -->
  <div id="footer" class="footer-v1 bg-gradient">
    <div class="top-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 text-center">
            <aside class="widget">
              <form id="subscribenow" action="{{url('subscribe')}}" method="post">
                <div class="mc4wp-form-fields">
                  <div class="newsletter_1 m-0">
                    @if (request()->route()->uri!='p/{code}')
                    <h2>Join Our <span>Newsletter</span></h2>
                    <p>Get latest news and updates from us</p>
                    @else
                    <h2>Verify product with ease</h2>
                    @endif
                  </div>
                  @if (request()->route()->uri!='p/{code}')
                  <div class="form-newletter">
                    <input type="email" placeholder="Enter your email" name="email" class="input placeholder" id="email">
                    <input type="submit" name="send" value="Submit" class="submit hidden-startup">
                  </div>
                  <div id="subsmessage" class="text-center text-white" style="margin-top: 20px;"></div>
                  @endif
                </div>
              </form>
              <div class="spacer-55"></div>
            </aside>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 text-center">
            <div class="copyright">
              @if (request()->route()->uri!='p/{code}')       
              <address>             
                &copy; Monotech Systems Ltd.  2021. All Rights Reserved. Product by <a target="_blank" href="http://jetsciglobal.com">JETSCI Global</a>                                
              </address>
              <p>
                <a class="text-white" href="{{ url('/about-monotech-systems-limited') }}">About Monotech Systems Limited</a>
                &nbsp;
                <a class="text-white" href="{{ url('/privacy-policy') }}">Privacy Policy</a>
                &nbsp;
                <a class="text-white" href="{{ url('/terms-of-use') }}">Terms of Use</a>
                &nbsp;
                <a class="text-white" href="{{ url('/cancellation-or-refund-policy') }}">Cancellation/Refund Policy</a>
              </p>
              @else
              <address>             
                &copy; Powered by <a href="https://tracesci.in">Tracesci.in</a>                                
              </address>
              @endif
            </div>    
          </div>
        </div>    
      </div>    
    </div>
  </div>
</footer>