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
        <div class="container">
            <div class="row row-col-sm-12 align-items-center p-5">
                <div class="col-lg-6 col-sm-6">
                    <div class="row justify-content-center">
                        <div class="col-md-7 text-center">
                            <h1 data-aos="fade-up" data-aos-delay="">
                                <img src="{{asset('/storage/' . $projet->image)}}" class="d-flex mx-auto image-famille" alt="{{$projet->titre}}">
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="row justify-content-center">
                        <div class="col-md-7 text-center">
                            <h1 class="titre" data-aos="fade-up" data-aos-delay="">
                                {{$projet->titre}}
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="container-xxl py-5">--}}
{{--        <div class="row align-items-center">--}}
{{--            <h4 class="mb-3">{!! $projet->description !!}</h4>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <div class="mb-3 page-content">
                    {!! $projet->description !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection



