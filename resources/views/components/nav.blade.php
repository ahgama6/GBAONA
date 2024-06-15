<nav class="cc-navbar navbar navbar-expand-lg bg-body-tertiary" style="z-index: 0;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/GBA_ONA_logo.png') }}" width="85" height="50"  class="d-inline-block align-top" alt="">
          </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item pe-4">
            <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Acceuil</a>
          </li>
          
          

      
          @if (auth()->user())

            <li class="nav-item pe-4">
                <a class="nav-link" href="{{ route('booking.index') }}">Réservations</a>
            </li>

            <li class="nav-item pe-4">
                <a class="nav-link" href="{{ route('command.index') }}">Commandes</a>
            </li>

            

            @if (auth()->user()->role_id == 1)

                {{-- <li class="nav-item pe-4">
                    <a class="nav-link" href="{{ route('booking.index') }}">Réservations</a>
                </li> --}}
               
                <li class="nav-item pe-4">
                  <a class="nav-link" href="{{ route('dashboard') }}">Compte</a>
              </li>
              @else

              <li class="nav-item pe-4">
                <a class="nav-link" href="{{ route('trip.index') }}">Trajets</a>
              </li>
    


            @endif

            <li class="nav-item pe-4">
              <a class="nav-link" href="{{ route('profile') }}">Profile</a>
          </li>

            <li class="nav-item pe-4">
                <a class="nav-link" href="{{ route('logout') }}">Déconnexion</a>
            </li>

          @else

            <li class="nav-item pe-4">
                <a class="nav-link" href="{{ route('login') }}">Compte</a>
            </li>

          @endif

        </ul>
      </div>
    </div>
  </nav>
