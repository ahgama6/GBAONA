@extends('layouts.app')

@section('title')

    Accueil

@endsection

@section('document')

    <section class="" style="min-height: 500px;">

        <div id="map" style="z-index: 0;">



        </div>

    </section>

@endsection

@push('extra-script')

    <script>

        try {

            var map = L.map('map', {
            center: [2.391236, 6.3702928],
            zoom: 5
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var route = "http://localhost:8000/api/v1/get-drivers"

        var req = new XMLHttpRequest()

        req.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.responseText)

                console.log(this.responseText)

                if(response.status == 200)
                {


                    response.data.forEach(user => {

                        L.marker([user.longitude, user.latitude]).addTo(map)

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

                    });

                }

            }

        }

        req.open('GET',route)
        req.send(null)
            
        } catch (error) {

            console.warn(error + "Custom");
            
        }

    </script>

@endpush
