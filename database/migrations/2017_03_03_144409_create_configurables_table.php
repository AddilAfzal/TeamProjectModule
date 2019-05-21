<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurables', function (Blueprint $table) {
            $table->increments('id');
            $table->text('setting');
            $table->text('description');
            $table->text('value');
            $table->timestamps();
        });

        DB::table('configurables')->insert(['setting' => "agent_address", 'description' => 'ID of the address of the travel agent consisting in the addresses table.', 'value' => 1]);
        DB::table('configurables')->insert(['setting' => "agent_name", 'description' => 'Name of the travel agent business', 'value' => 'De Kooi']);
        DB::table('configurables')->insert(['setting' => "agent_currency", 'description' => 'ID of the currency used by the system.', 'value' => 4]);
        DB::table('configurables')->insert(['setting' => "agent_phone", 'description' => 'Phone number of the business', 'value' => '+44 20312 34567']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configurables');
    }
}
