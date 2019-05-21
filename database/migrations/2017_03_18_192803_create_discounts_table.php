<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('band');
            $table->enum('type', ['NONE', 'FIXED', 'FLEXIBLE']);
            $table->text('rate');
            $table->timestamps();
        });

        \App\Discount::create(
            [
                'band' => 0,
                'type' => 'NONE',
                'rate' => 0
            ]
        );

        \App\Discount::create(
            [
                'band' => 1,
                'type' => 'FIXED',
                'rate' => 0.01
            ]
        );

        \App\Discount::create(
            [
                'band' => 2,
                'type' => 'FLEXIBLE',
                'rate' => "1000,0.00|2000,0.01|0,0.02"
            ]
        );
        \App\Discount::create(
            [
                'band' => 3,
                'type' => 'FIXED',
                'rate' => "0.02"
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
