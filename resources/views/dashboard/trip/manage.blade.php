@extends('layouts.app')

@section('title')

Les réservations disponibles

@endsection

@section('document')

    <section class="mb-4 pt-4" style="min-height: 440px;">

          
        <article class="container pt-4">

           
            <div class="">

                <header class="row">
                    
                    <div class="container">
                        <form class="row">
                            <div class="h3 col-md-6">
                                Les réservations disponibles
                            </div>
                            <div class="col-md-2">
                                <input type="search" class="form-control " placeholder="Départ">
                            </div>
                            <div class="col-md-2">
                                <input type="search" class="form-control " placeholder="Arrivée">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class=" btn btn-primary">Rechercher</button>
                            </div>
                          </form>            
            </div>
                </header>

                <div class="">

                    @forelse ($trips as $trip)

                    <div class="container all-tra">
                        <div class="aldem row">
                        <div class="cardem col-md-4 d-flex align-items-center">
                            <img src={{ asset('images/Car.png') }} width="85" height="50" class="img-fluid mr-3" alt="Mon image">
                            
                        </div>
                      
                      
                        <div class="cdem col-md-3 ">
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
                            </div>
                        <div class=" col-md-3 ">
                            <div class="text-container d-flex align-items-center">
                                <i class="fas fa-clock"></i>
                                <p>{{ date('d/m/Y - H:i',strtotime($trip->starting_datetime)) }}</p>
                            </div>
                        </div>
                            <div class=" col-md-2">

                                @if (auth()->user())

                                    @if (count($trip->reserved) != 0)

                                        <span class="btnew badge bg-success">Réservé</span>

                                    @else

                                        @if (auth()->user()->role_id == 2)

                                            <form action="{{ route('reserve') }}" method="post" class="inline-block">

                                                @csrf

                                                <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                                                <input type="submit" value="Réserver" class="btnew btn btn-primary bg-primary ">

                                            </form>

                                        @endif

                                    @endif

                                @else

                                    @if (auth()->user()->role_id == 2)

                                        <form action="{{ route('reserve') }}" method="post" class="inline-block">

                                            @csrf

                                            <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                                            <input type="submit" value="Réserver" class="btnew btn btn-primary bg-primary ">

                                        </form>

                                    @endif

                                @endif

                            </div>
                            </div>
                      </div>

                    @empty

                      <div class="alert alert-primary mt-4">
                        Aucune réservation disponible
                      </div>

                    @endforelse

                </div>

            </div>

        </article>

    </section>

@endsection
