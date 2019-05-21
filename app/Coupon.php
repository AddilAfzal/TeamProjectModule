<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $fillable = [
        'blank_id',
        'flight_number',
        'departure_from',
        'departure_time',
        'arrival_to',
        'arrival_time',
    ];
    public function blank()
    {
        return $this->belongsTo('App\Blank');
    }
}
