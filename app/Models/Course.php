<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }
}
