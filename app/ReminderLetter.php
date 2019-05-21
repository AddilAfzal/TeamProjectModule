<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReminderLetter extends Model
{
    public $fillable = ['customer_id', 'user_id', 'amount_due', 'sent_date'];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
