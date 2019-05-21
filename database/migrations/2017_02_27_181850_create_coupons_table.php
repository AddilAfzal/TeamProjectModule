<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blank_id');
            $table->string('flight_number');
            $table->text('departure_from');
            $table->dateTime('departure_time');
            $table->text('arrival_to');
            $table->dateTime('arrival_time');
            $table->timestamps();
        });

        DB::table('coupons')->insert(['blank_id' => 1, 'flight_number' => 'EY017', 'departure_from' => 'DXB - Dubai Terminal 3', 'departure_time' => '17/04/05 11:25', 'arrival_to' => 'LHR - London Heathrow Terminal 4', 'arrival_time' => '17/04/05 15:25']);
        DB::table('coupons')->insert(['blank_id' => 1, 'flight_number' => 'EY027', 'departure_from' => 'LHR - London Heathrow Terminal 4', 'departure_time' => '20/04/05 11:25', 'arrival_to' => 'DXB - Dubai Terminal 3', 'arrival_time' => '20/04/05 21:05']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
