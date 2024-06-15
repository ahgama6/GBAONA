@extends('layouts.app')

@section('title')

    Se connecter

@endsection

@section('document')

    <section class="mb-4 d-flex align-items-center justify-content-center" style="min-height: 440px;">

        <div >
            {{-- <img src="{{ asset('images/GBA_ONA_logo.png') }}" class=" imgins  mx-auto d-block" alt=""> --}}
          </div>
          <div class="wrapper mt-4" style="border-radius: 10px;">
            <p class="pisn h3">Se connecter  </p>
            <form class="formins" method="post" action="{{ route('authenticate') }}">

                @csrf

              <input class="inputins" type="email" name="email" placeholder="Email">
              <input class="inputins" type="password" name="password" placeholder="Votre mot de passe">
              <p class="recover">
                <a class="ains" href="#">Mot de passe oublié </a>
              </p>
              <button class="butins">S'identifier</button>

            </form>

            <div class="not-member">
              J’ai pas de compte <a class="ins" href="{{ route('register') }}">S'inscrire</a>
            </div>
          </div>

    </section>

@endsection
