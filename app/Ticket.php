<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'event_tickets';

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function available()
    {
        $validity = json_decode($this->special_validity);
        if ($validity) {
            if ($validity->type == 'date') {
                $today = new \DateTime();
                $date = new \DateTime($validity->date);
                if ($today > $date) return false;
            } else if ($validity->type == 'amount') {
                if ($validity->amount <= $this->registrations()->count())
                    return false;
            }
        }
        return true;
    }

    public function description()
    {
        $validity = json_decode($this->special_validity);
        if ($validity) {
            if ($validity->type == 'date') {
                return "Available until " . date('F j, Y', strtotime($validity->date));
            } else if ($validity->type == 'amount') {
                return $validity->amount . " tickets available";
            }
        }
        return null;
    }
}
