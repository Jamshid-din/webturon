<!doctype html>
<html class="no-js" lang="en">

<head>
    <!--====== USEFULL META ======-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Transportation & Agency Template is a simple Smooth transportation and Agency Based Template" />
    <meta name="keywords" content="Portfolio, Agency, Onepage, Html, Business, Blog, Parallax" />
    <link rel="icon" type="image/png" href="{{ asset('images') }}/1.png">


    <!--====== TITLE TAG ======-->
    <title>Turon WEB</title>

    <!--====== FAVICON ICON =======-->
    <link rel="shortcut icon" type="image/ico" href="">
    

    <!--====== STYLESHEETS ======-->
    <link rel="stylesheet" href="{{ asset ("css/normalize.css") }}">
    <link rel="stylesheet" href="{{ asset ("css/animate.css") }}">
    <link rel="stylesheet" href="{{ asset ("css/stellarnav.min.css") }}">
    <link rel="stylesheet" href="{{ asset ("css/owl.carousel.css") }}">
    <link rel="stylesheet" href="{{ asset ("css/bootstrap.min.css") }}" >
    <link rel="stylesheet" href="{{ asset ("css/font-awesome.min.css") }}" >
    <link rel="stylesheet" href="{{ asset ("css/slides.css") }}">
    <link rel="stylesheet" href="{{ asset ("style.css") }}">
    <link rel="stylesheet" href="{{ asset ("css/responsive.css") }}" >
    <link rel="stylesheet" href="{{ asset ("css/cdn.tables.css") }}">


</head>

<body class="home-one">

 

    <!--- PRELOADER -->
    <div class="preeloader">
        <div class="preloader-spinner"></div>
    </div>


    
    <!--SCROLL TO TOP-->
    <a href="#home" class="scrolltotop"><i class="fa fa-long-arrow-up"></i></a>
    <!-- Header -->
    @include('layouts.header',  ['models' => $models??''])
    
    
    <!-- Service -->

    @yield('content')
    


    <!-- Footer -->
    @include('layouts.footer')
    <!--====== SCRIPTS JS ======-->
    <script src="{{ asset ("js/jquery.min.js") }}"></script>
    <script src="{{ asset('js/treeview.js') }}"></script>
    <script src="{{ asset ("js/vendor/jquery-1.12.4.min.js") }}"></script>
    <script src="{{ asset ("js/vendor/bootstrap.min.js") }}"></script>
    <script src="{{ asset ("js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset ("js/jquery.fixedheadertable.min.js") }}"></script>
    <!--====== PLUGINS JS ======-->
    <script src="{{ asset ("js/vendor/jquery.easing.1.3.js") }}"></script>
    <script src="{{ asset ("js/vendor/jquery-migrate-1.2.1.min.js") }}"></script>
    <script src="{{ asset ("js/vendor/jquery.appear.js") }}"></script>
    <script src="{{ asset ("js/owl.carousel.min.js") }}"></script>
    <script src="{{ asset ("js/stellar.js") }}"></script>
    <script src="{{ asset ("js/wow.min.js") }}"></script>
    <script src="{{ asset ("js/stellarnav.min.js") }}"></script>
    <script src="{{ asset ("js/contact-form.js") }}"></script>
    <script src="{{ asset ("js/jquery.sticky.js") }}"></script>
    

    <!--===== ACTIVE JS=====-->
    <script src="{{ asset ("js/main.js") }}"></script>
</body>

</html>
