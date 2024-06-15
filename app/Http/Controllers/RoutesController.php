<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Notification;
use App\Models\Role;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class RoutesController extends Controller
{

    public function index()
    {

        $trips = Trip::where('starting_datetime','>=',now())->get();

        $command = Command::class;

        return view('index',compact('trips','command'));

    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        $roles = Role::all();
        return view('register',compact('roles'));
    }

    public function dashboard()
    {
        $user = User::find(auth()->user()->id);
        $trips = $user->trips;
        $bookings = $user->booking;
        return view('dashboard.index',compact('trips','bookings'));
    }

    public function profile()
    {

        return view('dashboard.profile');

    }

    public function notifications()
    {

        return view('dashboard.notifications');

    }

    // public function __destruct()
    // {
    //     if(auth()->user())
    //     {
    //         Notification::where('user_id',auth()->user()->id)->update([
    //             "status" => 1
    //         ]);
    //     }
    // }

}
