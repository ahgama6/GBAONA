@extends('layouts.app')

@section('title')

    Mon compte

@endsection

@section('document')

    <section class="mb-4 pt-4" style="min-height: 440px;">

        @if (Auth::user()->role_id == 1)

            <article class="container pt-4">

                <div class="">

                    <header class="row">
                        <div class="h3 col-lg-8">
                            Mes trajets
                        </div>
                        <div class="col-lg-4 text-right">
                            <a href="{{ route('trip.create') }}" class="btn btn-primary">Ajouter</a>
                        </div>
                    </header>

                    <div class="">

                        @forelse ($trips as $trip)

                        <div class="container all-tra">
                            <div class="aldem row">
                            <div class="cardem col-md-2 d-flex align-items-center">
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
                                
                                    <div class="col-md-2">
                                        <a href="{{ route('trip.edit',['trip' =>  $trip->id]) }}" class=" btnew btn btn-primary block">Modifer</a>
                                    </div>
                                    <div class="col-md-2">
                                        <form action="{{ route('trip.destroy',['trip' => $trip->id]) }}" method="post" class="inline-block  ">

                                            @csrf
    
                                            @method('delete')
    
                                            <input type="submit" value="Supprimer" class=" btnew btn btn-danger bg-danger">
    
                                        </form>
                                    </div>
                                    
                                    
                                
                                </div>
                          </div>

                        @empty

                          <div class="alert alert-primary mt-4">
                            Aucun trajet enregistré
                          </div>

                        @endforelse

                    </div>

                </div>

            </article>

        @else

            <article class="container pt-4">

                <div class="">

                    <header class="row">
                        <div class="h3 col-lg-8">
                            Mes réservations
                        </div>
                    </header>

                    <div class="">

                        @forelse ($bookings as $booking)

                            <div class="container bg-white rounded mt-4">
                                <div class="row">
                                <div class="cardem col-lg-3 text-left">
                                    <img src={{ asset('images/Car.png') }} width="85" height="50" class="img-fluid mr-3" alt="Mon image">
                                </div>

                                <div class="cdem col-lg-3 ">
                                <div class=" cdem1 flex-item">
                                    <div class="text-container d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                    <p>{{ $booking->trip->begining }}</p>
                                    </div>
                                </div>
                                <div class="flex-item">
                                    <div class="text-container d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p>{{ $booking->trip->destination }}</p>
                                    </div>
                                </div>
                                </div>
                                <div class=" col-lg-3 ">
                                    <div class="text-container d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p>{{ date('d/m/Y - H:i',strtotime($booking->trip->starting_datetime)) }}</p>
                                    </div>
                                </div>
                                <div class=" col-lg-3 d-flex align-items-center justify-content-end">
                                    <form action="{{ route('reserve.cancel') }}" method="post" class="inline-block">

                                        @csrf

                                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                                        <input type="submit" value="Annuler" class="btn btn-danger bg-danger ml-4">

                                    </form>
                                </div>
                                </div>
                        </div>

                        @empty

                        <div class="alert alert-primary mt-4">
                            Aucune réservation pour l'instant
                        </div>

                        @endforelse

                    </div>

                </div>

            </article>

        @endif

    </section>

@endsection
