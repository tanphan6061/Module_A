<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function session_registrations()
    {
        return $this->hasMany(Session_registration::class);
    }
}
