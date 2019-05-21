<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];

    public static function insertData()
    {
        Sale::registerSale(
            \App\Customer::where('Alias', 'SarahB')->first()->id,
            \App\User::where('id', '250')->first()->id,
            \App\Blank::where('blank_number', '44400000001')->first()->id,
            \Carbon\Carbon::createFromDate(2017, 01, 01),
            \App\TravelAgent::getLocalCurrency(),
            220,
            23,
            35,
            0.09,
            false,
            'CASH',
            null,
            0.54,
            \Carbon\Carbon::createFromDate(2017, 01, 01),
            null
        );

        Sale::registerSale(
            \App\Customer::where('Alias', 'BrianO')->first()->id,
            \App\User::where('id', '250')->first()->id,
            \App\Blank::where('blank_number', '44400000002')->first()->id,
            \Carbon\Carbon::createFromDate(2017, 01, 01),
            \App\TravelAgent::getLocalCurrency(),
            230,
            43,
            55,
            0.09,
            false,
            'CARD',
            '4901000223453456',
            0.54,
            \Carbon\Carbon::createFromDate(2017, 01, 01),
            'VI'
        );

        Sale::registerSale(
            \App\Customer::where('Alias', 'BrianO')->first()->id,
            \App\User::where('id', '250')->first()->id,
            \App\Blank::where('blank_number', '20100000001')->first()->id,
            \Carbon\Carbon::createFromDate(2017, 01, 01),
            \App\TravelAgent::getLocalCurrency(),
            86.00,
            15.60,
            0,
            0.05,
            false,
            'CASH',
            null,
            0.54,
            \Carbon\Carbon::createFromDate(2017, 01, 01),
            null
        );

        Sale::registerSale(
            \App\Customer::where('Alias', 'DaveD')->first()->id,
            \App\User::where('id', '250')->first()->id,
            \App\Blank::where('blank_number', '44400000003')->first()->id,
            \Carbon\Carbon::createFromDate(2017, 02, 02),
            \App\TravelAgent::getLocalCurrency(),
            220.00,
            63.00,
            75.00,
            0.09,
            true,
            'PENDING',
            null,
            0.43,
            null,
            null
        );

        Sale::registerSale(
            \App\Customer::where('Alias', 'Chris')->first()->id,
            \App\User::where('id', '250')->first()->id,
            \App\Blank::where('blank_number', '44400000004')->first()->id,
            \Carbon\Carbon::createFromDate(2017, 02, 02),
            \App\TravelAgent::getLocalCurrency(),
            230.00,
            23.00,
            35.00,
            0.09,
            true,
            'PENDING',
            null,
            0.43,
            null,
            null
        );

        Sale::registerSale(
            \App\Customer::where('Alias', 'BrianO')->first()->id,
            \App\User::where('id', '250')->first()->id,
            \App\Blank::where('blank_number', '20100000002')->first()->id,
            \Carbon\Carbon::createFromDate(2017, 02, 02),
            \App\TravelAgent::getLocalCurrency(),
            75.00,
            13.80,
            0,
            0.05,
            false,
            'CARD',
            '6454986387338876',
            0.43,
            null,
            'VI'
        );

        Sale::registerSale(
            \App\Customer::where('Alias', 'SarahB')->first()->id,
            \App\User::where('id', '211')->first()->id,
            \App\Blank::where('blank_number', '44400000021')->first()->id,
            \Carbon\Carbon::createFromDate(2017, 02, 02),
            \App\TravelAgent::getLocalCurrency(),
            250.00,
            25.00,
            35.00,
            0.09,
            true,
            'PENDING',
            null,
            0.43,
            null,
            null
        );

        Sale::registerSale(
            \App\Customer::where('Alias', 'BrianO')->first()->id,
            \App\User::where('id', '211')->first()->id,
            \App\Blank::where('blank_number', '44400000022')->first()->id,
            \Carbon\Carbon::createFromDate(2017, 02, 02),
            \App\TravelAgent::getLocalCurrency(),
            300.00,
            28.00,
            37.00,
            0.09,
            false,
            'CARD',
            '7449155545893456',
            0.43,
            \Carbon\Carbon::createFromDate(2017, 02, 02),
            'VI'

        );

        Sale::registerSale(
            \App\Customer::where('Alias', 'BrianO')->first()->id,
            \App\User::where('id', '211')->first()->id,
            \App\Blank::where('blank_number', '20100000011')->first()->id,
            \Carbon\Carbon::createFromDate(2017, 02, 02),
            \App\TravelAgent::getLocalCurrency(),
            75.00,
            13.80,
            0,
            0.05,
            false,
            'CASH',
            null,
            0.43,
            \Carbon\Carbon::createFromDate(2017, 02, 02),
            null
        );
    }

    public static function registerSale($customer_id, $user_id, $blank_id,
                                        $sale_time, $sale_currency,
                                        $fareLocal, $taxLocal, $taxOther,
                                        $commission_rate, $awaiting_payment, $payment_method,
                                        $card_number, $currency_rate, $payment_time, $card_type

    )
    {
        $customer = \App\Customer::find($customer_id);
        $blank = \App\Blank::find($blank_id);

        $sale = \App\Sale::create(
            [
                'user_id' => $user_id,
                'customer_id' => $customer_id,
                'blank_id' => $blank_id,
                'SaleRef' => time() . rand(10 * 45, 100 * 98),
                'SaleTime' => $sale_time,
                'SaleCurrency' => $sale_currency,
                'CurrencyRate' => $currency_rate,
                'SaleFareUSD' => ($fareLocal) / $currency_rate,
                'SaleFare' => $fareLocal,
                'SaleTaxLocal' => $taxLocal,
                'SaleTaxOther' => $taxOther,
                'SaleTotal' => ($customer->calculateDiscountedFarePrice($fareLocal) + $taxLocal + $taxOther),
                'DiscountType' => $customer->discount->type,
                'DiscountAmount' => $fareLocal - $customer->calculateDiscountedFarePrice($fareLocal),
                'CommissionRate' => $commission_rate,
                'SaleCommission' => ($customer->calculateDiscountedFarePrice($fareLocal) * $commission_rate),
                'AwaitingPayment' => $awaiting_payment,
                'PaymentMethod' => $payment_method,
                'CardNumber' => $card_number,
                'CardType' => $card_type,
                'PaymentTime' => $payment_time,
            ]
        );
        
        if($awaiting_payment == true)
        {
            $customer->addToBalance(($customer->calculateDiscountedFarePrice($fareLocal) + $taxLocal + $taxOther));
        }
        

        $blank->sold_at = \Carbon\Carbon::createFromDate(2017, 01, 01);
        $blank->is_sold = true;
        $blank->save();


    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function blank()
    {
        return $this->belongsTo('App\Blank');
    }

    public function advisor()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function currency()
    {
        return $this->belongsTo('App\Currency', 'SaleCurrency');
    }

    public function discount()
    {
        return $this->hasOne('\App\Discount');
    }

    public function refund()
    {
        return $this->hasOne('\App\Refund');
    }


}
