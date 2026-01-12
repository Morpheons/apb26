<!-- Topbar Start -->
<div class="container-fluid bg-light p-0 fd-topbar">
    <div class="row gx-0 d-none d-lg-flex">
        <div class="col-lg-7 px-5 text-start">
            <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                <small class="fa fa-map-marker-alt text-primary me-2"></small>
                <small>28 Za de Kerbiquet 29260 Plouider</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center py-3">
                <small class="far fa-clock text-primary me-2"></small>
                <small>Lundi - vendredi : 08:00 - 17:00</small>
            </div>
        </div>
        <div class="col-lg-5 px-5 text-end">
            <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                <small class="fa fa-phone-alt text-primary me-2"></small>
                <small>+33 (0)6 33 35 54 41</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center">
                <a class="btn btn-sm-square text-primary me-1"
                   href="https://www.facebook.com/profile.php?id=100087487548677">
                   <i class="fab fa-facebook-f"></i>
                </a>
                <a class="btn btn-sm-square text-primary me-0"
                   href="https://www.instagram.com/atelierprojetsbois/?fbclid=IwZXh0bgNhZW0CMTAAAR3g5VCweZKzJCPy3TqyB8bVo6qf5wQ0qXHPniSYjoX_n78QCLi8e-QIn0w_aem_2AEpTIei84bpIQAF0c9_LQ">
                   <i class="fab fa-instagram"></i>
                </a>
                @auth
                    <a href="{{ url('/apb') }}"
                       class="rounded-md px-3 py-2
                         text-black ring-1 ring-transparent transition
                         hover:text-black/70 focus:outline-none
                         focus-visible:ring-[#FF2D20]
                         dark:text-white
                         dark:hover:text-white/80
                         dark:focus-visible:ring-white">
                       <i class="fas fa-desktop"></i>
                    </a>
                @else
                    <a href="{{ url('/apb/login') }}"
                       class="rounded-md px-3 py-2
                         text-black ring-1 ring-transparent transition
                         hover:text-black/70 focus:outline-none
                         focus-visible:ring-[#FF2D20]
                         dark:text-white
                         dark:hover:text-white/80
                         dark:focus-visible:ring-white">
                       <i class="fas fa-sign-in-alt"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->
