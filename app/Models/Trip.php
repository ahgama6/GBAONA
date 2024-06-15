<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reserved()
    {

        $user = auth()->user();
        return $this->bookings()->where('user_id', $user->id);

    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

}
