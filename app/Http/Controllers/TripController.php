<?php

namespace App\Http\Controllers;

use App\Err\CustomConstants;
use App\Models\Notification;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index() : View
    {
        $trips = Trip::all();
        return view('dashboard.trip.manage',compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() :  View
    {
        return view('dashboard.trip.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'starting_datetime' => 'required',
            'begining' => 'required',
            'destination' => 'required'
        ]);

        if($validator->fails())
        {

            $fields = $validator->getMessageBag()->keys();

            $message = count($fields) > 1 ? "les champs " . implode(',',input_array_scrawler($fields)) . " sont vides" : "le champ " . implode(',',input_array_scrawler($fields)) . " est vide";

            notify()->error($message);

            return redirect()->back();

        }

        try {

            $trip = new Trip();
            $trip->user_id = Auth::user()->id;
            $trip->begining = $request->begining;
            $trip->destination = $request->destination;
            $trip->starting_datetime = $request->starting_datetime;

            $trip->save();

            notify()->success(TRIP_CREATED);

            return redirect()->route('dashboard');

        } catch (\Throwable $th) {

            notify()->error($th->getMessage());

            return redirect()->back();

        }

    }

    public function reserve(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'trip_id' => 'required',
        ]);

        if($validator->fails())
        {

            $fields = $validator->getMessageBag()->keys();

            $message = count($fields) > 1 ? "les champs " . implode(',',input_array_scrawler($fields)) . " sont vides" : "le champ " . implode(',',input_array_scrawler($fields)) . " est vide";

            notify()->error($message);

            return redirect()->back();

        }

        try {

            if($request->has('type'))
            {

                if(in_array(null,[auth()->user()->longitude,auth()->user()->latitude]))
                {

                    notify()->warning("Veuillez ajouter vos coordonnées d\'abord");

                    return redirect()->route('profile');

                }

            }

            $user = User::find(auth()->user()->id);

            $user->booking()->create([
                'trip_id' => $request->trip_id,
                'type' => $request->has('type') ? $request->type : null
            ]);

            Notification::create([
                'user_id' => $user->id,
                'message' => 'Nouvelle réservation effectuée'
            ]);

            $trip = Trip::find($request->trip_id);

            Notification::create([
                'user_id' => $trip->user->id,
                'message' => 'Nouvelle réservation effectuée par ' . auth()->user()->name . ' ' . auth()->user()->surname
            ]);

            $request->has('type') ? notify()->success("Commande effectuée") : notify()->success("Réservation effectuée");

            return redirect()->route('dashboard');

        } catch (\Throwable $th) {

            notify()->error($th->getMessage());

            return redirect()->back();

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Trip $trip) : View
    {
        return view('dashboard.trip.edit',compact('trip'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trip $trip)
    {

        $validator = Validator::make($request->all(),[
            'starting_datetime' => 'required',
            'begining' => 'required',
            'destination' => 'required'
        ]);

        if($validator->fails())
        {

            $fields = $validator->getMessageBag()->keys();

            $message = count($fields) > 1 ? "les champs " . implode(',',input_array_scrawler($fields)) . " sont vides" : "le champ " . implode(',',input_array_scrawler($fields)) . " est vide";

            notify()->error($message);

            return redirect()->back();

        }

        try {
            $trip->begining = $request->begining;
            $trip->destination = $request->destination;
            $trip->starting_datetime = $request->starting_datetime;

            notify()->success(TRIP_UPDATED);

            return redirect()->route('dashboard');

        } catch (\Throwable $th) {

            notify()->error($th->getMessage());

            return redirect()->back();

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip)
    {

        try {

            $trip->delete();

            notify()->success(TRIP_DELETED);

            return redirect()->route('dashboard');

        } catch (\Throwable $th) {

            return response()->json([
                "status" => CustomConstants::$TreatmentError,
                "text" => $th->getMessage()
            ],200);

        }

    }
}
