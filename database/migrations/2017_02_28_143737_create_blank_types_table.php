<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlankTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blank_types', function (Blueprint $table) {
            $table->increments('id');
            $table->text('prefix');
            $table->float('commission_rate');
            $table->enum('type',['FLIGHT', 'MCO']);
            $table->enum('scope',['INTERLINE', 'DOMESTIC', 'NA']);
            $table->integer('number_of_coupons');
            $table->timestamps();
        });

        DB::table('blank_types')->insert(['prefix' => "444", 'commission_rate' => 0.5, 'type' => 'FLIGHT', 'number_of_coupons' => 4, 'scope' => 'INTERLINE']);
        DB::table('blank_types')->insert(['prefix' => "440", 'commission_rate' => 0.2, 'type' => 'FLIGHT', 'number_of_coupons' => 4, 'scope' => 'INTERLINE']);
        DB::table('blank_types')->insert(['prefix' => "420", 'commission_rate' => 0.3, 'type' => 'FLIGHT', 'number_of_coupons' => 2, 'scope' => 'INTERLINE']);
        DB::table('blank_types')->insert(['prefix' => "201", 'commission_rate' => 0.5, 'type' => 'FLIGHT', 'number_of_coupons' => 2, 'scope' => 'DOMESTIC']);
        DB::table('blank_types')->insert(['prefix' => "101", 'commission_rate' => 0.12, 'type' => 'FLIGHT', 'number_of_coupons' => 1, 'scope' => 'DOMESTIC']);
        DB::table('blank_types')->insert(['prefix' => "451", 'commission_rate' => 0.12, 'type' => 'MCO', 'number_of_coupons' => 1, 'scope' => 'NA']);
        DB::table('blank_types')->insert(['prefix' => "452", 'commission_rate' => 0.12, 'type' => 'MCO', 'number_of_coupons' => 1, 'scope' => 'NA']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blank_types');
    }
}
