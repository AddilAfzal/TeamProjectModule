<?php

namespace App;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\DB;

class TravelAgent extends Model
{
    /*
     * return array
     */
    public static function getAddress()
    {
        $result = DB::table('configurables')->where('setting', '=', 'agent_address')->first();
        $address = \App\Address::getAddress($result);
        return $address;
    }

    public static function getName()
    {
        return DB::table('configurables')->where('setting', '=', 'agent_name')->first()->value;
    }

    public static function getLocalCurrency()
    {
        return DB::table('configurables')->where('setting', '=', 'agent_currency')->first()->value;
    }

    public static function getPhoneNumber()
    {
        return DB::table('configurables')->where('setting', '=', 'agent_phone')->first()->value;
    }

    public static function setName($name)
    {
        DB::table('configurables')
            ->where('setting', 'agent_name')
            ->update(['value' => $name]);
    }

    public static function setPhoneNumber($phone)
    {
        DB::table('configurables')
            ->where('setting', 'agent_phone')
            ->update(['value' => $phone]);
    }

    public static function setLocalCurrency($currency)
    {
        DB::table('configurables')
            ->where('setting', 'agent_currency')
            ->update(['value' => $currency]);
    }

    public static function setAddress($addressData)
    {
        foreach ($addressData as $key => $data) {
            if($data == null) {
                unset($addressData[$key]);
            }
        }
        $id = DB::table('configurables')->where('setting', '=', 'agent_address')->first()->value;
        Address::updateAddress($id, $addressData);
    }

}
