<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="Site keywords here">
		<meta name="description" content="">
		<meta name='copyright' content=''>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Favicon -->
        {{-- <link rel="icon" href="{{asset('/assets/frontend')}}/img/favicon.png"> --}}
		
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{asset('/assets/frontend/css/bootstrap.min.css')}}">
		<!-- Nice Select CSS -->
		{{-- <link rel="stylesheet" href="{{asset('/assets/frontend/css/nice-select.css')}}"> --}}
		<!-- Font Awesome CSS -->
        <link rel="stylesheet" href="{{asset('/assets/frontend/css/font-awesome.min.css')}}">
		<!-- icofont CSS -->
        <link rel="stylesheet" href="{{asset('/assets/frontend/css/icofont.css')}}">
		<!-- Slicknav -->
		<link rel="stylesheet" href="{{asset('/assets/frontend/css/slicknav.min.css')}}">
		<!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="{{asset('/assets/frontend/css/owl-carousel.css')}}">
		<!-- Datepicker CSS -->
		{{-- <link rel="stylesheet" href="{{asset('/assets/frontend/css/datepicker.css')}}"> --}}
		<!-- Animate CSS -->
        <link rel="stylesheet" href="{{asset('/assets/frontend/css/animate.min.css')}}">
		<!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="{{asset('/assets/frontend/css/magnific-popup.css')}}">
		
		<!-- Medipro CSS -->
        <link rel="stylesheet" href="{{asset('/assets/frontend/css/normalize.css')}}">
        <link rel="stylesheet" href="{{asset('/assets/frontend/style.css')}}">
        <link rel="stylesheet" href="{{asset('/assets/frontend/css/responsive.css')}}">
		@yield('css')
      <title>
          @hasSection('title')
          @yield('title') -
          @endif
          {{ config('settings.appTitle', 'Laravel') }}
        </title>
    </head>
    <body>
	
		<!-- Preloader -->
        <div class="preloader">
            <div class="loader">
                <div class="loader-outter"></div>
                <div class="loader-inner"></div>

                <div class="indicator"> 
                    <svg width="16px" height="12px">
                        <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                        <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <!-- End Preloader -->
	
		<!-- Header Area -->
		<header class="header" >
			<!-- Topbar -->
			<div class="topbar">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-md-5 col-12">
							<!-- Contact -->
							<ul class="top-link">
                                @guest('student')
                                    <li><a href="{{route('student.login')}}">Signin</a></li>
                                    <li><a href="{{route('student.register')}}">Signup</a></li>
                                @endguest
								@auth('student')
									<li><a href="{{route('student.profile')}}">Profile</a></li>
									<li><a href="{{route('student.logout')}}" onclick="event.preventDefault();
            						document.getElementById('logout-form').submit();">Logout</a></li>
								@endauth
								<form id="logout-form" action="{{ route('student.logout') }}" method="POST" style="display: none;">
									@csrf
								</form>								
							</ul>
							<!-- End Contact -->
						</div>
						<div class="col-lg-6 col-md-7 col-12">
							<!-- Top Contact -->
							<ul class="top-contact">
								<li><i class="fa fa-phone"></i>+880 1234 56789</li>
								<li><i class="fa fa-envelope"></i><a href="mailto:support@yourmail.com">support@yourmail.com</a></li>
							</ul>
							<!-- End Top Contact -->
						</div>
					</div>
				</div>
			</div>
			<!-- End Topbar -->
			<!-- Header Inner -->
			<div class="header-inner">
				<div class="container">
					<div class="inner">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-12">
								<!-- Start Logo -->
								<div class="logo">
									<a href="{{route('student.dashboard')}}"><img src="{{asset('/assets/frontend')}}/img/logo.png" alt="#"></a>
								</div>
								<!-- End Logo -->
								<!-- Mobile Nav -->
								<div class="mobile-nav"></div>
								<!-- End Mobile Nav -->
							</div>
							<div class="col-lg-7 col-md-9 col-12">
								<!-- Main Menu -->
								<div class="main-menu">
									<nav class="navigation">
										<ul class="nav menu">
											<li class="active"><a href="#">Home <i class="icofont-rounded-down"></i></a>
												<ul class="dropdown">
													<li><a href="index.html">Home Page 1</a></li>
												</ul>
											</li>
											<li><a href="#">Doctos </a></li>
											<li><a href="#">Services </a></li>
											<li><a href="#">Pages <i class="icofont-rounded-down"></i></a>
												<ul class="dropdown">
													<li><a href="404.html">404 Error</a></li>
												</ul>
											</li>
											<li><a href="#">Blogs <i class="icofont-rounded-down"></i></a>
												<ul class="dropdown">
													<li><a href="blog-single.html">Blog Details</a></li>
												</ul>
											</li>
											<li><a href="contact.html">Contact Us</a></li>
										</ul>
									</nav>
								</div>
								<!--/ End Main Menu -->
							</div>
							<div class="col-lg-2 col-12">
								<div class="get-quote">
									<a href="appointment.html" class="btn">Book Appointment</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Header Inner -->
		</header>
		<!-- End Header Area -->
		
		@yield('content')	
		
		<!-- Footer Area -->
		<footer id="footer" class="footer ">					
			<!-- Copyright -->
			<div class="copyright">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-12">
							<div class="copyright-content">
								<p>© Copyright 2018  |  All Rights Reserved by  </p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Copyright -->
		</footer>
		<!--/ End Footer Area -->
		
		<!-- jquery Min JS -->
        <script src="{{asset('/assets/frontend/js/jquery.min.js')}}"></script>
		<!-- jquery Migrate JS -->
		<script src="{{asset('/assets/frontend/js/jquery-migrate-3.0.0.js')}}"></script>
		<!-- jquery Ui JS -->
		<script src="{{asset('/assets/frontend/js/jquery-ui.min.js')}}"></script>
		<!-- Easing JS -->
        <script src="{{asset('/assets/frontend/js/easing.js')}}"></script>
		<!-- Color JS -->
		<script src="{{asset('/assets/frontend/js/colors.js')}}"></script>
		<!-- Popper JS -->
		<script src="{{asset('/assets/frontend/js/popper.min.js')}}"></script>
		<!-- Bootstrap Datepicker JS -->
		{{-- <script src="{{asset('/assets/frontend/js/bootstrap-datepicker.js')}}"></script> --}}
		<!-- Jquery Nav JS -->
        <script src="{{asset('/assets/frontend/js/jquery.nav.js')}}"></script>
		<!-- Slicknav JS -->
		<script src="{{asset('/assets/frontend/js/slicknav.min.js')}}"></script>
		<!-- ScrollUp JS -->
        <script src="{{asset('/assets/frontend/js/jquery.scrollUp.min.js')}}"></script>
		<!-- Niceselect JS -->
		{{-- <script src="{{asset('/assets/frontend/js/niceselect.js')}}"></script> --}}
		<!-- Tilt Jquery JS -->
		<script src="{{asset('/assets/frontend/js/tilt.jquery.min.js')}}"></script>
		<!-- Owl Carousel JS -->
        <script src="{{asset('/assets/frontend/js/owl-carousel.js')}}"></script>
		<!-- counterup JS -->
		<script src="{{asset('/assets/frontend/js/jquery.counterup.min.js')}}"></script>
		<!-- Steller JS -->
		<script src="{{asset('/assets/frontend/js/steller.js')}}"></script>
		<!-- Wow JS -->
		<script src="{{asset('/assets/frontend/js/wow.min.js')}}"></script>
		<!-- Magnific Popup JS -->
		<script src="{{asset('/assets/frontend/js/jquery.magnific-popup.min.js')}}"></script>
		<!-- Counter Up CDN JS -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="{{asset('/assets/frontend/js/bootstrap.min.js')}}"></script>
		<!-- Main JS -->
		<script src="{{asset('/assets/frontend/js/main.js')}}"></script>
		@yield('js')
    </body>
</html>