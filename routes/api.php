<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1/')->group(function(){

    Route::post('authenticate',[AuthController::class,'Authenticate']);

    Route::post('create-user',[ApiController::class,'create_user']);
    Route::post('update-user',[ApiController::class,'update_user']);
    Route::post('destroy-user',[ApiController::class,'destroy_user']);

    Route::post('create-trip',[ApiController::class,'create_trip']);
    Route::post('update-trip',[ApiController::class,'update_trip']);
    Route::post('destroy-trip',[ApiController::class,'destroy_trip']);

    Route::post('create-booking',[ApiController::class,'create_booking']);
    Route::post('destroy-booking',[ApiController::class,'destroy_booking']);

    Route::post('get-notifications',[ApiController::class,'get_notifications']);

    Route::get('get-roles',[ApiController::class,'get_roles']);

    Route::get('get-trips',[ApiController::class,'get_trips']);

    Route::get('get-drivers',[ApiController::class,'get_drivers']);

    Route::get('get-commands',[ApiController::class,'getCommandCount']);

});
