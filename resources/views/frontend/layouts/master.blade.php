<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>
        @if(View::hasSection('title'))
            @yield('title')
      @else
      {{ config('settings.appTitle', 'Laravel') }}
      {{-- JobEntry - Job Portal Website --}}
      @endif
    </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
	{{-- <meta name="keywords" content="{{ config('settings.metaKeywords', '') }}"> --}}
    {{-- <meta name="description" content="{{ config('settings.metaDescription', '') }}"> --}}
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="//fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('/assets/frontend')}}/lib/animate/animate.min.css" rel="stylesheet">
    {{-- <link href="{{asset('/assets/frontend')}}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet"> --}}

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('/assets/frontend')}}/css/bootstrap.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="{{asset('/assets/frontend')}}/css/style.css" rel="stylesheet">
	@yield('css')
    <style type="text/css">
        .headertop{
            background-color:#00a3c8; 
            color:#fff;
            padding: 4px;
            font-size: 14px;
        }
        .headertop a{
            color:#fff;
        }
        .headertop .twittericon {
            padding: 0 5px;
        }
        .headertop .facebookicon {
            padding: 0 5px;
        }
    </style>
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <div class="headertop clearfix">
            <div class="">
                <div class="row">
                    <!-- Address -->
                    <div class="col-md-9">	     			
                        <div class="px-lg-5 clearfix"><span><i class="fas fa-map-marker-alt"></i>86 (New), 726/A (Old), Satmasjid Road, Dhanmondi, Dhaka-1209</span>
                        <a href="tel:01755697173-6" class="callusbtn"><i class="fas fa-phone"></i>01755697173-6</a>
                        <a href="tel:0241023155" class="callusbtn"><i class="fas fa-phone"></i>0241023155</a>
                        </div>
                    </div>
                    <!-- Social Links -->
                    <div class="col-md-3">
                        <a class="twittericon" title="Youtube" href="https://www.facebook.com/profile.php?id=100066431304810"><i class="fab fa-youtube"></i></a>
                        <a class="facebookicon" title="Facebook" href="https://www.youtube.com/@ProfDrAKMFazlulHaque"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0 d-print-none">
            <a href="{{ route('/') }}" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                {{-- <h1 class="m-0 text-primary">{{ config('settings.appTitle', 'Job Portal') }}</h1> --}}
                <img src="{{ asset('upload/site_file/'.config('settings.appLogo')) }}" alt="{{ config('settings.appTitle', 'Job Portal') }}" class="img-fluid" style="max-height: 50px">
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="{{ route('/') }}" class="nav-item nav-link active">Home</a>
                    <a href="{{ url('/page/instructions')}}" class="nav-item nav-link">আবেদন সংক্রান্ত নির্দেশনাবলী</a>
                    {{-- <a href="{{ route('ex-student.create')}}" class="nav-item nav-link">Ex-Student</a> --}}
                    {{-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Jobs</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="#" class="dropdown-item">Job List</a>
                            <a href="#" class="dropdown-item">Job Detail</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="#" class="dropdown-item">Job Category</a>
                            <a href="#" class="dropdown-item">Testimonial</a>
                            <a href="#" class="dropdown-item">404</a>
                        </div>
                    </div> --}}
                    {{-- <a href="#" class="nav-item nav-link">Contact</a> --}}
                </div>
				@guest('student')
                <a href="{{route('student.login')}}" class="btn btn-info rounded-0 py-4 px-lg-5">Login</a>
                <a href="{{route('student.register')}}" class="btn btn-secondary rounded-0 py-4 px-lg-5">Register</a>
				@endguest
				@auth('student')
                <a href="{{route('student.dashboard')}}" class="btn btn-info rounded-0 py-4 px-lg-5">{{ auth('student')->user()->name }}</a>
                <a class="btn btn-secondary rounded-0 py-4 px-lg-5" href="{{ route('student.logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">Logout</a>
				@endauth
				<form id="logout-form" action="{{ route('student.logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
            </div>
        </nav>
        <!-- Navbar End -->

    <div class="container">
        @yield('content')
    </div>        

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn d-print-none" data-wow-delay="0.1s">
            {{-- <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">{{ config('app.name') }}</h5>
                        <a class="btn btn-link text-white-50" href="">About Us</a>
                        <a class="btn btn-link text-white-50" href="">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="">Our Services</a>
                        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Quick Links</h5>
                        <a class="btn btn-link text-white-50" href="">About Us</a>
                        <a class="btn btn-link text-white-50" href="">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="">Our Services</a>
                        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Contact</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>86 (New), 726/A (Old), Satmasjid Road, Dhanmondi, Dhaka-1209</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>01755697173-6</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@fazlulhaquehospital.com</p>
                        <p class="mb-2"><i class="fa fa-globe me-3"></i>https://fazlulhaquehospital.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Newsletter</h5>
                        <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">{{ config('app.name', 'Laravel') }}</a>, All Right Reserved. 						
							
							Designed By <a class="border-bottom" href="https://pondit.com">Pondit.com</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Cookies</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top  d-print-none"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="//code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('/assets/frontend')}}/lib/wow/wow.min.js"></script>
    <script src="{{asset('/assets/frontend')}}/lib/easing/easing.min.js"></script>
    <script src="{{asset('/assets/frontend')}}/lib/waypoints/waypoints.min.js"></script>
    {{-- <script src="{{asset('/assets/frontend')}}/lib/owlcarousel/owl.carousel.min.js"></script> --}}
	@yield('js')
    <!-- Template Javascript -->
    <script src="{{asset('/assets/frontend')}}/js/main.js"></script>

</body>

</html>