@extends('layouts.app')

@section('title')

    Mes commandes

@endsection

@section('document')

    <section class="mb-4 pt-4" style="min-height: 440px;">

        <article class="container pt-4">

            <div class="">

                <header class="row">
                    <div class="h3 col-lg-8">
                        Mes commandes
                    </div>
                </header>

                <div class="">

                    @forelse ($commands as $command)

                    <div class="container all-tra">
                        <div class="aldem row">
                        <div class="cardem col-md-4 d-flex align-items-center">
                            <img src={{ asset('images/Car.png') }} width="85" height="50" class="img-fluid mr-3" alt="Mon image">
                        </div>

                            {{-- <div class="cdem col-lg-3 ">
                                <div class=" cdem1 flex-item">
                                    <div class="text-container d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p>{{ $trip->begining }}</p>
                                    </div>
                                </div>
                                <div class="flex-item">
                                    <div class="text-container d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p>{{ $trip->destination }}</p>
                                    </div>
                                </div>
                            </div> --}}
                            @if (auth()->user()->role_id == 1)

                            <div class=" col-md-5 ">
                                    <div class="text-container d-flex align-items-center">
                                        <i class="fas fa-user"></i>
                                        <p>{{ $command->user->name . " " .$command->user->surname }}</p>
                                    </div>
                                </div>

                            @else

                            <div class=" col-md-5 ">
                                <div class="text-container d-flex align-items-center">
                                        <i class="fas fa-user"></i>
                                        <p>{{ $command->driver_c->name . " " .$command->driver_c->surname }}</p>
                                    </div>
                                </div>

                            @endif
                            <div class=" col-md-2">

                                @if (auth()->user()->role_id == 2)

                                    <form action="{{ route('command.destroy',['command' => $command->id]) }}" method="post" class="inline-block">

                                        @csrf

                                        @method('delete')

                                        <input type="submit" value="Annuler" class="btnew btn btn-danger bg-danger ">

                                    </form>

                                @else

                                    <input type="submit" value="Position" data-lng="{{ $command->user->longitude }}" data-ltd="{{ $command->user->latitude }}" class="btnew btn pos-fire btn-primary bg-primary ">

                                @endif

                            </div>
                            </div>
                      </div>

                    @empty

                      <div class="alert alert-primary mt-4">
                        Aucune commande

                    @endforelse

                </div>

            </div>

        </article>

        @if (auth()->user()->role_id == 1)

            <article class="container pt-4">

                <div class="">

                    <header class="row">
                        <div class="h3 col-lg-8">
                            Ma carte
                        </div>
                    </header>

                    <div class="">

                        <div id="map0"></div>

                    </div>

                </div>

            </article>

        @endif

    </section>

@endsection

@push('extra-script')

    <script>

        $(document).ready(function(){

            $('.pos-fire').each(function(){

                $(this).on('click',function(e){

                    var mapElement = document.getElementById('map0')

                    mapElement.scrollIntoView({
                        behavior: 'smooth' // You can also use 'auto' for immediate scrolling
                    });

                    var map = L.map('map0', {
                        center: [$(this).attr('data-lng'), $(this).attr('data-ltd')],
                        zoom: 5
                    });

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(map);

                    var route = "http://localhost:8000/api/v1/get-drivers"

                    var req = new XMLHttpRequest()

                    L.marker([$(this).attr('data-lng'), $(this).attr('data-ltd')]).addTo(map)

                    .bindPopup(`

                        <div class="mb-2">${user.name} ${user.surname}</div>
                        <div class="mb-2">Chauffeur</div>
                        <div>



                            <form action="{{ route('command.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="driver" value="${user.id}" />
                                <button type="submit" class="btn btn-dark bg-dark">Commander</button>
                            </form>

                        </div>

                    `)
                    .openPopup();

                })

            })

        })

    </script>

@endpush
