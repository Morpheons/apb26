@extends('site.layout.theme')
@section('titre')
    APB - Atelier Projets Bois
@endsection
@section ('link')
    <link href="{{asset('site/css/composants/famille.css')}}" rel="stylesheet">
    <link href="{{asset('site/css/composants/accueil.css')}}" rel="stylesheet">
@endsection
@section('content')
    <!-- Header -->
    <div class="container-fluid p-0">
        <div class="hero-header-fullscreen">
            <img src="{{asset('site/img/site/header.jpg')}}" alt="Atelier Projets Bois">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" >
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10 text-center">
                            <h5 class="display-5 text-header mb-3 animated slideInDown">Bienvenue à Atelier Projet Bois - Joel Fracca</h5>
                            <h1 class="display-4 title-bois fw-bold animated slideInDown mb-4">
                                MENUISIER AGENCEUR SUR MESURE<br>
                                <span class="fs-2 fw-light">Conception, fabrication et pose</span>
                            </h1>
                            <p class="fs-5 mb-5 mx-auto" style="max-width: 800px;">
                                Nous concevons tout type d'ouvrage de menuiserie sur mesure (escaliers, portails, portes, dressing, restauration d'ouvrages anciens, cuisines etc...).
                            </p>

                                <a href="{{route('accueil')}}#services"
                                   class="btn-rouge-relief">
                                    En savoir <i class="bi bi-plus-circle ms-2"></i>
                                </a>
{{--                            <a href="{{route('accueil')}}#services" class="btn btn-custom-texture py-3 px-5 animated slideInLeft">--}}
{{--                                En Savoir +--}}
{{--                            </a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Header -->
    <!-- Content -->
    <div class="fd-content">
        <div class="container-fluid info-bandeau-wrapper">
            <div class="container">
                <div class="info-bandeau shadow-sm">
                    <div class="row g-0 info-mobile">
                        <div class="col-3">
                            <div class="info-box">
                                <i class="fa fa-user-check info-icon"></i>
                                <span class="info-number">01</span>
                                <p class="info-text">Créations</p>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="info-box">
                                <i class="fa fa-check info-icon"></i>
                                <span class="info-number">02</span>
                                <p class="info-text">Patrimoine</p>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="info-box">
                                <i class="fa fa-cube info-icon"></i>
                                <span class="info-number">03</span>
                                <p class="info-text">Visuel</p>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="info-box">
                                <i class="fa fa-drafting-compass info-icon"></i>
                                <span class="info-number">04</span>
                                <p class="info-text">Devis</p>
                            </div>
                        </div>
                    </div>

                </div>

        </div>
        <div class="container-xxl py-5" id="services">
            <div class="container">
                <div class="text-center">
                    <h1 class="display-5 mb-5 titre-souligne">Nos réalisations</h1>
                </div>
                <div class="row g-4">
                    @foreach($familles as $famille)
                        <div class="col-12 col-sm-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm famille-card">

                                {{-- Image --}}
                                <div class="famille-img-wrapper">
                                    <img
                                        src="{{ asset('/storage/' . $famille->image) }}"
                                        alt="{{ $famille->titre }}"
                                        class="famille-img"
                                    >
                                </div>

                                {{-- Contenu --}}
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title fw-semibold">
                                        {{ $famille->titre }}
                                    </h5>
                                    <p class="card-text text-muted small flex-grow-1">
                                        {!! strip_tags(\Illuminate\Support\Str::limit($famille->labeltext, 70)) !!}
                                    </p>
                                    <a href="{{ route('details_famille', \Illuminate\Support\Str::slug($famille->slug)) }}"
                                       class="btn-bleu-bois mt-3 align-self-center">
                                        En savoir plus <i class="bi bi-arrow-right ms-2"></i>
                                    </a>

                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="container-fluid feature-section p-0">
            <div class="feature-row-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 feature-content py-5">
                            <div class="pe-lg-5">
                                <div class="">
                                    <h1 class="display-5 mb-4 titre-souligne">Pourquoi nous choisir</h1>
                                </div>
                                <p class="description mb-5">
                                    Un service artisanal sérieux et consciencieux.<br>
                                    Une étude attentive de vos demandes afin de trouver la solution adaptée à votre projet.
                                </p>

                                <div class="row g-4">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white shadow-sm rounded" style="width: 60px; height: 60px;">
                                                <i class="fa fa-check fa-2x" style="color: #002b5b;"></i>
                                            </div>
                                            <div class="ms-4">
                                                <p class="mb-1 text-choisir small">Qualité</p>
                                                <h5 class="mb-0 text-choisir">Services</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white shadow-sm rounded" style="width: 60px; height: 60px;">
                                                <i class="fa fa-user-check fa-2x" style="color: #002b5b;"></i>
                                            </div>
                                            <div class="ms-4">
                                                <p class="mb-1 text-choisir small">Créativité</p>
                                                <h5 class="mb-0 text-choisir">Design</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white shadow-sm rounded" style="width: 60px; height: 60px;">
                                                <i class="fa fa-drafting-compass fa-2x" style="color: #002b5b;"></i>
                                            </div>
                                            <div class="ms-4">
                                                <p class="mb-1 text-choisir small">Devis</p>
                                                <h5 class="mb-0 text-choisir">Gratuit</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white shadow-sm rounded" style="width: 60px; height: 60px;">
                                                <i class="fa fa-headphones fa-2x" style="color: #002b5b;"></i>
                                            </div>
                                            <div class="ms-4">
                                                <p class="mb-1 text-choisir small">Client</p>
                                                <h5 class="mb-0 text-choisir">Support</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
    <!-- Avis -->
    <div class="container-fluid fadeInUp px-lg-0 fd-avis" data-wow-delay="0.1s">
        <div class="container mt-5 p-5 ">
            <div class="text-center">
                <h1 class="display-5 mb-5 titre-souligne">Avis clients</h1>
            </div>

            @if($avis == null || count($avis) == 0)
                <h4 class="text-center">Nous n'avons pas encore eu d'avis client</h4>
            @else
                <div id="carouselExample" class="carousel slide mx-auto" style="max-width: 800px;">

                    <div class="carousel-inner">
                        @foreach ($avis as $index => $notification)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }} text-center fd-boxvoile">

                                <div class="d-flex justify-content-center">
                                    <div class="px-3 py-2 text-dark-blue" style="color: #002b5c; font-weight: 500; font-size: 1.1rem;">
                                        {!! $notification->description !!}
                                    </div>
                                </div>

                                <div class="my-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $notification->note ? '-fill rating' : '' }}"></i>
                                    @endfor
                                </div>
                                <p class="fst-italic fw-bold text-dark-blue">{{$notification->client}}</p>

                                <div class="d-flex justify-content-center mt-3 pb-5">
                                    <a href="{{ route('details_projet', \Illuminate\Support\Str::slug($notification->projet->slug)) }}"
                                       class="btn-rouge-relief">
                                        En savoir <i class="bi bi-plus-circle ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <i class="bi bi-chevron-compact-left carousel-custom-icon"></i>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <i class="bi bi-chevron-compact-right carousel-custom-icon"></i>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <!-- End Avis -->
@endsection
@section('js')
@endsection


