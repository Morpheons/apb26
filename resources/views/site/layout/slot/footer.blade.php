
<!-- Footer Start -->
<div class="container-fluid bg-dark text-light footer wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Adresse</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>28 Za de Kerbiquet 29260 Plouider</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+33 (0)6 33 35 54 41</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>atelierprojetsbois@gmail.com</p>
                <div class="d-flex pt-2">

                    <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/profile.php?id=100087487548677"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href="https://www.instagram.com/atelierprojetsbois/?fbclid=IwZXh0bgNhZW0CMTAAAR3g5VCweZKzJCPy3TqyB8bVo6qf5wQ0qXHPniSYjoX_n78QCLi8e-QIn0w_aem_2AEpTIei84bpIQAF0c9_LQ"><i class="fab fa-instagram"></i></a>

                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Services</h4>
                @foreach($familles as $famille)
                    <a class="btn btn-link" href="{{ route('details_famille', \Illuminate\Support\Str::slug($famille->slug)) }}">{{$famille->titre}}</a>
                @endforeach

            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Menu rapide</h4>
                <a class="btn btn-link" href="{{route('accueil')}}">Accueil</a>
                <a class="btn btn-link" href="{{route('apropos')}}">A propos</a>
                <a class="btn btn-link" href="{{route('accueil')}}#services">Menuiseries</a>
                <a class="btn btn-link" href="{{route('contact')}}">Contact</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-img-container">
                    <img src="{{asset('site/img/site/acceuil.jpg')}}" class="img-fluid" alt="Atelier Projets Bois">
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">APB-Atelier Projets Bois</a>, tous droits réservés.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Dégoupillé par <a class="border-bottom" href="https://e2h.fr"><img src="https://e2h.fr/assets/img/logo/logo-e2h-Lbleu-Tblanc.svg" width="10%" alt="e2h"/></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->
