@extends('layouts.app')

@section('title')

    Mon compte

@endsection

@section('document')

    <section class="mb-4 pt-4" style="min-height: 440px;">

        <article class="container pt-4">

            <div class="">

                <header class="row">
                    <div class="h3 col-lg-8">
                        Mon profile
                    </div>
                </header>

                <div class="">

                    <div class="mt-4">
                        <span class="alert alert-primary">
                            Compte - {{ Auth::user()->role->label }}
                        </span>
                    </div>

                    <div class="mt-4 pt-4">

                        <div class="">
                            <span class="fw-bold">Nom complet > </span>
                            <span class="text-lowercase">{{ Auth::user()->name . ' ' . Auth::user()->surname }}</span>
                        </div>

                        <div class="mt-4">
                            <span class="fw-bold">Email > </span>
                            <span class="text-lowercase">{{ Auth::user()->email }}</span>
                        </div>

                        <div class="mt-4">
                            <form action="{{ route('position.set') }}" name="poseForm" id="position-form" method="post">
                                @csrf
                                <input type="hidden" name="longitude">
                                <input type="hidden" name="latitude">
                            </form>
                            @if (auth()->user()->longitude == null)
                                <button id="set-position" class="btn btn-primary bg-primary">Ajouter ma localisation</button>
                            @else
                                <button id="cancel-position" class="btn btn-danger">Retirer ma localisation</button>
                            @endif
                        </div>
                        
                    </div>

                    <hr class="mt-4">

                    <div class="mt-4">

                        <form action="{{ route('password.change') }}" method="post" class="bg-white rounded p-4">

                            @csrf

                            <header class="fw-bold mb-4">
                                Modifier le mot de passe
                            </header>

                            <div class="mb-4">
                                <label for="old" class="mb-2">Mot de passe actuel <span class="fw-bold text-danger">*</span></label>
                                <input type="password" name="old" placeholder="Mot de passe actuel" id="old" class="form-control">
                            </div>

                            <div class="mb-4">
                                <label for="new" class="mb-2">Nouveau mot de passe <span class="fw-bold text-danger">*</span></label>
                                <input type="password" name="new" placeholder="Nouveau mot de passe" id="new" class="form-control">
                            </div>

                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary bg-primary">Changer le mot de passe</button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </article>

    </section>

@endsection


@push('extra-script')

    <script>

        document.getElementById('set-position').addEventListener('click', e => {

            const options = {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0,
            };

            async function success(pos) {
                const crd = pos.coords;

                const fillForm = () => {

                    var randomValue = Math.random();

                    // Scale and shift the random number to the desired range
                    var minValue = 2.3912362;
                    var maxValue = 2.5;
                    var randomInRange = minValue + (randomValue * (maxValue - minValue));

                    return new Promise((resolve,reject) => {

                        document.forms['poseForm']['latitude'].value = crd.latitude
                        document.forms['poseForm']['longitude'].value = randomInRange * 1.1

                        resolve(true)

                    })

                }

                await fillForm().then(res => document.forms['poseForm'].submit())

            }

            function error(err) {
                console.warn(`ERROR(${err.code}): ${err.message}`);
            }

            navigator.geolocation.getCurrentPosition(success, error, options);

        })
        

    </script>

@endpush
