<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Auto Generated Controller-Model-SqlFile-ApiDocument For Codeigniter">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Pavan Kumar">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Codeigniter | Auto Generator') }}</title>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Font -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Slicknav -->
    <link href="{{ asset('css/slicknav.css') }}" rel="stylesheet" type="text/css">
    <!-- Owl carousel -->
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/owl.theme.css') }}" rel="stylesheet" type="text/css">
    <!-- Animate -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css">
    <!-- Main Style -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">
    <!-- Extras Style -->
    <link href="{{ asset('css/extras.css') }}" rel="stylesheet" type="text/css">
    <!-- Responsive Style -->
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" type="text/css">

  </head>
  <body>

    <!-- Header Area wrapper Starts -->
    <header id="header-wrap">
      <!-- Navbar Start -->
      <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar indigo">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
              <span class="icon-menu"></span>
              <span class="icon-menu"></span>
              <span class="icon-menu"></span>
            </button>
            <!-- <a href="/" class="navbar-brand"><img src="{{ asset('img/logo.png') }}" alt=""></a> -->
            <a href="/" class="navbar-brand">AutoGenCode</a>
          </div>
          <div class="collapse navbar-collapse" id="main-navbar">
            <ul class="navbar-nav mr-auto w-100 justify-content-end clearfix">
              <li class="nav-item active">
                <a class="nav-link" href="#sliders">
                  Home
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#about">
                  About
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#services">
                  Services
                </a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" href="#portfolio">
                  Tutorials
                </a>
              </li> -->
              <!-- <li class="nav-item">
                <a class="nav-link" href="#team">
                  Clients
                </a>
              </li> -->
              <!-- <li class="nav-item">
                <a class="nav-link" href="#pricing">
                  Pricing
                </a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link" href="#contact">
                  Contact
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">
                  Login / Register
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- Mobile Menu Start -->
        <ul class="mobile-menu navbar-nav">
          <li>
            <a class="page-scroll" href="#sliders">
              Home
            </a>
          </li>
          <li>
            <a class="page-scroll" href="#about">
              About
            </a>
          </li>
          <li>
            <a class="page-scroll" href="#services">
              Services
            </a>
          </li>
          <!-- <li>
            <a class="page-scroll" href="#portfolio">
              Tutorials
            </a>
          </li>
          <li>
            <a class="page-scroll" href="#team">
              Clients
            </a>
          </li>
          <li>
            <a class="page-scroll" href="#pricing">
              Pricing
            </a>
          </li> -->
          <li>
            <a class="page-scroll" href="#contact">
              Contact
            </a>
          </li>
          <li>
            <a class="page-scroll" href="{{ route('login') }}">
              Login / Register
            </a>
          </li>
        </ul>
        <!-- Mobile Menu End -->

      </nav>
      <!-- Navbar End -->

      <!-- sliders -->
      <div id="sliders">
        <div class="full-width">
          <!-- light slider -->
          <div id="light-slider" class="carousel slide">
            <div id="carousel-area">
              <div id="carousel-slider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-slider" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-slider" data-slide-to="1"></li>
                  <li data-target="#carousel-slider" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active">
                    <img src="{{ asset('img/slider/slider1.png') }}" alt="">
                    <div class="carousel-caption">
                      <a href="/register" class="btn btn-lg btn-border animated fadeInUp">Register Here</a>
                      <a href="/login" class="btn btn-lg btn-border animated fadeInUp">Login Here</a>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('img/slider/slider2.png') }}" alt="">
                    <div class="carousel-caption">
                      <a href="/register" class="btn btn-lg btn-border animated fadeInUp">Register Here</a>
                      <a href="/login" class="btn btn-lg btn-border animated fadeInUp">Login Here</a>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('img/slider/slider3.png') }}" alt="">
                    <div class="carousel-caption">
                      <a href="/register" class="btn btn-lg btn-border animated fadeInUp">Register Here</a>
                      <a href="/login" class="btn btn-lg btn-border animated fadeInUp">Login Here</a>
                    </div>
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carousel-slider" role="button" data-slide="prev">
                  <i class="fa fa-chevron-left"></i>
                </a>
                <a class="carousel-control-next" href="#carousel-slider" role="button" data-slide="next">
                  <i class="fa fa-chevron-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End sliders -->

    </header>
    <!-- Header Area wrapper End -->

    <!-- About Section Start -->
    <div id="about" class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-xs-12">
            <div class="about block text-center">
              <img src="{{ asset('img/about/php.png') }}" alt="">
              <h5><a href="#">AGC - PHP</a></h5>
              <p style="color:green;"><b>AGC Supporting Frameworks - Codeigniter</b></p>
              <p>AGC Feature Supporting Frameworks - <b>Laravel & etc...</b></p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-xs-12">
            <div class="about block text-center">
              <img src="{{ asset('img/about/python.png') }}" alt="">
              <h5><a href="#">AGC - PYTHON</a></h5>
              <p style="color:red;">Supporting Frameworks - N/A</p>
              <p>AGC Feature Supporting Frameworks - <b>Django & etc...</b></p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-xs-12">
            <div class="about block text-center">
              <img src="{{ asset('img/about/nodejs.png') }}" alt="">
              <h5><a href="#">AGC - NODEJS</a></h5>
              <p style="color:red;">Supporting Frameworks - N/A</p>
              <p>AGC Feature Supporting Frameworks - <b>Express & etc...</b></p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-xs-12">
            <div class="about block text-center">
              <img src="{{ asset('img/about/ruby.png') }}" alt="">
              <h5><a href="#">AGC - RUBY</a></h5>
              <p style="color:red;">Supporting Frameworks - N/A</p>
              <p>AGC Feature Supporting Frameworks - <b>Ruby on Rails & etc...</b></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- About Section End -->

    <!-- Services Section Start -->
    <section id="services" class="section-padding" style="background-color:black;">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="section-title wow fadeInDown animated" data-wow-delay="0.3s">AGC Services</h2>
          </div>
        </div>
        <div class="row">
          <!-- Start Service Icon 1 -->
          <div class="col-md-6 col-lg-4 col-xs-12">
            <div class="service-box">
              <div class="service-icon">
                <i class="fa fa-cogs"></i>
              </div>
              <div class="service-content">
                <h4><a href="#" style="color:white;">Easy to Customize</a></h4>
                <p><b>
                  User can change api's as per requirement very easily. Can add multi features to existing application. Can make use of existing models very easily!
                </b></p>
              </div>
            </div>
          </div>
          <!-- End Service Icon 1 -->

          <!-- Start Service Icon 2 -->
          <div class="col-md-6 col-lg-4 col-xs-12">
            <div class="service-box">
              <div class="service-icon">
                <i class="fa fa-cubes"></i>
              </div>
              <div class="service-content">
                <h4><a href="#" style="color:white;">100+ AGC Functions</a></h4>
                <p><b>
                  AGC provides 100+ default functions to use (which are provided by agc), which reduce developer to spend lot of time on developing small things. 
                </b></p>
              </div>
            </div>
          </div>
          <!-- End Service Icon 2 -->

          <!-- Start Service Icon 3 -->
          <div class="col-md-6 col-lg-4 col-xs-12">
            <div class="service-box">
              <div class="service-icon">
                <i class="fa fa-tachometer"></i>
              </div>
              <div class="service-content">
                <h4><a href="#" style="color:white;">Generates Super Fast</a></h4>
                <p><b>
                  AGC Generates any application within 30 seconds. Estimated saving 90 hours (30 days). This was done ~1900028.140 times faster than manually coding it.
                </b></p>
              </div>
            </div>
          </div>
          <!-- End Service Icon 3 -->

          <!-- Start Service Icon 4 -->
          <div class="col-md-6 col-lg-4 col-xs-12">
            <div class="service-box">
              <div class="service-icon">
                <i class="fa fa-check"></i>
              </div>
              <div class="service-content">
                <h4><a href="#" style="color:white;">Commented Code</a></h4>
                <p><b>
                  AGC generates comments for each line of code, They are added with the purpose of making the source code easier for developers to understand very easily.
                </b></p>
              </div>
            </div>
          </div>
          <!-- End Service Icon 4 -->

          <!-- Start Service Icon 5 -->
          <div class="col-md-6 col-lg-4 col-xs-12">
            <div class="service-box">
              <div class="service-icon">
                <i class="fa fa-flash"></i>
              </div>
              <div class="service-content">
                <h4><a href="#" style="color:white;">Documented Api's List</a></h4>
                <p><b>
                  AGC generates a local api doc & server api doc to make development easy in different environments. It saves lots of time to test each api & document it.
                </b></p>
              </div>
            </div>
          </div>
          <!-- End Service Icon 5 -->
          
          <!-- Start Service Icon 6 -->
          <div class="col-md-6 col-lg-4 col-xs-12">
            <div class="service-box">
              <div class="service-icon">
                <i class="fa fa-hand-pointer-o"></i>
              </div>
              <div class="service-content">
                <h4><a href="#" style="color:white;">Advance Features</a></h4>
                <p>
                  AGC can generate any project in multiple technologies as well as in different frameworks. Which reduce time, resource, money & inreturn we have fastest output to the client.
                </p>
              </div>
            </div>
          </div>
          <!-- End Service Icon 6 -->
        </div>
      </div>
    </section>
    <!-- Services Section End -->

    <!-- Portfolio Section -->
    <!-- <section id="portfolio" class="section-padding"> -->
      <!-- Container Starts -->
      <!-- <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="section-title wow fadeInDown animated" data-wow-delay="0.3s">Tutorials</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 col-md-12"> -->
            <!-- Portfolio Controller/Buttons -->
            <!-- <div class="controls text-center wow fadeInUpQuick" data-wow-delay=".6s">
              <a class="filter active btn btn-common" data-filter="all">
                All 
              </a>
              <a class="filter btn btn-common" data-filter=".branding">
                Branding 
              </a>
              <a class="filter btn btn-common" data-filter=".marketing">
                Marketing
              </a>
              <a class="filter btn btn-common" data-filter=".planning">
                Planning 
              </a>
              <a class="filter btn btn-common" data-filter=".research">
                Research 
              </a>
              <a class="filter btn btn-common" data-filter=".marketing">
                Marketing
              </a>
              <a class="filter btn btn-common" data-filter=".planning">
                Planning 
              </a>
              <a class="filter btn btn-common" data-filter=".research">
                Research 
              </a>
              <a class="filter btn btn-common" data-filter=".planning">
                Planning 
              </a>
              <a class="filter btn btn-common" data-filter=".research">
                Research 
              </a>
              <a class="filter btn btn-common" data-filter=".planning">
                Planning 
              </a>
              <a class="filter btn btn-common" data-filter=".research">
                Research 
              </a>
            </div> -->
            <!-- Portfolio Controller/Buttons Ends-->
          <!-- </div> -->

          <!-- Portfolio Recent Projects -->
          <!-- <div id="portfolio" class="row wow fadeInUpQuick" data-wow-delay="0.8s">
            <div class="col-lg-4 col-md-6 col-xs-12 mix marketing planning">
              <div class="portfolio-item">
                <div class="portfolio-img">
                  <img src="{{ asset('img/portfolio/img1.jpg') }}" alt="" />
                </div>
                <div class="portfoli-content">
                  <div class="sup-desc-wrap">
                    <div class="sup-desc-inner">
                      <div class="sup-link">
                        <a class="left-link" href="#"><i class="fa fa-link"></i></a>
                        <a class="right-link" href="#"><i class="fa fa-heart"></i></a>
                      </div>
                      <div class="sup-meta-wrap">
                        <a class="sup-title" href="#">
                          <h4>TITLE HERE</h4>
                        </a>
                        <p class="sup-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente vel quisquam.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 mix branding planning">
              <div class="portfolio-item">
                <div class="portfolio-img">
                  <img src="{{ asset('img/portfolio/img2.jpg') }}" alt="" />
                </div>
                <div class="portfoli-content">
                  <div class="sup-desc-wrap">
                    <div class="sup-desc-inner">
                      <div class="sup-link">
                        <a class="left-link" href="#"><i class="fa fa-link"></i></a>
                        <a class="right-link" href="#"><i class="fa fa-heart"></i></a>
                      </div>
                      <div class="sup-meta-wrap">
                        <a class="sup-title" href="#">
                          <h4>TITLE HERE</h4>
                        </a>
                        <p class="sup-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente vel quisquam.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 mix branding research">
              <div class="portfolio-item">
                <div class="portfolio-img">
                  <img src="{{ asset('img/portfolio/img3.jpg') }}" alt="" />
                </div>
                <div class="portfoli-content">
                  <div class="sup-desc-wrap">
                    <div class="sup-desc-inner">
                      <div class="sup-link">
                        <a class="left-link" href="#"><i class="fa fa-link"></i></a>
                        <a class="right-link" href="#"><i class="fa fa-heart"></i></a>
                      </div>
                      <div class="sup-meta-wrap">
                        <a class="sup-title" href="#">
                          <h4>TITLE HERE</h4>
                        </a>
                        <p class="sup-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente vel quisquam.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 mix marketing research">
              <div class="portfolio-item">
                <div class="portfolio-img">
                  <img src="{{ asset('img/portfolio/img4.jpg') }}" alt="" />
                </div>
                <div class="portfoli-content">
                  <div class="sup-desc-wrap">
                    <div class="sup-desc-inner">
                      <div class="sup-link">
                        <a class="left-link" href="#"><i class="fa fa-link"></i></a>
                        <a class="right-link" href="#"><i class="fa fa-heart"></i></a>
                      </div>
                      <div class="sup-meta-wrap">
                        <a class="sup-title" href="#">
                          <h4>TITLE HERE</h4>
                        </a>
                        <p class="sup-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente vel quisquam.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 mix marketing planning">
              <div class="portfolio-item">
                <div class="portfolio-img">
                  <img src="{{ asset('img/portfolio/img5.jpg') }}" alt="" />
                </div>
                <div class="portfoli-content">
                  <div class="sup-desc-wrap">
                    <div class="sup-desc-inner">
                      <div class="sup-link">
                        <a class="left-link" href="#"><i class="fa fa-link"></i></a>
                        <a class="right-link" href="#"><i class="fa fa-heart"></i></a>
                      </div>
                      <div class="sup-meta-wrap">
                        <a class="sup-title" href="#">
                          <h4>TITLE HERE</h4>
                        </a>
                        <p class="sup-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente vel quisquam.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 mix planning research">
              <div class="portfolio-item">
                <div class="portfolio-img">
                  <img src="{{ asset('img/portfolio/img6.jpg') }}" alt="" />
                </div>
                <div class="portfoli-content">
                  <div class="sup-desc-wrap">
                    <div class="sup-desc-inner">
                      <div class="sup-link">
                        <a class="left-link" href="#"><i class="fa fa-link"></i></a>
                        <a class="right-link" href="#"><i class="fa fa-heart"></i></a>
                      </div>
                      <div class="sup-meta-wrap">
                        <a class="sup-title" href="#">
                          <h4>TITLE HERE</h4>
                        </a>
                        <p class="sup-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente vel quisquam.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- Container Ends -->
    <!-- </section> -->
    <!-- Portfolio Section Ends -->

    <!-- facts Section Start -->
    <!-- <div id="counter">
      <div class="container">
        <div class="row count-to-sec">
          <div class="col-lg-3 col-md-6 col-xs-12 count-one">
            <span class="icon"><i class="fa fa-download"> </i></span>
            <h3 class="timer count-value" data-to="561" data-speed="1000">561</h3>
            <hr class="width25-divider">
            <small class="count-title">Companies</small>
          </div>

          <div class="col-lg-3 col-md-6 col-xs-12 count-one">
            <span class="icon"><i class="fa fa-user"> </i></span>
            <h3 class="timer count-value" data-to="950" data-speed="1000">950</h3>
            <hr class="width25-divider">
            <small class="count-title">Developers</small>
          </div>

          <div class="col-lg-3 col-md-6 col-xs-12 count-one">
            <span class="icon"><i class="fa fa-desktop"> </i></span>
            <h3 class="timer count-value" data-to="978" data-speed="1000">978</h3>
            <hr class="width25-divider">
            <small class="count-title">Generated Projects</small>
          </div>

          <div class="col-lg-3 col-md-6 col-xs-12 count-one">
            <span class="icon"><i class="fa fa-coffee"> </i></span>
            <h3 class="timer count-value" data-to="1" data-speed="1000">1</h3>
            <hr class="width25-divider">
            <small class="count-title">Supported Technologies</small>
          </div>
        </div>
      </div>
    </div> -->
    <!-- facts Section End -->
    
    <!-- Team Section Start -->
    <!-- <div id="team" class="team-members-tow section-padding">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="section-title wow fadeInDown animated" data-wow-delay="0.3s">Our Main Clients</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6 col-xs-12"> -->
            <!-- Team Item Starts -->
            <!-- <figure>
              <img src="{{ asset('img/team/team-05.jpg') }}" alt="">
              <div class="image-overlay">
                <div class="overlay-text text-center">
                  <div class="info-text">
                    <strong>Melody Clark</strong>
                    <span>UX Specialist</span>
                  </div>
                  <hr class="small-divider">
                  <ul class="social-icons">
                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
              </div>
            </figure> -->
            <!-- Team Item Ends -->
          <!-- </div>
          <div class="col-lg-4 col-md-6 col-xs-12"> -->
            <!-- Team Item Starts -->
            <!-- <figure>
              <img src="{{ asset('img/team/team-06.jpg') }}" alt="">
              <div class="image-overlay">
                <div class="overlay-text text-center">
                  <div class="info-text">
                    <strong>Danny Burton</strong>
                    <span>Senior Designer</span>
                  </div>
                  <hr class="small-divider">
                  <ul class="social-icons">
                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
              </div>
            </figure> -->
            <!-- Team Item Ends -->
          <!-- </div>

          <div class="col-lg-4 col-md-6 col-xs-12"> -->
            <!-- Team Item Starts -->
            <!-- <figure>
              <img src="{{ asset('img/team/team-07.jpg') }}" alt="">
              <div class="image-overlay">
                <div class="overlay-text text-center">
                  <div class="info-text">
                    <strong>Elizabeth Jones</strong>
                    <span>Art Director</span>
                  </div>
                  <hr class="small-divider">
                  <ul class="social-icons">
                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
              </div>
            </figure> -->
            <!-- Team Item Ends -->
          <!-- </div>
        </div>
      </div>
    </div> -->
    <!-- Team Section End -->

    <!-- Pricing section Start --> 
    <!-- <section id="pricing" class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="section-title wow fadeInDown animated" data-wow-delay="0.3s">Pricing Table</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="pricing-table-item">
              <div class="plan-name">
                <h3>Basic</h3>
              </div>
              <div class="plan-price">
                <div class="price-value">$ 10</div>
                <div class="interval">per month</div>
              </div>
              <div class="plan-list">
                <ul>
                  <li><i class="fa fa-check"></i>2GB Disk Space</li>
                  <li><i class="fa fa-check"></i>3 Sub Domains</li>
                  <li><i class="fa fa-check"></i>12 Database</li>
                  <li><i class="fa fa-check"></i>Unlimited Users</li>
                </ul>
              </div>
              <div class="plan-signup">
                <a href="#" class="btn btn-common">Get Started</a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="pricing-table-item table-active">
              <div class="plan-name">
                <h3>Premium</h3>
              </div>
              <div class="plan-price">
                <div class="price-value">$ 69 </div>
                <div class="interval">per month</div>
              </div>
              <div class="plan-list">
                <ul>
                  <li><i class="fa fa-check"></i>10GB Disk Space</li>
                  <li><i class="fa fa-check"></i>5 Sub Domains</li>
                  <li><i class="fa fa-check"></i>12 Database</li>
                  <li><i class="fa fa-check"></i>Unlimited Users</li>
                </ul>
              </div>
              <div class="plan-signup">
                <a href="#" class="btn btn-common">Get Started</a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="pricing-table-item">
              <div class="plan-name">
                <h3>Unltimate</h3>
              </div>
              <div class="plan-price">
                <div class="price-value">$ 79 </div>
                <div class="interval">per month</div>
              </div>
              <div class="plan-list">
                <ul>
                  <li><i class="fa fa-check"></i>50GB Disk Space</li>
                  <li><i class="fa fa-check"></i>20 Sub Domains</li>
                  <li><i class="fa fa-check"></i>36 Database</li>
                  <li><i class="fa fa-check"></i>Unlimited Users</li>
                </ul>
              </div>
              <div class="plan-signup">
                <a href="#" class="btn btn-common">Get Started</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <!-- Pricing Table Section End -->

    <!-- Single testimonial Start -->
    <!-- <div class="single-testimonial-area">
      <div class="container">
        <div id="single-testimonial-item" class="owl-carousel"> -->
          <!-- Single testimonial Item -->
          <!-- <div class="item">
            <div class="row justify-content-md-center">
              <div class="col-lg-8 col-md-12 col-xs-12 col-md-auto">
                <div class="testimonial-inner text-md-center">
                  <blockquote>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id ipsam, non ut molestiae rerum praesentium repellat debitis iure reiciendis, eius culpa beatae commodi facere ad numquam. Quisquam dignissimos similique sunt iure fugit, omnis vel cupiditate repellendus magni nihil molestiae quam, delectus
                  </blockquote>
                  <div class="testimonial-images">
                    <img class="img-circle text-md-center" src="{{ asset('img/testimonial/img1.jpg') }}" alt="">
                  </div>
                  <div class="testimonial-footer">
                    <i class="fa fa-user"></i> Arman
                    <a href="#"> UIdeck</a>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

          <!-- Single testimonial Item -->
          <!-- <div class="item">
            <div class="row justify-content-md-center">
              <div class="col-lg-8 col-md-12 col-xs-12 col-md-auto">
                <div class="testimonial-inner text-md-center">
                  <blockquote>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id ipsam, non ut molestiae rerum praesentium repellat debitis iure reiciendis, eius culpa beatae commodi facere ad numquam. Quisquam dignissimos similique sunt iure fugit, omnis vel cupiditate repellendus magni nihil molestiae quam, delectus
                  </blockquote>
                  <div class="testimonial-images">
                    <img class="img-circle text-md-center" src="{{ asset('img/testimonial/img2.jpg') }}" alt="">
                  </div>
                  <div class="testimonial-footer">
                    <i class="fa fa-user"></i> Jeniffer
                    <a href="#"> GrayGrids</a>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

          <!-- Single testimonial Item -->
          <!-- <div class="item">
            <div class="row justify-content-md-center">
              <div class="col-lg-8 col-md-12 col-xs-12 col-md-auto">
                <div class="testimonial-inner text-md-center">
                  <blockquote>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id ipsam, non ut molestiae rerum praesentium repellat debitis iure reiciendis, eius culpa beatae commodi facere ad numquam. Quisquam dignissimos similique sunt iure fugit, omnis vel cupiditate repellendus magni nihil molestiae quam, delectus
                  </blockquote>
                  <div class="testimonial-images">
                    <img class="img-circle text-md-center" src="{{ asset('img/testimonial/img3.jpg') }}" alt="">
                  </div>
                  <div class="testimonial-footer">
                    <i class="fa fa-user"></i> Elon Musk<a href="#"> Tesla</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- end -->

    <!-- Contact Form Section Start -->
    <section id="contact" class="contact-form section-padding">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="section-title wow fadeInDown animated" data-wow-delay="0.3s">Contact AGC</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 col-md-6 col-xs-12">
            <h3 class="title-head text-left">Get in touch</h3>

            <!-- Form -->
            <form method="POST" action="{{ route('contactus') }}" class="contact-form" data-toggle="validator">
              @csrf

              <div class="row">
                <div class="col-lg-4 col-md-12 col-xs-12">
                  <div class="form-group">
                    <i class="contact-icon fa fa-user"></i>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Full Name" data-error="Please enter your name" required>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-12 col-xs-12">
                  <div class="form-group">
                    <i class="contact-icon fa fa-envelope-o"></i>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required data-error="Please enter your email">
                    <div class="help-block with-errors"></div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-12 col-xs-12">
                  <div class="form-group">
                    <i class="contact-icon fa fa-mobile"></i>
                    <input type="text" class="form-control" name="mobileno" id="mobileno" placeholder="Mobile No" required data-error="Please enter your MobileNo">
                    <div class="help-block with-errors"></div>
                  </div>
                </div>

                <div class="col-lg-12 col-md-12 col-xs-12">
                  <textarea class="form-control" name="message" id="message" rows="4" placeholder="Message" required data-error="Please enter your message"></textarea>
                  <div class="help-block with-errors"></div>
                  <button type="submit" id="form-submit" class="btn btn-common btn-form-submit">Send Message</button>
                  <div id="msgSubmit" class="h3 text-center hidden"></div>
                  <div class="clearfix"></div>
                </div>

              </div>
            </form>
          </div>

          <div class="col-lg-4 col-md-6 col-xs-12">
            <h3 class="contact-info-title text-left">Contact Information</h3>
            <div class="contact-info">
              <address>
              <i class="lni-map-marker icons cyan-color contact-info-icon"></i>
              Plot No 31,32 Roma Enclave Phase-1, 
              <i class="lni-map-marker icons cyan-color contact-info-icon"></i>
              Shivanarayanapuram, Badangpet, Hyderabad.
            </address>
              <div class="tel-info">
                <a href="tel:+918520872771"><i class="lni-mobile icons cyan-color contact-info-icon"></i>+91 8520872771</a>
                <a href="tel:+917989118867"><i class="lni-mobile icons cyan-color contact-info-icon"></i>+91 7989118867</a>
              </div>
              <a href="mailto:autogencode.com@gmail.com"><i class="lni-envelope icons cyan-color contact-info-icon"></i>autogencode.com@gmail.com</a>
              <a href="/"><i class="lni-tab icons cyan-color contact-info-icon"></i>www.autogencode.com</a>
              <!-- <ul class="social-links">
                <li>
                  <a href="#" class="fa fa-facebook"></a>
                </li>
                <li>
                  <a href="#" class="fa fa-twitter"></a>
                </li>
                <li>
                  <a href="#" class="fa fa-instagram"></a>
                </li>
                <li>
                  <a href="#" class="fa fa-linkedin"></a>
                </li>
              </ul> -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Contact Form Section End -->

	  <!-- Footer Section -->
    <footer class="footer">
      <!-- Container Starts -->
      <!-- <div class="container"> -->
        <!-- Row Starts -->
        <!-- <div class="row section"> -->
          <!-- Footer Widget Starts -->
          <!-- <div class="footer-widget col-lg-3 col-md-6 col-xs-12 wow fadeIn">
            <h3 class="small-title">
              About Us
            </h3>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis veritatis eius porro modi hic. Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            </p>
            <div class="social-footer">
              <a href="#"><i class="fa fa-facebook icon-round"></i></a>
              <a href="#"><i class="fa fa-twitter icon-round"></i></a>
              <a href="#"><i class="fa fa-linkedin icon-round"></i></a>
              <a href="#"><i class="fa fa-google-plus icon-round"></i></a>
            </div>
          </div> -->
          <!-- Footer Widget Ends -->

          <!-- Footer Widget Starts -->
          <!-- <div class="footer-widget col-lg-3 col-md-6 col-xs-12 wow fadeIn" data-wow-delay=".2s">
            <h3 class="small-title">
              Links
            </h3>
            <ul class="menu">
              <li><a href="#">About Us</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">Works</a></li>
              <li><a href="#">Pricing</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </div> -->
          <!-- Footer Widget Ends -->

          <!-- Footer Widget Starts -->
          <!-- <div class="footer-widget col-lg-3 col-md-6 col-xs-12 wow fadeIn" data-wow-delay=".5s">
            <h3 class="small-title">
              GALLERY
            </h3>
            <div class="plain-flicker-gallery">
              <a href="#"><img src="{{ asset('img/flicker/img1.jpg') }}" alt=""></a>
              <a href="#"><img src="{{ asset('img/flicker/img2.jpg') }}" alt=""></a>
              <a href="#"><img src="{{ asset('img/flicker/img3.jpg') }}" alt=""></a>
              <a href="#"><img src="{{ asset('img/flicker/img4.jpg') }}" alt=""></a>
              <a href="#"><img src="{{ asset('img/flicker/img5.jpg') }}" alt=""></a>
              <a href="#"><img src="{{ asset('img/flicker/img6.jpg') }}" alt=""></a>
            </div>
          </div> -->
          <!-- Footer Widget Ends -->

          <!-- Footer Widget Starts -->
          <!-- <div class="footer-widget col-lg-3 col-md-6 col-xs-12 wow fadeIn" data-wow-delay=".8s">
            <h3 class="small-title">
              SUBSCRIBE US
            </h3>
            <div class="contact-us">
              <form>
                <div class="form-group">
                  <input type="text" class="form-control" id="exampleInputName2" placeholder="Enter your name">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter your email">
                </div>
                <button type="submit" class="btn btn-common">Submit</button>
              </form>
            </div>
          </div> -->
          <!-- Footer Widget Ends -->
        <!-- </div> -->
        <!-- Row Ends -->
      <!-- </div> -->
      <!-- Container Ends -->

      <!-- Copyright -->
      <div id="copyright">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
              <p class="copyright-text">Auto Generated Api's | Author: <a href="https://www.facebook.com/profile.php?id=100005175935690&amp;fref=ts"><em>Pavan Kumar</em></a>
              </p>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
              <ul class="nav nav-inline  justify-content-end ">
                <li class="nav-item">
                  <a class="nav-link active" href="/">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Sitemap</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Privacy Policy</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Terms of services</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- Copyright  End-->

    </footer>
    <!-- Footer Section End-->

    <!-- Go to Top Link -->
    <a href="#" class="back-to-top">
      <i class="fa fa-arrow-up"></i>
    </a>
    
    <!-- Preloader -->
    <div id="preloader">
      <div class="loader" id="loader-1"></div>
    </div>
    <!-- End Preloader -->
    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('js/jquery-min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mixitup.js') }}"></script>
    <script src="{{ asset('js/jquery.countTo.js') }}"></script>
    <script src="{{ asset('js/jquery.nav.js') }}"></script>
    <script src="{{ asset('js/scrolling-nav.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/form-validator.min.js') }}"></script>
    <script src="{{ asset('js/contact-form-script.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
      
  </body>
</html>