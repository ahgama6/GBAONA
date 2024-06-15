<?php

namespace App\Http\Controllers;

use App\Err\CustomConstants;
use App\Models\Booking;
use App\Models\Command;
use App\Models\Notification;
use App\Models\Role;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;

class ApiController extends Controller
{

    public function create_user(Request $request)
    {

        $controller = new UserController;

        $response = $controller->store($request);

        return $response;

    }

    public function update_user(Request $request)
    {

        $controller = new UserController;

        $user = User::find($request->user_id);

        $controller->update($request,$user);

    }

    public function delete_user(Request $request)
    {

        $controller = new UserController;

        $user = User::find($request->user_id);

        $controller->destroy($user);

    }

    // Trip handling

    public function create_trip(Request $request)
    {

        $controller = new TripController;

        $controller->store($request);

    }

    public function update_trip(Request $request)
    {

        $controller = new TripController;

        $trip = Trip::find($request->trip_id);

        $controller->update($request,$trip);

    }

    public function delete_trip(Request $request)
    {

        $controller = new TripController;

        $trip = Trip::find($request->trip_id);

        $controller->destroy($trip);

    }

    // Booking handling

    public function create_bookin(Request $request)
    {

        $controller = new BookingController;

        $controller->store($request);

    }

    public function delete_booking(Request $request)
    {

        $controller = new BookingController;

        $booking = Booking::find($request->booking_id);

        $controller->destroy($booking);

    }

    // Notifications

    public function get_notifications(Request $request)
    {

        $user = User::find($request->user_id);

        return response()->json([
            "status" => CustomConstants::$Success,
            "data" => $user->Notif
        ],200);

    }

    // Get roles

    public function get_roles()
    {

        return response()->json([
            "status" => CustomConstants::$Success,
            "data" => Role::all()
        ],200);

    }

    public function get_trips()
    {

        $now = Carbon::today();

        return response()->json([
            "status" => CustomConstants::$Success,
            "data" => Trip::
                        with('user')
                        ->selectRaw('trips.*, DATE_FORMAT(starting_datetime, "%Y-%m-%d %H:%i") as formatted_starting_datetime')
                        ->where('starting_datetime','>=',$now)
                        ->get()
        ],200);

    }

    public function get_drivers()
    {

        return response()->json([
            "status" => CustomConstants::$Success,
            "data" => User::where('role_id',1)->where("longitude","<>",null)->get()
        ],200);

    }

    public function getCommandCount(Request $request)
    {
        $driverId = $request->input('driverId');

        $count = Command::where('user_id', auth()->user()->id)
            ->where('driver', $driverId)
            ->whereDate('created_at', now()->format('Y-m-d'))
            ->count();

        return response()->json(['count' => $count],200);
    }


}
