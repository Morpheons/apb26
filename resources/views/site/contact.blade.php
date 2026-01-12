@extends('site.layout.theme')
@section('titre')
    APB - Contact
@endsection

@section ('link')
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')

    <!-- Contact Start -->
    <div class="container-fluid bg-light overflow-hidden px-lg-0" style="margin: 6rem 0;">
        <div class="container contact px-lg-0">
            <div class="row g-0 mx-lg-0">
                <div class="col-lg-6 contact-text py-5 wow fadeIn" data-wow-delay="0.5s">
                    <div class="p-lg-5 ps-lg-0">
                        <div class="text-start">
                            <h1 class="display-5 mb-4 titre-souligne">Contactez nous</h1>
                        </div>
                        <p class="mb-4 description">
                            Merci d'avoir pris de votre temps pour nous contacter.<br>
                            Je traiterais votre message dès que possible et je reviendrais vers vous afin que nous puissions échanger ensemble.<br>
                            Merci de remplir les champs demandés ci-contre.
                        </p>
                        <form  method="POST" action="{{ route('envoimessage') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="votre prénom" required>
                                        <label for="firstname">Votre prénom</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="votre nom" required>
                                        <label for="name">Votre nom</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="votre Email" required>
                                        <label for="email">Votre email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="telephone" id="telephone" placeholder="votre numero de téléphone pour vous faire rappeler" required>
                                        <label for="telephone">Votre télephone</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                                        <label for="subject">Sujet</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="message" placeholder="Leave a message here" id="message" style="height: 100px" required></textarea>
                                        <label for="message">Message</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn-bleu-bois w-100 py-3" type="submit">Envoi message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 pe-lg-0" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <iframe class="position-absolute w-100 h-100" style="object-fit: cover;"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3129.5487470541707!2d-4.293648523255528!3d48.6040556185709!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4816aae356fab00d%3A0xc1f292f104135561!2s28%20Za%20de%20Kerbiquet%2C%2029260%20Plouider!5e1!3m2!1sfr!2sfr!4v1724424357919!5m2!1sfr!2sfr"
                                frameborder="0" allowfullscreen="" aria-hidden="false"
                                tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


@endsection
@section('js')
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script type="text/javascript">
        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif

        @if($errors->any())
        toastr.error("Il y a eu une erreur lors de l'envoi du message. Veuillez vérifier les champs.");
        @endif
    </script>
@endsection



