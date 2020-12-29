<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Website Title -->
    <title>Laravel - Example Landing Page Template With Admin Panel</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500,700&display=swap&subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600&display=swap&subset=latin-ext" rel="stylesheet">
    <link href="{{asset('assets/site/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('assets/site/css/fontawesome-all.css')}}" rel="stylesheet">
    <link href="{{asset('assets/site/css/swiper.css')}}" rel="stylesheet">
    <link href="{{asset('assets/site/css/magnific-popup')}}.css" rel="stylesheet">
    <link href="{{asset('assets/site/css/styles.css')}}" rel="stylesheet">

    <!-- Favicon  -->
    <link rel="icon" href="{{asset('assets/site/images/favicon.png')}}">
</head>
<body data-spy="scroll" data-target=".fixed-top">

<!-- Preloader -->
<div class="spinner-wrapper">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<!-- end of preloader -->


<!-- Navbar -->
<nav class="navbar navbar-expand-md navbar-dark navbar-custom fixed-top">
    <!-- Text Logo - Use this if you don't have a graphic logo -->
    <!-- <a class="navbar-brand logo-text page-scroll" href="index.html">Aria</a> -->

    <!-- Image Logo -->
    <a class="navbar-brand logo-image" href="/"><img src="{{asset('assets/site/images/logo.svg')}}" alt="alternative"></a>

    <!-- Mobile Menu Toggle Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-awesome fas fa-bars"></span>
        <span class="navbar-toggler-awesome fas fa-times"></span>
    </button>
    <!-- end of mobile menu toggle button -->

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link page-scroll" href="#header">HOME <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link page-scroll" href="#intro">INTRO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link page-scroll" href="#services">SERVICES</a>
            </li>
            <li class="nav-item">
                <a class="nav-link page-scroll" href="#callMe">CALL ME</a>
            </li>

            <!-- Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle page-scroll" href="#about" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">ABOUT</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/terms"><span class="item-text">TERMS CONDITIONS</span></a>
                    <div class="dropdown-items-divide-hr"></div>
                    <a class="dropdown-item" href="/privacy-policy"><span class="item-text">PRIVACY POLICY</span></a>
                </div>
            </li>
            <!-- end of dropdown menu -->

            <li class="nav-item">
                <a class="nav-link page-scroll" href="#contact">CONTACT</a>
            </li>
        </ul>
        <span class="nav-item social-icons">
                <span class="fa-stack">
                    <a href="#your-link">
                        <span class="hexagon"></span>
                        <i class="fab fa-facebook-f fa-stack-1x"></i>
                    </a>
                </span>
                <span class="fa-stack">
                    <a href="#your-link">
                        <span class="hexagon"></span>
                        <i class="fab fa-twitter fa-stack-1x"></i>
                    </a>
                </span>
            </span>
    </div>
</nav> <!-- end of navbar -->
<!-- end of navbar -->


@yield('content')


<!-- Footer -->
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="text-container about">
                    <h4>Few Words About Example</h4>
                    <p class="white"><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias eos ex fugit numquam quod sint? Accusantium amet dolores libero pariatur perspiciatis rem unde. Consequatur error facilis impedit natus nisi sapiente!</span><span>Consequatur debitis dolore eligendi fuga fugit harum inventore ipsa iusto minus non nostrum officiis quam quia repudiandae sit tempora temporibus tenetur velit, veniam veritatis? Dolore expedita molestias nemo quisquam suscipit.</span> </p>
                </div> <!-- end of text-container -->
            </div> <!-- end of col -->
            <div class="col-md-2">
                <div class="text-container">
                    <h4>Links</h4>
                    <ul class="list-unstyled li-space-lg white">
                        <li>
                            <a class="white" href="#your-link">lorem.com</a>
                        </li>
                        <li>
                            <a class="white" href="/terms">Terms & Conditions</a>
                        </li>
                        <li>
                            <a class="white" href="/privacy-policy">Privacy Policy</a>
                        </li>
                    </ul>
                </div> <!-- end of text-container -->
            </div> <!-- end of col -->
            <div class="col-md-2">
                <div class="text-container">
                    <h4>Tools</h4>
                    <ul class="list-unstyled li-space-lg">
                        <li>
                            <a class="white" href="#your-link">lorem.com</a>
                        </li>
                        <li>
                            <a class="white" href="#your-link">lorem.com</a>
                        </li>
                        <li class="media">
                            <a class="white" href="#your-link">lorem.net</a>
                        </li>
                    </ul>
                </div> <!-- end of text-container -->
            </div> <!-- end of col -->
            <div class="col-md-2">
                <div class="text-container">
                    <h4>Partners</h4>
                    <ul class="list-unstyled li-space-lg">
                        <li>
                            <a class="white" href="#your-link">lorem.com</a>
                        </li>
                        <li>
                            <a class="white" href="#your-link">lorem.com</a>
                        </li>
                        <li>
                            <a class="white" href="#your-link">lorem.gov</a>
                        </li>
                    </ul>
                </div> <!-- end of text-container -->
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of footer -->
<!-- end of footer -->


<!-- Copyright -->
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="p-small">Copyright © 2020 <a href="https://inovatik.com">Created BY David K.</a></p>
            </div> <!-- end of col -->
        </div> <!-- enf of row -->
    </div> <!-- end of container -->
</div> <!-- end of copyright -->
<!-- end of copyright -->

<!-- Scripts -->
<script src="{{asset('assets/site/js/jquery.min.js')}}"></script> <!-- jQuery for Bootstrap's JavaScript plugins -->
<script src="{{asset('assets/site/js/popper.min.js')}}"></script> <!-- Popper tooltip library for Bootstrap -->
<script src="{{asset('assets/site/js/bootstrap.min.js')}}"></script> <!-- Bootstrap framework -->
<script src="{{asset('assets/site/js/jquery.easing.min.js')}}"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
<script src="{{asset('assets/site/js/swiper.min.js')}}"></script> <!-- Swiper for image and text sliders -->
<script src="{{asset('assets/site/js/jquery.magnific-popup.js')}}"></script> <!-- Magnific Popup for lightboxes -->
<script src="{{asset('assets/site/js/morphext.min.js')}}"></script> <!-- Morphtext rotating text in the header -->
<script src="{{asset('assets/site/js/isotope.pkgd.min.js')}}"></script> <!-- Isotope for filter -->
<script src="{{asset('assets/site/js/validator.min.js')}}"></script> <!-- Validator.js - Bootstrap plugin that validates forms -->
<script src="{{asset('assets/site/js/scripts.js')}}"></script> <!-- Custom scripts -->
</body>
</html>
