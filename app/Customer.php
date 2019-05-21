<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    public static $payment_methods = ['CARD', 'CASH', 'CHEQUE'];
    public static $account_types = ['NORMAL', 'REGULAR', 'VALUED'];
    public static $valid_titles = ['Mr', 'Mrs', 'Miss', 'Dr', 'Prof', 'Sir', 'Madam', 'Lord'];
    public $timestamps = true;
    protected $fillable =
        [
            "Title",
            "Firstname",
            "Surname",
            "DateOfBirth",
            "PrimaryPhoneNumber",
            "SecondaryPhoneNumber",
            "EmailAddress",
            "BalanceOutstanding",
            "IsValued",
            "IsRegular"
        ];

    public function address()
    {
        return $this->hasOne('App\Address');
    }

    public function sales()
    {
        return $this->hasMany('App\Sale');
    }

    public function discount()
    {
        return $this->belongsTo('\App\Discount');
    }

    public function addToBalance($amount)
    {
        $this->BalanceOutstanding += $amount;
        $this->save();
    }

    public function deductFromBalance($amount)
    {
        $this->BalanceOutstanding -= $amount;
        $this->save();
    }

    /*
     * Returns the new sale amount
     */
    public function calculateDiscountedFarePrice($amount)
    {
        if ($this->discount->type == 'NONE') {
            return $amount;
        } elseif ($this->discount->type == 'FIXED') {

            return ($amount - ($amount * $this->discount->rate));
        } elseif ($this->discount->type == 'FLEXIBLE') {
//            $salesTotal = \App\Sale::
//            select((DB::raw('SUM(SaleTotal) as total')))
//                ->where('customer_id', $this->id)
//                ->whereBetween('SaleTime', [\Carbon\Carbon::now()->format('y/m/') . "01", \Carbon\Carbon::now()->addMonth(1)->format('y/m/') . "01"])
//                ->get();
//
//            $discountsPacked = explode('|', $this->discount->rate);
//            foreach ($discountsPacked as $discountPacked) {
//                $tmp = explode(',', $discountPacked);
//                $array[$tmp[0]] = $tmp[1];
//            }
//
//            ksort($array);
//
//            foreach ($array as $max => $rate) {
//                if ($max != 0) {
//                    if (($salesTotal + $amount) < $max) {
//                        return $amount - ($amount * $rate);
//                    }
//                }
//            }
//            return $amount - ($amount * $array[0]);
            return $amount;

        } else {
            return $amount;
        }
    }

    public function updateAccountType($type)
    {
        if (in_array($type, self::$account_types)) {
            if($type != 'FLEXIBLE')
            {
                $this->type = $type;
                $this->discount_id = 1;
                $this->save();
            } else {
                $this->type = $type;
                $this->save();
            }
            return true;
        } else {
            return false;
        }
    }

    public function reminder_letter()
    {
        return $this->hasMany('App\ReminderLetter');
    }

//    public static function getOverduePayments()
//    {
//        $customers = DB::table('customers')
//            ->join('sales', 'customers.id', '=', 'sales.customer_id')
//            ->select(DB::raw('customers.Firstname, customers.Surname, COUNT(*)'))
//            ->where('sales.SaleTime', '>', time() - 2592000)
//            ->groupBy('customers.Firstname')
//            ->get();
//
//        return $customers;
//    }

}
