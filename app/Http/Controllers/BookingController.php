<?php

namespace App\Http\Controllers;

use App\Err\CustomConstants;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : View
    {
        $user = User::find(auth()->user()->id);
        $bookings = $user->booking;

        $trips = $user->trips;

        $books = [];

        foreach($trips as $trip)
        {
            $books [] = $trip->bookings;
        }

        return view('dashboard.booking.manage',compact('bookings','books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'trip_id' => 'required',
        ]);

        if($validator->fails())
        {

            $fields = $validator->getMessageBag()->keys();

            $message = count($fields) > 1 ? "les champs " . implode(',',input_array_scrawler($fields)) . " sont vides" : "le champ " . implode(',',input_array_scrawler($fields)) . " est vide";

            return response()->json([
                'status' => CustomConstants::$FunctionalError,
                "text" => $message
            ],200);

        }

        try {

            $booking = new Booking;

            $booking->user_id = $request->user_id;
            $booking->trip_id = $request->trip_id;

            return response()->json([
                "status" => CustomConstants::$Success,
                "text" => BOOKING_CREATED
            ],200);

        } catch (\Throwable $th) {

            return response()->json([
                "status" => CustomConstants::$TreatmentError,
                "text" => $th->getMessage()
            ],200);

        }

    }

    public function booking_canceling(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'booking_id' => 'required',
        ]);

        if($validator->fails())
        {

            $fields = $validator->getMessageBag()->keys();

            $message = count($fields) > 1 ? "les champs " . implode(',',input_array_scrawler($fields)) . " sont vides" : "le champ " . implode(',',input_array_scrawler($fields)) . " est vide";

            notify()->error($message);

            return redirect()->back();

        }

        try {

            $booking = Booking::find($request->booking_id);

            $user = User::find(auth()->user()->id);

            $user->notif()->create([
                'message' => 'Vous venez d\'annuler une réservation'
            ]);

            Notification::create([
                'user_id' => $booking->trip->user->id,
                'message' => 'Réservation pour ' . date('H:i',strtotime($booking->trip->starting_datetime)) . ' annulée par ' . auth()->user()->name . ' ' . auth()->user()->surname
            ]);

            $booking->delete() ? notify()->success("Réservation annulée") : notify()->success("Ereur");

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {

        try {

            $booking->delete();

            return response()->json([
                "status" => CustomConstants::$Success,
                "text" => BOOKING_DELETED
            ],200);

        } catch (\Throwable $th) {

            return response()->json([
                "status" => CustomConstants::$TreatmentError,
                "text" => $th->getMessage()
            ],200);

        }

    }
}
