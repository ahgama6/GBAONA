<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [RoutesController::class,'index'])->name('home');

Route::get('/login', [RoutesController::class,'login'])->name('login');

Route::get('/register', [RoutesController::class,'register'])->name('register');

Route::post('authenticate',[AuthController::class,'Authenticate'])->name('authenticate');

Route::resource('user',UserController::class);
Route::resource('trip',TripController::class);
Route::resource('command',CommandController::class);

Route::middleware('auth')->prefix('dashboard')->group(function(){

    Route::get('/',[RoutesController::class,'dashboard'])->name('dashboard');

    Route::get('/profile',[RoutesController::class,'profile'])->name('profile');

    Route::post('/set-position',[UserController::class,'add_localization'])->name('position.set');

    Route::get('/notifications',[RoutesController::class,'notifications'])->name('notifications');

    Route::post('/reserve',[TripController::class,'reserve'])->name('reserve');

    Route::post('/reserve-cancel',[BookingController::class,'booking_canceling'])->name('reserve.cancel');

    Route::post('/change-password',[UserController::class,'change_password'])->name('password.change');

    Route::resource('booking',BookingController::class);

    Route::get('/logout',[AuthController::class,'logout'])->name('logout');

});
