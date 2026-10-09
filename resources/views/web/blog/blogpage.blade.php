@extends('web.layouts.app')
@section('content')

<style>
  /* ---- banner: 80% of the screen height instead of 100% ---- */
  .page-title-area.blog-standard-area {
    height: 80vh !important;
    min-height: 80vh !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    display: flex;
    align-items: center;         /* keeps the title vertically centred */
  }

  .page-title-area.blog-standard-area > .container {
    width: 100%;
  }

  /* ---- wider page area: less empty margin on the left and right ---- */
  .blog-page-container {
    width: 100%;
    max-width: 1400px;          /* raise for even less side margin */
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 40px;
  }

  /* ---- 3-column grid, equal-height cards ---- */
  .blog-grid {
    display: flex;
    flex-wrap: wrap;
    margin-top: 40px;
    margin-left: -10px;          /* matches the column padding below */
    margin-right: -10px;
  }

  .blog-grid > [class*="col-"] {
    display: flex;
    margin-bottom: 20px;
    padding-left: 10px;          /* 20px gap between cards (Bootstrap default is 30px) */
    padding-right: 10px;
  }

  .blog-card {
    display: flex;
    flex-direction: column;
    width: 100%;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    transition: transform 0.3s ease;
  }

  .blog-card:hover {
    transform: translateY(-6px);
  }

  /* ---- same-size image for every blog ---- */
  .blog-card-img {
    display: block;
    width: calc(100% - 24px);   /* leaves 12px of padding on each side */
    margin: 12px 12px 0;        /* padding around the image inside the card */
    aspect-ratio: 1 / 1;        /* square - change to 4 / 3 or 16 / 9 if preferred */
    overflow: hidden;
    border-radius: 10px;        /* rounded image corners */
  }

  .blog-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
  }

  .blog-card-body {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 22px;
  }

  .blog-card-date {
    font-size: 13px;
    color: #999;
    margin: 0 0 8px;
  }

  .blog-card-title {
    font-size: 20px;
    font-weight: 700;
    line-height: 1.4;
    margin: 0 0 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;       /* title max 2 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .blog-card-title a {
    color: #111;
  }

  .blog-card-title a:hover {
    color: #7a0d7d;
    text-decoration: none;
  }

  /* ---- description: 3 lines then ... ---- */
  .blog-card-desc {
    color: #666;
    font-size: 15px;
    line-height: 1.7;
    margin: 0 0 12px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .blog-card-author {
    font-size: 13px;
    color: #999;
    margin: 0 0 15px;
  }

  .blog-card-author span {
    color: #7a0d7d;
    margin-left: 4px;
  }

  /* ---- Learn More pinned to bottom of the card ---- */
  .blog-card-link {
    margin-top: auto;
    font-weight: 600;
    color: #7a0d7d;
  }

  .blog-card-link:hover {
    color: #111;
    text-decoration: none;
  }

  .blog-card-link i {
    margin-left: 6px;
    transition: margin-left 0.3s ease;
  }

  .blog-card-link:hover i {
    margin-left: 10px;
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
          <h2>Our Blogs</h2>
          <p>Tracesci insights & articles, A blog about analytics, marketing & testing</p>
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
        START BLOG GRID
      ============================== -->
@if(!empty($blogs) && count($blogs) > 0)
<section class="full-intro-area">
  <div class="container blog-page-container">
    <div class="row blog-grid">

      @foreach($blogs as $blog)
      @php
        $blogUrl = route('blog-details', ['id' => encrypt($blog->id)]);
        $plainDesc = trim(html_entity_decode(strip_tags($blog->description ?? ''), ENT_QUOTES, 'UTF-8'));
      @endphp

      <div class="col-sm-6 col-md-3">
        <div class="blog-card">

          <a href="{{ $blogUrl }}" class="blog-card-img">
            <img src="{{ asset('storage/' . $blog->image_path) }}" alt="{{ $blog->title ?? 'Blog image' }}">
          </a>

          <div class="blog-card-body">
            <p class="blog-card-date">{{ $blog->publish_date ?? '--' }}</p>

            <h3 class="blog-card-title">
              <a href="{{ $blogUrl }}">{{ $blog->title ?? 'Blog Title' }}</a>
            </h3>

            <p class="blog-card-desc">{{ $plainDesc !== '' ? $plainDesc : 'Blog description' }}</p>

            <p class="blog-card-author">By:<span>{{ $blog->publish_by ?? 'Blog Published By' }}</span></p>

            <a href="{{ $blogUrl }}" class="blog-card-link">Learn More <i class="fa fa-long-arrow-right"></i></a>
          </div>

        </div>
      </div>
      @endforeach

    </div>

    {{--<div class="row">
      <div class="col-md-12 matrics-pagination matrics-blog-pagination text-center clearfix">
        <nav>
          <ul class="pagination">
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li>
              <a href="#" aria-label="Next">
                <i class="fa fa-angle-right"></i>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>--}}
  </div>
</section>
@endif
<!-- =========================
        END BLOG GRID
      ============================== -->

@endsection