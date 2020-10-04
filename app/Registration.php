<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function session_registrations()
    {
        return $this->hasMany(Session_registration::class);
    }
}
