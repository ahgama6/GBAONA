<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    public function driver_c()
    {
        return $this->belongsTo(User::class,'driver');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
