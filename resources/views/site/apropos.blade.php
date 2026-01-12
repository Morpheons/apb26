@extends('site.layout.theme')
@section('titre')
    APB - A propos
@endsection

@section ('link')

@endsection

@section('content')

    <!-- About Start -->
    <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0">
        <div class="container about px-lg-0">
            <div class="row g-0 mx-lg-0">
                <div class="col-lg-6 ps-lg-0" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class=" img-fluid w-100 h-100" src="{{asset('/site/img/site/apropos/2.jpg')}}" style="object-fit: cover;" alt="">
                    </div>
                </div>
                <div class="col-lg-6 about-text py-5 wow fadeIn" data-wow-delay="0.5s">
                    <div class="p-lg-5 pe-lg-0">
                        <div class="text-start">
                            <h1 class="display-5 mb-4 titre-souligne">A propos de nous</h1>
                        </div>
                        <p class="description mb-4 pb-2">
                            Créée en 2022 , l'entreprise ATELIER PROJETS BOIS située à Plouider dans le Finistère nord
                            est spécialisée dans tous les travaux d'aménagement intérieur et extérieur.<br>
                            <br>
                            Entreprise de menuiserie gérée par Joël Fracca, titulaire
                            <ul class="description">
                                <li>d'un bac STI génie mécanique option Bois,</li>
                                <li>d'un CAP/BP menuiserie</li>
                                <li>et d'un long et riche parcours sur le tour de France avec les compagnons du devoir.</li>
                            </ul>
                            <br>
                            <span class="description">
                            L' entreprise embauche un apprenti en alternance et régulièrement des jeunes compagnons durant leur tour de France.<br>
                            Nous travaillons principalement sur des chantiers en rénovation mais aussi en constructions neuves sans oublier les professionnels (aménagement de magasins, collectivité...)<br>
                            Nous fabriquons sur mesure en atelier et nous assurons le chantier de A à Z avec une pose soigneuse.<br>
                            Les différents projets sont abordés de manière traditionnelle mais étudiés sur support numérique.<br>
                            Des plans 3D peuvent être fournis pour faciliter la compréhension des ouvrages.<br>
                            Nous mettrons tout en œuvre pour fabriquer vos projets dans un esprit artisanal traditionnel et bienveillant.<br><br></span>
                        </p>
                        <div class="row g-4 mb-4 pb-2">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                        <i class="fa fa-users fa-2x text-blueapb"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h2 class="text-blueapb mb-1" data-toggle="counter-up">30</h2>
                                        <p class="fw-medium mb-0 description">Clients satisfaits</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                        <i class="fa fa-check fa-2x text-blueapb"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h2 class="text-blueapb mb-1" data-toggle="counter-up">20</h2>
                                        <p class="fw-medium mb-0 description">Projets proposés</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


@endsection
@section('js')

@endsection


