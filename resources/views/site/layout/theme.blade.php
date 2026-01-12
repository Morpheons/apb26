<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>@yield('titre')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="APB - https://apb.e2h.fr/">
    <meta name="title" content="APB - Atelier Projet Bois">
    <meta name="Generator" content="APB - Copyright (C) 2024 - Atelier Projet Bois. All rights reserved." />
    <meta name="description" content="Nous sommes une société de services de menuiserie sur mesure, agencement extérieur, escaliers, menuiserie intérieure.">
    <meta name="keywords" content="apb, APB, Atelier Projet Bois, meubles, meuble, escalier, escaliers, portes, porte, pergola, pergolas, bois, dressing, cuisine, cuisines">

    <!-- Open Graph / Facebook -->
    <meta property="og:site_name" content="APB - Atelier Projet Bois" />
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://apb.e2h.fr/">
    <meta property="og:title" content="APB - Atelier Projet Bois">
    <meta property="og:description" content="Nous sommes une société de services de menuiserie sur mesure, agencement extérieur, escaliers, menuiserie intérieure.">
    <meta property="og:image" content="https://apb.e2h.fr/site/img/tag/tag2.png">

    <!-- Twitter -->
    <meta property="twitter:site_name" content="APB - Atelier Projet Bois" />
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://apb.e2h.fr/">
    <meta property="twitter:title" content="APB - Atelier Projet Bois">
    <meta property="twitter:description" content="Nous sommes une société de services de menuiserie sur mesure, agencement extérieur, escaliers, menuiserie intérieure.">
    <meta property="twitter:image" content="https://apb.e2h.fr/site/img/tag/tag2.png">

    <!-- Favicon -->
    <link href="{{asset('favicon.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bad+Script&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('site/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('site/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('site/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('site/css/layout.css')}}" rel="stylesheet">
    <link href="{{asset('site/css/style.css')}}" rel="stylesheet">
    @yield('link')
</head>

<body>
<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->
@include('site.layout.slot.topbar')
@include('site.layout.slot.navbar')
@yield('content')
@include('site.layout.slot.footer')


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top"><i class="bi bi-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('site/lib/wow/wow.min.js')}}"></script>
<script src="{{asset('site/lib/easing/easing.min.js')}}"></script>
<script src="{{asset('site/lib/waypoints/waypoints.min.js')}}"></script>
<script src="{{asset('site/lib/counterup/counterup.min.js')}}"></script>

<script src="{{asset('site/lib/isotope/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('site/lib/lightbox/js/lightbox.min.js')}}"></script>

<!-- Template Javascript -->
<script src="{{asset('site/js/main.js')}}"></script>
@yield('js')
</body>

</html>
