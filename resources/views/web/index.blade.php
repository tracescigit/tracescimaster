@extends('web.layouts.app')
@section('content')

<!-- slider -->

<div class="rev_slider_wrapper" style="overflow: visible; height: 825px;">
  <div id="slider1" class="rev_slider" data-version="5.0" style="margin-top: 0px; margin-bottom: 0px; height: 825px;">
    <ul class="tp-revslider-mainul" style="visibility: visible; display: block; overflow: hidden; width: 100%; height: 100%; max-height: none; left: 0px;">
      <li data-index="rs-6" data-transition="parallaxtoright" data-slotamount="default" data-easein="default" data-easeout="default" data-masterspeed="default" data-delay="6510" data-rotate="0" data-saveperformance="off" data-title="1/3" data-description="" class="tp-revslider-slidesli active-revslide" style="width: 100%; height: 100%; overflow: hidden; z-index: 20; visibility: inherit; opacity: 1; background-color: rgba(255, 255, 255, 0);">
        <!-- MAIN IMAGE -->
        <div class="slotholder" style="width: 100%; height: 100%; visibility: inherit; opacity: 1; transform: matrix(1, 0, 0, 1, 0, 0);"><!--Runtime Modification - Img tag is Still Available for SEO Goals in Source - <img src="images/slide1.png" alt="" width="1920" height="1080" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="2" class="rev-slidebg defaultimg">-->
          <div class="tp-dottedoverlay twoxtwo"></div>
          <div class="tp-bgimg defaultimg" style="background-color: rgba(0, 0, 0, 0); background-repeat: no-repeat; background-image: url('{{asset("dist/images/slide1.png")}}'); background-size: cover; background-position: center center; width: 100%; height: 100%; opacity: 1; visibility: inherit; z-index: 20;" src="{{asset("dist/images/slide1.png")}}"></div>
        </div>
        <!-- LAYER NR. 1 -->
        <div class="tp-parallax-wrap" style="position: absolute; visibility: visible; left: 607px; top: 323px; z-index: 5;">
          <div class="tp-loop-wrap" style="position:absolute;">
            <div class="tp-mask-wrap" style="position: absolute; overflow: visible; height: auto; width: auto;">
              <div class="tp-caption tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['325','325','325','325']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="x:-50px;opacity:0;s:500;e:Power2.easeInOut;" data-transform_out="x:50px;opacity:0;s:500;s:500;" data-start="1200" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 5; white-space: nowrap; font-size: 17px; line-height: 28px; font-weight: 400; color: rgb(71, 71, 71); font-family: Lora; visibility: inherit; transition: none; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;">
                <span class="sl-italic" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">Informed decisions. Exceptional results</span>
              </div>
            </div>
          </div>
        </div>
        <!-- LAYER NR. 2 -->
        <div class="tp-parallax-wrap" style="position: absolute; visibility: visible; left: 443px; top: 368px; z-index: 6;">
          <div class="tp-loop-wrap" style="position:absolute;">
            <div class="tp-mask-wrap" style="position: absolute; overflow: hidden; transform: matrix(1, 0, 0, 1, 0, 0); height: auto; width: auto;">
              <div class="tp-caption Fashion-BigDisplay tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['370','370','370','370']" data-width="none" data-height="none" data-whitespace="nowrap" data-fontsize="['50','40','40','25']" data-lineheight="['58','40','40','30']" data-transform_idle="o:1;" data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" data-start="1800" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap; font-size: 50px; line-height: 58px; font-weight: 800; color: rgb(34, 34, 34); visibility: inherit; transition: none; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;">
                <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">We Measure The Social Web</div>
              </div>
            </div>
          </div>
        </div>
        <!-- LAYER NR. 3 -->
        <div class="tp-parallax-wrap" style="position: absolute; visibility: visible; left: 495px; top: 457px; z-index: 7;">
          <div class="tp-loop-wrap" style="position:absolute;">
            <div class="tp-mask-wrap" style="position: absolute; overflow: visible; height: auto; width: auto;">
              <div class="tp-caption tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['460','460','460','460']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="x:-50px;opacity:0;s:500;e:Power2.easeInOut;" data-transform_out="x:50px;opacity:0;s:500;s:500;" data-start="2400" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap; font-size: 17px; line-height: 28px; font-weight: 400; color: rgb(71, 71, 71); font-family: Lora; visibility: inherit; transition: none; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;">
                <div class="sl-italic sl-italic-2 text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
                  Our strategists will help you set an objective and choose your tools,<br style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 17px;">
                  developing a plan that is custom-built for your business.
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- LAYER NR. 4 -->
        <div class="tp-parallax-wrap" style="position: absolute; visibility: visible; left: 531px; top: 532px; z-index: 7;">
          <div class="tp-loop-wrap" style="position:absolute;">
            <div class="tp-mask-wrap" style="position: absolute; overflow: visible; height: auto; width: auto;">
              <div class="tp-caption tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['535','535','585','585']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-start="2800" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap; font-weight: 600; padding: 18px 50px; visibility: inherit; transition: none; line-height: 20px; border-width: 0px; margin: 0px; letter-spacing: 0px; font-size: 14px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;">
                <div class="rev-slider-btn text-center" style="transition: none; line-height: 20px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 600; font-size: 14px;"><a href="#" style="transition: none; line-height: 20px; border-width: 1px; margin: 0px; padding: 14px 45px; letter-spacing: 0px; font-weight: 700; font-size: 13px;">Read More </a><a href="#" style="transition: none; line-height: 20px; border-width: 1px; margin: 0px; padding: 14px 45px; letter-spacing: 0px; font-weight: 700; font-size: 13px;">Get Started</a></div>
              </div>
            </div>
          </div>
        </div>
      </li>
      <li data-index="rs-7" data-transition="parallaxtoright" data-slotamount="default" data-easein="default" data-easeout="default" data-masterspeed="default" data-delay="6500" data-rotate="0" data-saveperformance="off" data-title="2/3" data-description="" class="tp-revslider-slidesli" style="width: 100%; height: 100%; overflow: hidden; z-index: 18; visibility: hidden; opacity: 0; background-color: rgba(255, 255, 255, 0);">
        <!-- MAIN IMAGE -->
        <div class="slotholder" style="width: 100%; height: 100%; visibility: inherit; opacity: 1; transform: matrix(1, 0, 0, 1, 0, 0);"><!--Runtime Modification - Img tag is Still Available for SEO Goals in Source - <img src="images/slide2.png" alt="" width="1920" height="1080" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="2" class="rev-slidebg defaultimg">-->
          <div class="tp-dottedoverlay twoxtwo"></div>
          <div class="tp-bgimg defaultimg" style="background-color: rgba(0, 0, 0, 0); background-repeat: no-repeat; background-image: url('{{asset("dist/images/slide1.png")}}'); background-size: cover; background-position: center center; width: 100%; height: 100%; opacity: 0; visibility: hidden; z-index: 20;" src="{{asset("dist/images/slide1.png")}}"></div>
        </div><!-- LAYER NR. 1 -->
        <div class="tp-parallax-wrap" style="position: absolute; visibility: hidden; left: 701px; top: 268px; z-index: 5;">
          <div class="tp-loop-wrap" style="position:absolute;">
            <div class="tp-mask-wrap" style="position: absolute; overflow: visible; height: auto; width: auto;">
              <div class="tp-caption Fashion-BigDisplay tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['270','270','270','270']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:-50px;opacity:0;s:500;e:Power2.easeInOut;" data-transform_out="y:-50px;opacity:0;s:500;s:500;" data-start="1200" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 5; white-space: nowrap; font-size: 17px; line-height: 28px; font-weight: 400; color: rgb(71, 71, 71); font-family: Lora; visibility: hidden; transition: none; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 0; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, -49.6988, 0, 1); transform-origin: 50% 50% 0px;">
                <img src="images/logo-type-2.png" alt="" width="120" height="78" data-ww="['120pxpx','120pxpx','120pxpx','120pxpx']" data-hh="['78px','78px','78px','78px']" data-no-retina="" style="width: 119.277px; height: 77.5301px; transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 400; font-size: 17px;">
              </div>
            </div>
          </div>
        </div>
        <!-- LAYER NR. 2 -->
        <div class="tp-parallax-wrap" style="position: absolute; visibility: hidden; left: 397px; top: 368px; z-index: 6;">
          <div class="tp-loop-wrap" style="position:absolute;">
            <div class="tp-mask-wrap" style="position: absolute; overflow: visible; height: auto; width: auto;">
              <div class="tp-caption Fashion-BigDisplay tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['370','370','370','370']" data-width="none" data-height="none" data-whitespace="nowrap" data-fontsize="['50','40','40','25']" data-lineheight="['58','40','40','30']" data-transform_idle="o:1;" data-transform_in="y:-30px;rX:70deg;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-start="1800" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap; font-size: 50px; line-height: 58px; font-weight: 800; color: rgb(34, 34, 34); visibility: hidden; transition: none; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;">
                <div class="text-center heading-rp-small" style="transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 800; font-size: 50px;">We Are Helpers, We Are Metrics</div>
              </div>
            </div>
          </div>
        </div>
        <!-- LAYER NR. 3 -->
        <div class="tp-parallax-wrap" style="position: absolute; visibility: hidden; left: 478px; top: 457px; z-index: 7;">
          <div class="tp-loop-wrap" style="position:absolute;">
            <div class="tp-mask-wrap" style="position: absolute; overflow: visible; height: auto; width: auto;">
              <div class="tp-caption Fashion-BigDisplay tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['460','460','460','460']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="x:-50px;opacity:0;s:500;e:Power2.easeInOut;" data-transform_out="x:50px;opacity:0;s:500;s:500;" data-start="2400" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap; font-size: 17px; line-height: 28px; font-weight: 400; color: rgb(71, 71, 71); font-family: Lora; visibility: hidden; transition: none; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 0; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 49.6988, 0, 0, 1); transform-origin: 50% 50% 0px;">
                <div class="sl-italic sl-italic-2 text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 400; font-size: 17px;">
                  We are here to provide powerful digital marketing solutions to small and <br style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 400; font-size: 17px;">
                  medium businesses that are looking to build success online.
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- LAYER NR. 4 -->
        <div class="tp-parallax-wrap" style="position: absolute; visibility: hidden; left: 601px; top: 532px; z-index: 7;">
          <div class="tp-loop-wrap" style="position:absolute;">
            <div class="tp-mask-wrap" style="position: absolute; overflow: visible; height: auto; width: auto;">
              <div class="tp-caption tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['535','535','535','535']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="x:50px;opacity:0;s:500;e:Power2.easeInOut;" data-transform_out="x:-50px;opacity:0;s:500;s:500;" data-start="3000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap; font-weight: 600; padding: 20px 50px; visibility: hidden; transition: none; line-height: 20px; border-width: 0px; margin: 0px; letter-spacing: 0px; font-size: 14px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 0; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -49.6988, 0, 0, 1); transform-origin: 50% 50% 0px;">
                <div class="rev-slider-btn rev-slider-btn-3 text-center" style="transition: none; line-height: 20px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 600; font-size: 14px;"><a href="#" style="transition: none; line-height: 20px; border-width: 1px; margin: 0px; padding: 14px 45px; letter-spacing: 0px; font-weight: 700; font-size: 13px;">Get Started Now</a></div>
              </div>
            </div>
          </div>
        </div>
      </li>
      <li data-index="rs-14" data-transition="parallaxtoleft" data-slotamount="default" data-easein="default" data-easeout="default" data-masterspeed="default" data-delay="6510" data-rotate="0" data-saveperformance="off" data-title="3/3" data-description="" class="tp-revslider-slidesli" style="width: 100%; height: 100%; overflow: hidden; z-index: 18; visibility: hidden; opacity: 0; background-color: rgba(255, 255, 255, 0);">
        <!-- MAIN IMAGE -->
        <div class="slotholder" style="width: 100%; height: 100%; visibility: inherit; opacity: 1; transform: matrix(1, 0, 0, 1, 0, 0);"><!--Runtime Modification - Img tag is Still Available for SEO Goals in Source - <img src="images/slide3.png" alt="" width="1920" height="1080" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="2" class="rev-slidebg defaultimg">-->
          <div class="tp-dottedoverlay twoxtwo"></div>
          <div class="tp-bgimg defaultimg" style="background-color: rgba(0, 0, 0, 0); background-repeat: no-repeat; background-image: url('{{asset("dist/images/slide1.png")}}'); background-size: cover; background-position: center center; width: 100%; height: 100%; opacity: 0; visibility: hidden; z-index: 20;" src="{{asset("dist/images/slide1.png")}}"></div>
        </div>

        <!-- LAYER NR. 1 -->
        <div class="tp-parallax-wrap" style="position: absolute; visibility: hidden; left: 652px; top: 323px; z-index: 5;">
          <div class="tp-loop-wrap" style="position:absolute;">
            <div class="tp-mask-wrap" style="position: absolute; overflow: visible; transform: translate3d(0px, 0px, 0px); height: auto; width: auto;">
              <div class="tp-caption Fashion-BigDisplay tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['325','325','325','325']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="z:0;rX:0deg;rY:0;rZ:0;sX:2;sY:2;skX:0;skY:0;opacity:0;s:1000;e:Power2.easeOut;" data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" data-start="700" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 5; white-space: nowrap; font-size: 17px; line-height: 28px; font-weight: 400; color: rgb(71, 71, 71); font-family: Lora; visibility: hidden; transition: none; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 0.998479; transform: matrix3d(1.00152, 0, 0, 0, 0, 1.00152, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;">
                <span class="sl-italic" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 400; font-size: 17px;">Start growing your business</span>
              </div>
            </div>
          </div>
        </div>
        <!-- LAYER NR. 2 -->
        <div class="tp-parallax-wrap" style="position: absolute; visibility: hidden; left: 445px; top: 368px; z-index: 6;">
          <div class="tp-loop-wrap" style="position:absolute;">
            <div class="tp-mask-wrap" style="position: absolute; overflow: visible; height: auto; width: auto;">
              <div class="tp-caption Fashion-BigDisplay tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['370','370','370','370']" data-width="none" data-height="none" data-whitespace="nowrap" data-fontsize="['50','40','40','25']" data-lineheight="['58','40','40','30']" data-transform_idle="o:1;" data-transform_in="z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;s:1000;e:Power2.easeOut;" data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" data-start="1200" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap; font-weight: 800; color: rgb(34, 34, 34); visibility: hidden; transition: none; line-height: 58px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-size: 50px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 0.767392; transform: matrix3d(0.976739, 0, 0, 0, 0, 0.976739, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;">
                Research. Puplish . Measure
              </div>
            </div>
          </div>
        </div>
        <!-- LAYER NR. 3 -->
        <div class="tp-parallax-wrap" style="position: absolute; visibility: hidden; left: 482px; top: 457px; z-index: 7;">
          <div class="tp-loop-wrap" style="position:absolute;">
            <div class="tp-mask-wrap" style="position: absolute; overflow: visible; height: auto; width: auto;">
              <div class="tp-caption Fashion-BigDisplay tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['460','460','490','490']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="x:-50px;opacity:0;s:500;e:Power2.easeInOut;" data-transform_out="x:50px;opacity:0;s:500;s:500;" data-start="1500" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap; font-size: 17px; line-height: 28px; font-weight: 400; color: rgb(71, 71, 71); font-family: Lora; visibility: hidden; transition: none; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 0; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 49.6988, 0, 0, 1); transform-origin: 50% 50% 0px;">
                <div class="sl-italic sl-italic-2 text-center" style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 400; font-size: 17px;">
                  Research influencers, manage your relationships, and conduct outreach <br style="transition: none; line-height: 28px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 1px; font-weight: 400; font-size: 17px;">
                  that’s personalized and efficient.
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- LAYER NR. 4 -->
        <div class="tp-parallax-wrap" style="position: absolute; visibility: hidden; left: 601px; top: 532px; z-index: 7;">
          <div class="tp-loop-wrap" style="position:absolute;">
            <div class="tp-mask-wrap" style="position: absolute; overflow: visible; height: auto; width: auto;">
              <div class="tp-caption tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['535','535','585','585']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-start="2000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap; font-weight: 600; padding: 20px 50px; visibility: hidden; transition: none; line-height: 20px; border-width: 0px; margin: 0px; letter-spacing: 0px; font-size: 14px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 0; transform-origin: 50% 50% 0px; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);">
                <div class="rev-slider-btn rev-slider-btn-2 text-center" style="transition: none; line-height: 20px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 600; font-size: 14px;"><a href="#" style="transition: none; line-height: 20px; border-width: 1px; margin: 0px; padding: 14px 45px; letter-spacing: 0px; font-weight: 700; font-size: 13px;">Get Started Now</a></div>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
  <!-- END REVOLUTION SLIDER -->
</div>
<!-- the content -->
<section class="welcome-area">
  <!-- MAIN TITLE AREA -->
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="main-title wow zoomIn">
          <div class="main-shadow-heading">
            <h2>Hello, We Are Metrics</h2>
          </div>
          <h2>Hello, We Are Metrics</h2>
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

  <!-- features -->

  <section class="solution-area">
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
  








    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <div class="main-title wow zoomIn">
            <div class="main-shadow-heading">
              <h2>How it works? Let Us Help</h2>
            </div>
            <h2>How it works? Let Us Help</h2>
            <h3>Trusted By The Best Marketers</h3>
          </div>
        </div>
      </div>
    </div>




    <!--how it works -->
    <div id="howitworks" class="choose-riven">
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
                      Flexible Management of your brand, product, batches serialization. </p>
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
        <img src="images/pricing-table-self.png" alt="" class="img-responsive">
      </div>
    </section>
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
  </section>
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

  @endsection