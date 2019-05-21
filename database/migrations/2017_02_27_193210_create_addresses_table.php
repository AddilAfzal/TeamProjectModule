<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->text('customer_id');
            $table->text('AddressLine1');
            $table->text('AddressLine2')->nullable();
            $table->text('AddressLine3')->nullable();
            $table->text('AddressLine4')->nullable();
            $table->text('CityTown');
            $table->text('PostalArea');
            $table->text('GoverningDistrict');
            $table->timestamps();
        });
        DB::table('addresses')->insert(
            [
                'customer_id' => 1,
                'AddressLine1' => 'Northampton Square',
                'AddressLine2' => "Clerkenwell",
                'AddressLine3' => null,
                'AddressLine4' => null,
                'CityTown' => 'London',
                'PostalArea' => 'EC1V 0HB',
                'GoverningDistrict' => 'United Kingdom'
            ]
        );
        DB::table('addresses')->insert(
            [
                'customer_id' => 2,
                'AddressLine1' => '1 Uneeda Drive',
                'AddressLine2' => null,
                'AddressLine3' => null,
                'AddressLine4' => null,
                'CityTown' => 'Oxford',
                'PostalArea' => 'WE74KR',
                'GoverningDistrict' => 'United Kingdom'
            ]
        );
        DB::table('addresses')->insert(
            [
                'customer_id' => 3,
                'AddressLine1' => '5 District Road',
                'AddressLine2' => null,
                'AddressLine3' => null,
                'AddressLine4' => null,
                'CityTown' => 'Yeading',
                'PostalArea' => 'YE12NG',
                'GoverningDistrict' => 'United Kingdom'
            ]
        );

        DB::table('addresses')->insert(
            [
                'customer_id' => 4,
                'AddressLine1' => '1 River Road',
                'AddressLine2' => null,
                'AddressLine3' => null,
                'AddressLine4' => null,
                'CityTown' => 'Cheston',
                'PostalArea' => 'CHES10ON',
                'GoverningDistrict' => 'United Kingdom'
            ]
        );

        DB::table('addresses')->insert(
            [
                'customer_id' => 5,
                'AddressLine1' => '5th Street',
                'AddressLine2' => 'Boston',
                'AddressLine3' => null,
                'AddressLine4' => null,
                'CityTown' => 'Massachusetts',
                'PostalArea' => '14025',
                'GoverningDistrict' => 'New York'
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
        Schema::dropIfExists('addresses');
    }
}
