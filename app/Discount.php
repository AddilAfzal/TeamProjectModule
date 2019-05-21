<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public $fillable = ['band', 'type', 'rate'];
    public function customers()
    {
        return $this->hasMany('\App\Customer');
    }
}
