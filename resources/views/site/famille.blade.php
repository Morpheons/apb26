@extends('site.layout.theme')
@section('titre')
    APB - Atelier Projet Bois
@endsection
@section ('link')
    <link href="{{asset('site/css/composants/famille.css')}}" rel="stylesheet">
    <link href="{{asset('site/css/composants/projet.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid p-0 pb-5" style="@if($famille->fond) background:linear-gradient(to right, rgba(133,78,39,0.8) 0%, rgba(229,178,65,0.8) 100%), url('{{asset('/storage/' .$famille->fond)}}') !important; @endif">
        <div class="row row-col-sm-12 align-items-center p-5">
            <div class="col-lg-6 col-sm-6">
                <div class="row justify-content-center">
                    <div class="col-md-7 text-center">
                        <h1 data-aos="fade-up" data-aos-delay="">
                            <img src="{{asset('/storage/' . $famille->image)}}" class="d-flex mx-auto image-famille" alt="{{$famille->titre}}">
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="row justify-content-center">
                    <div class="col-md-7 text-center">
                        <h1 class="titre" data-aos="fade-up" data-aos-delay="">
                            {{$famille->titre}}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="row align-items-center">
            <h4 class="mb-3">{!! $famille->description !!}</h4>
        </div>
    </div>
    <!-- Feature Start -->
    <div class="container-xxl py-5">
        <div class="container">
            @if(isset($message))
                <div class="row col-lg-12">
                    <p>{{ $message }}</p>
                </div>
            @else
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">
                            Projets clients
                        </a>
                    </li>
                </ul>
                <div class="m-5">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                        @foreach($projets as $projet)
                            <div class="col mb-4">
                                <a href="{{ route('details_projet', \Illuminate\Support\Str::slug($projet->slug)) }}">
                                    <div class="card fond_card_famille" style="@if($famille->fond) background-image: linear-gradient(160deg, rgba(87,52,3,0.72), rgba(201,137,74,0.72)), url('{{asset('/storage/' .$famille->fond)}}') !important @endif;">
                                        <div class="header-famille mx-auto">
                                            <img src="{{asset('/storage/' . $projet->image)}}" class="card-img-top size-image-projet d-flex mx-auto" alt="{{$projet->titre}}" >
                                        </div>
                                        <div class="card-body body-famille ">
                                            <h5 class="card-title text-center title-descriptif-famille">{{$projet->titre}}</h5>
                                            <p class="text-center text-descriptif-famille">{!! strip_tags(\Illuminate\Support\Str::limit($projet->labeltext, 100)); !!} </p>
                                        </div>
                                        <div class="card-footer footer-famille mx-auto">
                                            <a href="{{ route('details_projet', \Illuminate\Support\Str::slug($projet->slug)) }}" class="btn btn-famille en_savoir_plus items-center">En savoir&nbsp;<i class="bi bi-plus-circle"></i></a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Feature Start -->

@endsection
@section('js')

@endsection



