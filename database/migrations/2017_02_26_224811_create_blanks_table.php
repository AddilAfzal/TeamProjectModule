<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blanks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('blank_number');
            $table->integer('blank_type_id');
            $table->integer('user_id');
            $table->boolean('is_sold');
            $table->dateTime('created_at');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('sold_at')->nullable();
        });

        \App\Blank::createBlanksByRange("44400000001","44400000100", 1, "2016-04-01");
        \App\Blank::createBlanksByRange("42000000001","42000000100", 3, "2016-05-08");
        \App\Blank::createBlanksByRange("20100000001","20100000100", 4, "2016-06-03");
        \App\Blank::createBlanksByRange("10100000001","10100000050", 4, "2016-07-09");

        \App\Blank::assignByRange("44400000001","44400000020", 250, "2016-04-01");
        \App\Blank::assignByRange("42000000001","42000000030", 250, "2016-05-08");
        \App\Blank::assignByRange("20100000001","20100000010", 250, "2016-06-03");

        \App\Blank::assignByRange("44400000021","44400000040", 211, "2016-04-05");
        \App\Blank::assignByRange("42000000031","42000000050", 211, "2016-05-10");
        \App\Blank::assignByRange("20100000011","20100000025", 211, "2016-06-15");
        \App\Blank::assignByRange("10100000001","10100000050", 211, "2016-07-11");
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blanks');
    }
}
