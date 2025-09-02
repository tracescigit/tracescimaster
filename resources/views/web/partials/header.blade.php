<header id="masthead" class="site-header header-v1">
  <div class="header-top">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <h1 class="header-logo {{request()->route()->uri!='p/{code}'?'':'w-100 brand-logo'}}">
            
              @if (request()->route()->uri!='p/{code}')
              <a href="{{ url('/') }}" rel="home" style="padding-right: 5px !important;">
              <img width="30%"  alt="Tracesci" src="{{asset('web/images/logo.png')}}" class=""></a>
              @else
              <span class="text-white">{{$brand}}</span>
              @endif
            </h1>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">     
            @if (request()->route()->uri!='p/{code}')
            <nav id="site-navigation" class="main-navigation">
              <button class="menu-toggle"><i class="fa fa-bars"></i> <span> Explore</span></button>
              <div class="menu-onepage-applanding-container">
                <ul id="menu-onepage-applanding" class="mega-menu">
                  <li class="menu-item current-menu-parent menu-item-has-children page_item_has_children">
                    <a href="{{ url('/') }}">Home</a>
                  </li>
                  
                  <li class="menu-item"><a href="#howitworks">Solution</a>
                    <span aria-expanded="true" role="menubar" data-toggle="dropdown" class="dropdown-toggle caret"><i class="fa fa-chevron-down"></i></span>
                    <ul class="children dropdown-menu">
                      <li class="menu-item current-menu-item current_page_item">
                        <a href="#howitworks">How it works</a>
                      </li>
                      <li class="menu-item current-menu-item current_page_item">
                        <a href="#features">Features</a>
                      </li>
                      <li class="menu-item current-menu-item current_page_item">
                        <a href="#application">Applications</a>
                      </li>
                      <li class="menu-item">
                        <a href="#event_calendar">Events</a>
                      </li>
                    </ul>
                  </li>
                  
                  <li class="menu-item"><a href="#pricing_table">Pricing Plan</a></li>
                  <li class="menu-item"><a href="#get_in_touch">Get In Touch</a></li>
                  <li class="menu-item"><a href="{{ url(Auth::check()?myDashboard():'/login') }}">{{ Auth::check()?'Dashboard':'Login' }}</a></li>
                </ul>
              </div>
            </nav>
            @endif

          </div>
        </div>
      </div>    
    </div>

    @if (request()->route()->uri!='p/{code}')       
    <div class="header-sticky">
      <div class="container">
        <div class="row">
          <div class="col-md-2 col-sm-1 col-xs-6"> 
            <div class="header-sticky-logo">
              <a href="{{ url('/') }}" rel="home"><img width="120"  alt="Riven" src="{{asset('dist/images/logo_color.png')}}" class=""></a>
            </div>
          </div>
          <div class="col-md-10 col-sm-11 col-xs-6">
            <nav class="main-navigation" id="sticky-navigation">
              <div class="menu-onepage-applanding-container">
                <ul class="mega-menu" id="menu-onepage-applanding-1">
                  <li class="menu-item current-menu-parent menu-item-has-children page_item_has_children">
                    <a href="{{ url('/') }}">Home</a>

                  </li>

                  <li class="menu-item"><a href="#howitworks">Solution</a>
                    <span aria-expanded="true" role="menubar" data-toggle="dropdown" class="dropdown-toggle caret"><i class="fa fa-chevron-down"></i></span>
                    <ul class="children dropdown-menu">
                      <li class="menu-item current-menu-item current_page_item">
                        <a href="#howitworks">How it works</a>
                      </li>
                      <li class="menu-item current-menu-item current_page_item">
                        <a href="#features">Features</a>
                      </li>
                      <li class="menu-item current-menu-item current_page_item">
                        <a href="#application">Applications</a>
                      </li>
                      <li class="menu-item">
                        <a href="#event_calendar">Events</a>
                      </li>
                    </ul>
                  </li>
                  <li class="menu-item"><a href="#pricing_table">Pricing Plan</a></li>
                  <li class="menu-item"><a href="#get_in_touch">Get In Touch</a></li>
                  <li class="menu-item"><a href="{{ url(Auth::check()?myDashboard():'/login') }}">{{ Auth::check()?'Dashboard':'Login' }}</a></li>

                </ul>
              </div>                                        
            </nav><!-- #site-navigation -->
          </div>
        </div>
      </div>    
    </div>
    @endif
  </header>