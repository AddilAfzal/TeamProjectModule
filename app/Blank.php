<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Blank extends Model
{
    public $timestamps = false;

    public static function createBlanksByRange($blankFrom, $blankTo, $type, $date)
    {
        $tmp = $blankTo - $blankFrom;

        for ($i = 0; $i < ($tmp + 1); $i++) {
            $blank = new \App\Blank;
            $blank->blank_number = "" . $blankFrom + $i . "";
            $blank->blank_type_id = $type;
            $blank->user_id = 0;
            $blank->created_at = $date;
            $blank->is_sold = false;
            $blank->save();
        }
    }

    public static function assignByRange($from, $to, $advisor, $date)
    {
        DB::table('blanks')
            ->where('is_sold', 0)
            ->whereBetween('blank_number', [$from, $to])
            ->update(
                [
                    'user_id' => $advisor,
                    'assigned_at' => $date,
                ]
            );
    }

    public function isSold()
    {
        return false;
    }

    public function isAssigned()
    {
        if ($this->attributes['user_id'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function coupons()
    {
        return $this->hasMany('App\Coupon');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function blank_type()
    {
        return $this->belongsTo('App\BlankType');
    }

    public function sale()
    {
        return $this->hasOne('\App\Sale');
    }

    public function assign($id)
    {
        if($this->is_sold == 1) {
            return false;
        } else {
            $this->user_id = $id;
            $this->assigned_at = \Carbon\Carbon::createFromTimestamp(time());
            $this->save();
        }
    }


}
