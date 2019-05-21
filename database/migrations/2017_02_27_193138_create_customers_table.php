<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('Title', \App\Customer::$valid_titles);
            $table->text('Firstname');
            $table->text('Surname');
            $table->text('Alias');
            $table->date('DateOfBirth');
            $table->text('PrimaryPhoneNumber');
            $table->text('SecondaryPhoneNumber')->nullable();
            $table->text('EmailAddress');
            $table->float('BalanceOutstanding');
            $table->enum('Type', ['NORMAL', 'REGULAR', 'VALUED']);
            $table->integer('discount_id')->unsigned()->default(1);
            $table->timestamps();
        });

        DB::table('customers')
            ->insert(
                [
                    'Title' => 'Mr',
                    'Firstname' => "Chris",
                    'Surname' => "Smart",
                    'Alias' => "Chris",
                    'DateOfBirth' => '1968/01/01',
                    'PrimaryPhoneNumber' => "+447401234567",
                    'EmailAddress' => "chris.smart@city.ac.uk",
                    'BalanceOutstanding' => "0",
                    'Type' => 'VALUED',
                    'discount_id' => 2,
                    'created_at' => \Carbon\Carbon::createFromTimestamp(time()),
                ]
            );
        DB::table('customers')
            ->insert(
                [
                    'Title' => 'Mr',
                    'Firstname' => "David",
                    'Surname' => "Dodson",
                    'Alias' => "DaveD",
                    'DateOfBirth' => '1988/01/01',
                    'PrimaryPhoneNumber' => "+447401231234",
                    'EmailAddress' => "Dodson.David@city.ac.uk",
                    'BalanceOutstanding' => "0",
                    'Type' => 'VALUED',
                    'discount_id' => 3,
                    'created_at' => \Carbon\Carbon::createFromTimestamp(time()),
                ]
            );

        DB::table('customers')
            ->insert(
                [
                    'Title' => 'Miss',
                    'Firstname' => "Sarah ",
                    'Surname' => "Broklehurst",
                    'Alias' => "SarahB",
                    'DateOfBirth' => '1992/01/01',
                    'PrimaryPhoneNumber' => "+447405671234",
                    'EmailAddress' => "Sarah.Broklehurst@city.ac.uk",
                    'BalanceOutstanding' => "0",
                    'Type' => 'VALUED',
                    'discount_id' => 4,
                    'created_at' => \Carbon\Carbon::createFromTimestamp(time()),
                ]
            );

        DB::table('customers')
            ->insert(
                [
                    'Title' => 'Mr',
                    'Firstname' => "Dominic",
                    'Surname' => "Beatty",
                    'Alias' => "Dom",
                    'DateOfBirth' => '1972/01/01',
                    'PrimaryPhoneNumber' => "+447405674321",
                    'EmailAddress' => "Dominic.Beatty@city.ac.uk",
                    'BalanceOutstanding' => "0",
                    'Type' => 'REGULAR',
                    'discount_id' => 1,
                    'created_at' => \Carbon\Carbon::createFromTimestamp(time()),
                ]
            );

        DB::table('customers')
            ->insert(
                [
                    'Title' => 'Mr',
                    'Firstname' => "Brian",
                    'Surname' => "O'Connor",
                    'Alias' => "BrianO",
                    'DateOfBirth' => '1978/07/14',
                    'PrimaryPhoneNumber' => "+447405674321",
                    'EmailAddress' => "Brian.OConnor@fast.com",
                    'BalanceOutstanding' => "0",
                    'Type' => 'REGULAR',
                    'discount_id' => 1,
                    'created_at' => \Carbon\Carbon::createFromTimestamp(time()),
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
        Schema::dropIfExists('customers');
    }
}
