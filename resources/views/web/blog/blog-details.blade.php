@extends('web.layouts.app')
@section('content')

<style>
  /* ---- banner: 80% of the screen height ---- */
  .page-title-area.blog-standard-area {
    height: 80vh !important;
    min-height: 80vh !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    display: flex;
    align-items: center;         /* keeps the breadcrumbs vertically centred */
  }

  .page-title-area.blog-standard-area > .container {
    width: 100%;
  }

  .blog-split {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
  }

  .blog-split-img {
    --blog-img-size: 40vh;            /* square size - change to 4vh if needed */
    width: var(--blog-img-size);
    max-width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    margin: 0 auto;
    border-radius: 12px;
  }

  .blog-split-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
  }

  .blog-split .full-intro-head h2 {
    margin-top: 0;
  }
  .full-intro-area {
  padding-top: 60px !important;
  padding-bottom: 60px;
}

  /* ---- shift image 20% further left on desktop ---- */
  @media (min-width: 992px) {
    .blog-split-img {
      transform: translateX(-20%);
    }
  }

  /* ---- description wrapped in big faded inverted commas ---- */
  .blog-quote {
    margin: 10px 0 30px;
  }

  /* text at full strength - only the quote marks are faded */
  .blog-quote,
  .blog-quote p,
  .blog-quote li,
  .blog-quote span:not(.quote-mark) {
    color: #222 !important;
    opacity: 1 !important;
  }

  .blog-quote .quote-mark {
    font-family: Georgia, "Times New Roman", serif;
    font-size: 4em;
    line-height: 0;              /* stops the mark from pushing lines apart */
    font-style: normal;
    color: #7a0d7d;
    opacity: 0.25;
    vertical-align: -0.4em;
    user-select: none;
  }

  .blog-quote .quote-open {
    margin-right: 6px;
  }

  .blog-quote .quote-close {
    margin-left: 4px;
  }

  @media (max-width: 991px) {
    .blog-split-img {
      margin-bottom: 30px;
    }
  }

</style>

<!-- =========================
      START PAGE TITLE SECTION
      ============================== -->
<section class="page-title-area blog-standard-area">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="about-head-content">
          <h2>Blog Details</h2>
          <p></p>
        </div>
        <!-- <div class="breadcrumbs text-center">
          <ul class="page-breadcrumbs">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="#">Blog</a></li>
          </ul>
        </div> -->
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
    @if(!empty($blog))
    <div class="row blog-split">

      <!-- LEFT: IMAGE -->
      <div class="col-md-6 col-sm-12">
        <div class="blog-split-img">
          <img src="{{ asset('storage/' . $blog->image_path) }}" alt="{{ $blog->title }}">
        </div>
      </div>

      <!-- RIGHT: CONTENT -->
      <div class="col-md-6 col-sm-12">
        <div class="blog-single">
          <div class="full-intro-head text-left">
            <h2>{{ $blog->title }}</h2>
            <p>
              {{ $blog->publish_date ?? '--' }}. By: <span>{{ $blog->publish_by ?? 'Blog Published By' }}</span>
            </p>
          </div>

          <div class="full-intro-content text-left">
            @php
              $openMark  = '<span class="quote-mark quote-open">&ldquo;</span>';
              $closeMark = '<span class="quote-mark quote-close">&rdquo;</span>';
              $desc = trim($blog->description ?? 'Blog description');

              // put the opening mark right before the first word
              if (preg_match('/^\s*<(p|div|h[1-6])\b[^>]*>/i', $desc, $m)) {
                  $desc = substr_replace($desc, $m[0] . $openMark, 0, strlen($m[0]));
              } else {
                  $desc = $openMark . $desc;
              }

              // put the closing mark right after the last word
              if (preg_match('/<\/(p|div|h[1-6])>\s*$/i', $desc, $m, PREG_OFFSET_CAPTURE)) {
                  $desc = substr_replace($desc, $closeMark, $m[0][1], 0);
              } else {
                  $desc = $desc . $closeMark;
              } 
            @endphp

            <div class="blog-quote">
              {!! $desc !!}
            </div>

            <div class="blog-social text-left">
              <p>
                <span>Share This Article : </span>
                <a href="https://www.facebook.com/tracesciSolutions/"><i class="fa fa-facebook"></i></a>
                <a href="https://in.linkedin.com/company/tracesci-solutions-pvt-ltd"><i class="fa fa-linkedin"></i></a>
                <a href="https://www.youtube.com/@TracesciGlobal"><i class="fa fa-youtube-play"></i></a>
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>
    @endif
  </div>
</section>
<!-- =========================
        END FULL INTRO SECTION
      ============================== -->

@endsection