@extends('layouts.app')

@section('title')

    Mes notifications

@endsection

@section('document')

    <section class="mb-4 pt-4" style="min-height: 440px;">

        <article class="container pt-4">

            <div class="">

                <header class="row">
                    <div class="h3 col-lg-8">
                        Mes notifications
                    </div>
                </header>

                <div class="">

                    @forelse (get_notifications() as $notification)

                        <div class="alert alert-info mt-4">

                            {{ $notification->message }}

                        </div>

                    @empty

                      <div class="alert alert-primary mt-4">
                        Aucune notification pour le moment
                      </div>

                    @endforelse

                </div>

            </div>

        </article>

    </section>

@endsection
