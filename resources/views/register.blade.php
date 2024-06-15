@extends('layouts.app')

@section('title')

    S'inscrire

@endsection

@section('document')

    <section class="mb-4 d-flex align-items-center justify-content-center" style="min-height: 440px;">

        <div >
            {{-- <img src="{{ asset('images/GBA_ONA_logo.png') }}" class=" imgins  mx-auto d-block" alt=""> --}}
          </div>
          <div class="wrapper mt-4" style="border-radius: 10px;">
            <p class="pisn h3">S'inscrire  </p>
            <form class="formins" method="post" action="{{ route('user.store') }}">

                @csrf

              <input class="inputins" type="text" name="name" placeholder="Nom">
              <input class="inputins" type="text" name="surname" placeholder="Prénom">
              <input class="inputins" type="email" name="email" placeholder="Email">
              <input class="inputins" type="password" name="password" placeholder="Votre mot de passe">
              <select name="role_id" id="" class="inputins">

                <option value="">--- Choisissez votre profile ---</option>

                @forelse ($roles as $role)

                    <option value="{{ $role->id }}">{{ $role->label }}</option>

                @empty

                @endforelse

              </select>
              <button class="butins">S'inscire</button>

            </form>

            <div class="not-member">
              J’ai un compte <a class="ins" href="{{ route('login') }}">Se connecter</a>
            </div>
          </div>

    </section>

@endsection
