@extends('layouts.app')

@section('title')

    Mon compte

@endsection

@section('document')

    <section class="mb-4 pt-4" style="min-height: 440px;">

        @if (Auth::user()->role_id == 2)

            <article class="container pt-4">

                <div class="">

                    <header class="row">
                        <div class="h3 col-lg-8">
                            Mes réservations
                        </div>
                    </header>

                    <div class="">

                        @forelse ($bookings as $booking)

                            <div class="container all-tra">
                                <div class="aldem row">
                                <div class="cardem col-md-3 d-flex align-items-center">
                                    <img src={{ asset('images/Car.png') }} width="85" height="50" class="img-fluid mr-3" alt="Mon image">
                                </div>

                              
                                <div class="cdem col-md-4 ">
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
                                <div class=" col-md-3 ">
                                    <div class="text-container d-flex align-items-center">
                                        <i class="fas fa-clock"></i>
                                        <p>{{ date('d/m/Y - H:i',strtotime($booking->trip->starting_datetime)) }}</p>
                                    </div>
                                </div>
                                <div class=" col-md-2 ">
                                    <form action="{{ route('reserve.cancel') }}" method="post" class="inline-block">

                                        @csrf

                                        <input class="btnew" type="hidden" name="booking_id" value="{{ $booking->id }}">

                                        <input type="submit" value="Annuler" class=" btnew btn btn-danger bg-danger ">

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

        @else

            <article class="container pt-4">

                <div class="">

                    <header class="row">
                        <div class="h3 col-lg-8">
                            {{ auth()->user()->role_id == 1 ? "Réservations en cours" : "Mes réservations" }}
                        </div>
                    </header>

                    <div class="">

                        @forelse ($books as $book)

                            @foreach ($book as $line)

                            <div class="container all-tra">
                                <div class="aldem row">
                                <div class="cardem col-md-3 d-flex align-items-center">
                                    <img src={{ asset('images/Car.png') }} width="85" height="50" class="img-fluid mr-3" alt="Mon image">
                                </div>

                                <div class="cdem col-md-4 ">
                                    <div class=" cdem1 flex-item">
                                        <div class="text-container d-flex align-items-center">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p>{{ $line->trip->begining }}</p>
                                        </div>
                                    </div>
                                    <div class="flex-item">
                                        <div class="text-container d-flex align-items-center">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p>{{ $line->trip->destination }}</p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class=" col-md-3 ">
                                        <div class="text-container d-flex align-items-center">
                                            <i class="fas fa-clock"></i>
                                            <p>{{ date('d/m/Y - H:i',strtotime($line->trip->starting_datetime)) }}</p>
                                        </div>
                                    </div>
                                    <div class=" col-md-2">

                                        @if ($line->type == 'live')

                                            <span class="btnew badge badge-primary bg-primary">Commande</span>

                                        @else

                                            <span class="btnew badge badge-primary bg-primary">Réservation</span>

                                        @endif

                                    </div>
                                    </div>
                                </div>

                            @endforeach



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
