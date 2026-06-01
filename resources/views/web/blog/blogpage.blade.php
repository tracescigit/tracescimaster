@extends('web.layouts.app')
@section('content')

<!-- =========================
      START PAGE TITLE SECTION
      ============================== -->
<section class="page-title-area blog-standard-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="about-head-content">
                    <h2>Our Blog</h2>
                    <p>Tracesci insights & articles, A blog about analytics, marketing & testing</p>
                </div>
                <div class="breadcrumbs text-center">
                    <ul class="page-breadcrumbs">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="#">Blog</a></li>
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
@if(!empty($blogs) && count($blogs) > 0)
<section class="full-intro-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 no-padding text-left">
                <div class="blog-2-column-left-content">
                    @foreach($blogs as $index => $blog)
                    @if($index == 6)
                    @break
                    @endif
                    <div class="col-sm-6 col-md-4">
                        <div class="blog-2-column-content">
                            <a href="{{ route('blog-details', ['id' => encrypt($blog->id)]) }}">
                                <div class="full-intro-img">
                                    <img src="{{ asset('storage/' . $blog->image_path) }}" alt="" class="Blog-Image">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        {{$blog->publish_date ?? '--'}}.
                                    </p>
                                    <h3>{{ $blog->title ?? 'Blog Title' }}</h3>
                                </div>
                                <div class="full-intro-content">
                                    <p>{{!! $blog->description ?? 'Blog description'!!}}</p>
                                    <p>
                                        By:<span>{{ $blog->publish_by ?? 'Blog Published By' }}</span>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                    <!-- <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-2.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 15, 2015 . <span><a href="#">Tools, News</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">At Last, You Can Now Add Users to Your Pro Account!</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>How would you like to leave work early on Fridays? Raven’s set-it-and-forget-it reports prove to be a major time saver for this marketing agency.With the ability to show progress.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-2.png')}}" alt="">By:<span><a href="#"> Ahmed Ali</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-3.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 15, 2015 . <span><a href="#">Tools, News</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">At Last, You Can Now Add Users to Your Pro Account!</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>We all know that no user is the same. Aside from the basics such as age, gender, socio-economic background and so every person differs in life experiences, interests, and preferences.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-2.png')}}" alt="">By:<span><a href="#"> Ahmed Ali</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-1.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 30, 2015 . <span><a href="#">Tools, Videos</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">How to Hack the Amplification Process - Whiteboard Friday</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>How would you like to leave work early on Fridays? Raven’s set-it-and-forget-it reports prove to be a major time saver for this marketing agency.With the ability to show</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-3.png')}}" alt="">By:<span><a href="#"> Ahmed Ebraheem</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-4.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 30, 2015 . <span><a href="#">Tools, Videos</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">Google Glossary: Revenge of Mega-SERP</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>We all know that no user is the same. Aside from the basics such as age, gender, socio-economic background and so every person differs in life experiences, interests, and preferences.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-3.png')}}" alt="">By:<span><a href="#"> Ahmed Ebraheem</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-5.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 30, 2015 . <span><a href="#">Tools, Videos</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">Why Meaning Will Ultimately Determine Your Brand</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>We all know that no user is the same. Aside from the basics such as age, gender, socio-economic background and so every person differs in life experiences, interests, and preferences.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-3.png')}}" alt="">By:<span><a href="#"> Ahmed Emad</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-1.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 16, 2015 . <span><a href="#">Business</a></span>. Comments : <span><a href="#">80</a></span>
                                    </p>
                                    <h2><a href="#">Beyond the SEO: After Optimizing Your Website</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>We all know that no user is the same. Aside from the basics such as age, gender, socio-economic background and so every person differs in life experiences, interests, and preferences.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-1.png')}}" alt="">By:<span><a href="#"> Ahmed Ebraheem</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-2.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 15, 2015 . <span><a href="#">Tools, News</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">At Last, You Can Now Add Users to Your Pro Account!</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>How would you like to leave work early on Fridays? Raven’s set-it-and-forget-it reports prove to be a major time saver for this marketing agency.With the ability to show progress</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-2.png')}}" alt="">By:<span><a href="#"> Ahmed Ali</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-4.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 30, 2015 . <span><a href="#">Tools, Videos</a></span>. Comments : <span><a href="#">70</a></span>
                                    </p>
                                    <h2><a href="#">Google Glossary: Revenge of Mega-SERP</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>We all know that no user is the same. Aside from the basics such as age, gender, socio-economic background and so every person differs in life experiences, interests, and preferences.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-3.png')}}" alt="">By:<span><a href="#"> Ahmed Ebraheem</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="blog-2-column-content">
                                <div class="full-intro-img">
                                    <img src="{{asset('dist/images/single-blog-1.png')}}" alt="" class="img-responsive">
                                </div>
                                <div class="full-intro-head">
                                    <p>
                                        Oct 16, 2015 . <span><a href="#">Business</a></span>. Comments : <span><a href="#">80</a></span>
                                    </p>
                                    <h2><a href="#">Beyond the SEO: After Optimizing Your Website</a></h2>
                                </div>
                                <div class="full-intro-content">
                                    <p>We all know that no user is the same. Aside from the basics such as age, gender, socio-economic background and so every person differs in life experiences, interests, and preferences.</p>
                                    <p>
                                        <img src="{{asset('dist/images/blog-user-1.png')}}" alt="">By:<span><a href="#"> Ahmed Ebraheem</a></span>
                                    </p>
                                </div>
                            </div>
                        </div> -->
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
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@endsection