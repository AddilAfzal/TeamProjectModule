<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Refund extends Model
{
    protected $fillable = [
        'blank_id',
        'sale_id',
        'user_id',
        'amount',
        'reason',
        'method',
        'created_at'
    ];

    public $timestamps = false;

    protected static function boot() {

    }

    public function sale() {
        return $this->belongsTo('\App\Sale');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function blank() {
        return $this->belongsTo('App\Blank');
    }

    public static function recordRefund($blank_id, $sale_id, $user_id, $amount, $reason, $method, $date)
    {
        $refund = Refund::create(
            [
                'blank_id' => $blank_id,
                'sale_id' => $sale_id,
                'user_id' => $user_id,
                'amount' => $amount,
                'reason' => $reason,
                'method' => $method,
                'created_at' => $date
            ]
        );

        $blank = \App\Blank::find($blank_id);
        $sale = \App\Sale::find($sale_id);

        $refund_line = "Date/Time: {{$refund->created_at}} Blank Number: {{$blank->blank_number}} Amount: {{$refund->amount}} Customer: {{$sale->customer->Firstname}} {{$sale->customer->Surname}} ";

        try {
            Storage::prepend('refunds.log', $refund_line);
        } catch (Error $errors) {

            dd($errors);
        } finally {
        }

        return $refund;
    }


    public static function insertData()
    {
        Refund::recordRefund(
            \App\Blank::where('blank_number', '44400000002')->first()->id,
            \App\Sale::where('blank_id', \App\Blank::where('blank_number', '44400000002')->first()->id)->first()->id,
            \App\Sale::where('blank_id', \App\Blank::where('blank_number', '44400000002')->first()->id)->first()->user_id,
            \App\Sale::where('blank_id', \App\Blank::where('blank_number', '44400000002')->first()->id)->first()->SaleTotal,
            'Refund...',
            \App\Sale::where('blank_id', \App\Blank::where('blank_number', '44400000002')->first()->id)->first()->PaymentMethod,
            \Carbon\Carbon::createFromDate(2017, 02, 10)
        );
        Refund::recordRefund(
            \App\Blank::where('blank_number', '20100000011')->first()->id,
            \App\Sale::where('blank_id', \App\Blank::where('blank_number', '20100000011')->first()->id)->first()->id,
            \App\Sale::where('blank_id', \App\Blank::where('blank_number', '20100000011')->first()->id)->first()->user_id,
            \App\Sale::where('blank_id', \App\Blank::where('blank_number', '20100000011')->first()->id)->first()->SaleTotal,
            'Refund...',
            \App\Sale::where('blank_id', \App\Blank::where('blank_number', '20100000011')->first()->id)->first()->PaymentMethod,
            \Carbon\Carbon::createFromDate(2017, 02, 10)
        );
    }

}
