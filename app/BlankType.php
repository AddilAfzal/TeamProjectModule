<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlankType extends Model
{
    public static   $valid_blank_sub_types = ['FLIGHT', 'MCO'];
    public static   $valid_scopes = ['INTERLINE', 'DOMESTIC', 'NA'];

    protected $fillable = ['prefix', 'commission_rate','type','scope','number_of_coupons'];

    public static function isValidSubType($t) {
        if(in_array($t,SELF::$valid_blank_sub_types)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isValidScope($t) {
        if(in_array($t,SELF::$valid_scopes)) {
            return true;
        } else {
            return false;
        }
    }

    public function blanks() {
        return $this->hasMany('\App\Blank');
    }
}
