<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\DB;

class Address extends Model
{
    protected $fillable = ['AddressLine1', 'AddressLine2', 'AddressLine3', 'AddressLine4', 'CityTown', 'PostalArea', 'GoverningDistrict', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public static function getAddress($id)
    {
        $address = DB::table('addresses')->select(['AddressLine1', 'AddressLine2', 'AddressLine3', 'AddressLine4', 'CityTown', 'PostalArea', 'GoverningDistrict'])->where('id', '=', $id->value)->first();
        return $address;
    }

    public static function updateAddress($id, $addressData)
    {
        $id = ['id' => $id];
        Address::updateOrCreate($id, $addressData);
    }

}
