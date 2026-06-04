@extends('web.layouts.app')
@section('content')


<!-- =========================
      START PAGE TITLE SECTION
      ============================== -->
<section class="page-title-area blog-standard-area">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        {{--<div class="about-head-content">
          <h2>Blog Single Post</h2>
          <p>Metrics insights & articles, A blog about analytics, marketing & testing</p>
        </div>--}}
        <div class="breadcrumbs text-center">
          <ul class="page-breadcrumbs">
            <li><a href="#">home</a></li>
            <li><a href="#">Blog Details</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- =========================
      END PAGE TITLE SECTION
      ============================== -->

<!-- =========================
        START FULL INTRO SECTION
      ============================== -->
<section class="full-intro-area">
  <div class="container">
    <div class="row">
      @if(!empty($blog))
      <div class="col-md-12">
        <div class="blog-single">
          <div class="full-intro-head text-center">
            <span><i class="fa fa-briefcase"></i></span>
            <h2>{{$blog->title}}</h2>
            <p>
              {{$blog->publish_date ?? '--'}}. By:<span>{{ $blog->publish_by ?? 'Blog Published By' }}</span>
            </p>
          </div>
          <div class="full-intro-img text-center">
            <img src="{{ asset('storage/' . $blog->image_path) }}" alt="Blog Image" class="img-responsive">
          </div>
          <div class="full-intro-content text-left">
            <p>{!! $blog->description ?? 'Blog description'!!}</p>
            <div class="blog-social text-left">
              <p>
                <span>Share This Artcle : </span>
                  <a href="https://www.facebook.com/tracesciSolutions/"><i class="fa fa-facebook"></i></a>
                 <a href="https://in.linkedin.com/company/tracesci-solutions-pvt-ltd"><i class="fa fa-linkedin"></i></a>
                  <a href="https://www.youtube.com/@TracesciGlobal"><i class="fa fa-youtube-play"></i></a>
              </p>
            </div>
          </div>
          {{--<div class="blog-prev-next clearfix">
            <div class="blog-prev">
              <div class="blog-prev-content">
                <p>Previous Post</p>
                <h3>At Last, You Can Now Add Users to Your Pro Account!</h3>
                <div class="prev-left">
                  <a href="#"><img src="images/single-prev.png" alt=""></a>
                </div>
              </div>
            </div>
            <div class="blog-next text-right">
              <div class="blog-next-content">
                <p>Next Post</p>
                <h3>Scraping and Cleaning Your Data with Google Sheets</h3>
                <div class="next-right">
                  <a href="#"><img src="images/single-next.png" alt=""></a>
                </div>
              </div>
            </div>
          </div>--}}
          {{--<div class="sidebar-inner single-blog-author">
            <div class="recent-post single-blog-author-post">
              <div class="blog-social blog-social-2">
                <p>
                  <li class="social-fb first"><a href="https://www.facebook.com/tracesciSolutions/"><i class="fa fa-facebook"></i></a></li>
                  <li class="social-linkedin"><a href="https://in.linkedin.com/company/tracesci-solutions-pvt-ltd"><i class="fa fa-linkedin"></i></a></li>
                  <li class="social-youtube"><a href="https://www.youtube.com/@TracesciGlobal"><i class="fa fa-youtube-play"></i></a></li>
                </p>
              </div>
            </div>
          </div>--}}
         {{-- <div class="sidebar-inner single-blog-author related-post-margin-2">
            <h2>Related Posts</h2>
          </div>
          <div class="col-md-4 blog-single-block no-padding-left b-s-l-p">
            <div class="blog-single-img">
              <img src="images/single-blog-3.png" class="img-responsive" alt="blog-post">
            </div>
            <div class="full-intro-head">
              <p>
                Oct 16, 2015 . <span><a href="#">Business</a></span>
              </p>
              <h2><a href="#">Target Individual Users by Tailoring Your Website !</a></h2>
            </div>
          </div>
          <div class="col-md-4 blog-single-block">
            <div class="blog-single-img">
              <img src="images/single-blog-1.png" class="img-responsive" alt="blog-post">
            </div>
            <div class="full-intro-head">
              <p>
                Oct 16, 2015 . <span><a href="#">Business</a></span>
              </p>
              <h2><a href="#">Why Meaning Will Ultimately Determine Your Brand</a></h2>
            </div>
          </div>
          <div class="col-md-4 blog-single-block no-padding-right b-s-r-p">
            <div class="blog-single-img">
              <img src="images/single-blog-4.png" class="img-responsive" alt="blog-post">
            </div>
            <div class="full-intro-head">
              <p>
                Oct 16, 2015 . <span><a href="#">Business</a></span>
              </p>
              <h2><a href="#">How to Hack the Amplification Process - Whiteboard Friday</a></h2>
            </div>
          </div>
          <div class="sidebar-inner single-blog-author single-blog-reply">
            <h2>3 Comments</h2>
            <div class="recent-post single-blog-author-post single-blog-reply-post">
              <div class="blog-reply-content">
                <h3><a href="#">Mohamed Habaza</a></h3>
                <h4>Jul 8, 2015 - 08:07 pm</h4>
                <p>Perfecting website optimization is already complicated thing, yet venturing to uncharted sees of off page SEO isn't only time consuming yet unbelievably mind racking. However, no matter how I look at it, perfect web optimization is too much for a filler statement.</p>
                <img src="images/blog-author-2.png" alt="">
                <a href="#">Leave A Reply</a>
              </div>
            </div>
            <div class="recent-post single-blog-author-post single-blog-reply-post blog-author-left-margin">
              <div class="blog-reply-content">
                <h3><a href="#">Ahmed Hassan</a></h3>
                <h4>Jul 8, 2015 - 08:07 pm</h4>
                <p>The example about the mattress sizing page you mentioned in the last WBF can be a perfect example of new keywords and content, and broadening the funnel as well. I can only imagine the sale numbers if that was the site of a mattress selling company.</p>
                <img src="images/blog-author-3.png" alt="">
                <a href="#">Leave A Reply</a>
              </div>
            </div>
            <div class="recent-post single-blog-author-post single-blog-reply-post">
              <div class="blog-reply-content b-l-no-border">
                <h3><a href="#">Ahmed Hassan</a></h3>
                <h4>Jul 8, 2015 - 08:07 pm</h4>
                <p>The example about the mattress sizing page you mentioned in the last WBF can be a perfect example of new keywords and content, and broadening the funnel as well. I can only imagine the sale numbers if that was the site of a mattress selling company.</p>
                <img src="images/blog-author-4.png" alt="">
                <a href="#">Leave A Reply</a>
              </div>
            </div>
          </div>
          <div class="sidebar-inner single-blog-author">
            <h2>Leave A Reply</h2>
          </div>
          <div class="blog-reply-form">
            <form>
              <input type="text" class="form-control" id="Name" placeholder="YOUR NAME">
              <input type="email" class="form-control" id="Email" placeholder="EMAIL">
              <input type="text" class="form-control" placeholder="WEBSITE">
              <textarea class="form-control" rows="8" id="Message" placeholder="COMMENT"></textarea>
              <button type="button" id="contact_submit" class="btn btn-dm">Post Your Comment</button>
            </form>
          </div>
        </div>--}}
      </div>
      @endif
    </div>
  </div>
</section>
<!-- =========================
        END FULL INTRO SECTION
      ============================== -->

@endsection