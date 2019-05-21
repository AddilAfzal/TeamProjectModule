<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\DB;


class Currency extends Model
{
    protected $fillable = ['CurrencyName', 'CurrencyAbbreviation', 'Rate'];

    public static function getAllCurrencies() {
        return DB::table('currencies')->get();

    }
}
