<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->text('CurrencyName');
            $table->string('CurrencyAbbreviation');
            $table->double('Rate');
            $table->timestamps();
        });

        \App\Currency::create(['CurrencyName' => "United States Dollar", 'CurrencyAbbreviation' => 'USD', 'Rate' => 1]);
        \App\Currency::create(['CurrencyName' => "Great British Pound", 'CurrencyAbbreviation' => 'GBP', 'Rate' => 0.8121]);
        \App\Currency::create(['CurrencyName' => "Pakistani Rupees", 'CurrencyAbbreviation' => 'PKR', 'Rate' => 104.7832]);
        \App\Currency::create(['CurrencyName' => "United Arab Emirates Dirham", 'CurrencyAbbreviation' => 'AED', 'Rate' => 3.6729]);

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
