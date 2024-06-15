@extends('layouts.app')

@section('title')

    Mettre à jour le trajet

@endsection

@section('document')

    <section class="mb-4 pt-4" style="min-height: 440px;">

        <article class="container pt-4">

            <div class="">

                <header class="row">
                    <div class="h3 col-lg-8">
                        Mettre à jour le trajet
                    </div>
                    <div class="col-lg-4 text-right">
                        <a href="{{ route('trip.index') }}" class="btn btn-primary">Retour</a>
                    </div>
                </header>

                <div class="pt-4">

                    <form action="{{ route('trip.update',['trip' => $trip->id]) }}" method="post" class="bg-white shadow mt-4 rounded p-4">

                        @csrf

                        @method('put')

                        <div class="mb-4">
                            <label for="date" class="block mb-3">Point de départ</label>
                            <input class="form-control" type="text" name="begining" value="{{ $trip->begining }}" placeholder="Origine">
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block mb-3">Destination</label>
                            <input class="form-control" type="text" name="destination" value="{{ $trip->destination }}" placeholder="Destination">
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block mb-3">Date et heure de départ</label>
                            <input class="form-control" id="date" type="datetime-local" value="{{ date('Y-m-d\TH:i',strtotime($trip->starting_datetime)) }}" name="starting_datetime" placeholder="Destination">
                        </div>

                        <div class="mb-4">
                            <input type="submit" class="btn btn-primary bg-primary" value="Mettre à jour">
                        </div>

                    </form>

                </div>

            </div>

        </article>

    </section>

@endsection
