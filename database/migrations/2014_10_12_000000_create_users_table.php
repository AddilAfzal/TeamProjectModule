<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->enum('role', ['manager', 'admin', 'advisor']);
            $table->boolean('isSuspended')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert(
            [
                'name' => 'Addil',
                'username' => 'addil',
                'password' => bcrypt('abcd1234'),
                'remember_token' => 'nymdZ5QonEHSry6RIyNJkrOWd9bxExjPjckdrmVEfvPYqK3LCic8Hij3ZtyZ',
                'role' => 'admin',
                'created_at' => \Carbon\Carbon::createFromTimestamp(time())
            ]
        );
        DB::table('users')->insert(
            [
                'name' => 'Lahini',
                'username' => 'lahini',
                'password' => bcrypt('abcd1234'),
                'remember_token' => 'nymdZ5QonEHSry6RIyNJkrOWd9bxExjPjckdrmVEfvPYqK3LCic8Hij3ZtyZ',
                'role' => 'advisor',
                'created_at' => \Carbon\Carbon::createFromTimestamp(time())
            ]
        );
        DB::table('users')->insert(
            [
                'name' => 'Jaden',
                'username' => 'jaden',
                'password' => bcrypt('abcd1234'),
                'remember_token' => 'nymdZ5QonEHSry6RIyNJkrOWd9bxExjPjckdrmVEfvPYqK3LCic8Hij3ZtyZ',
                'role' => 'manager',
                'created_at' => \Carbon\Carbon::createFromTimestamp(time())
            ]
        );


        DB::table('users')->insert(
            [
                'id' => 250,
                'name' => 'Penelope Pitstop',
                'username' => '250',
                'password' => bcrypt('PinkMobile'),
                'remember_token' => 'nymdZ5QonEHSry6RIyNJkrOWd9bxExjPjckdrmVEfvPYqK3LCic8Hij3ZtyZ',
                'role' => 'advisor',
                'created_at' => \Carbon\Carbon::createFromTimestamp(time())
            ]
        );
        DB::table('users')->insert(
            [
                'id' => 211,
                'name' => 'Dennis Menace',
                'username' => '211',
                'password' => bcrypt('Gnasher'),
                'remember_token' => 'nymdZ5QonEHSry6RIyNJkrOWd9bxExjPjckdrmVEfvPYqK3LCic8Hij3ZtyZ',
                'role' => 'advisor',
                'created_at' => \Carbon\Carbon::createFromTimestamp(time())
            ]
        );
        DB::table('users')->insert(
            [
                'id' => 220,
                'name' => 'Minnie Minx',
                'username' => '220',
                'password' => bcrypt('NotiGirl'),
                'remember_token' => 'nymdZ5QonEHSry6RIyNJkrOWd9bxExjPjckdrmVEfvPYqK3LCic8Hij3ZtyZ',
                'role' => 'manager',
                'created_at' => \Carbon\Carbon::createFromTimestamp(time())
            ]
        );
        DB::table('users')->insert(
            [
                'id' => 320,
                'name' => 'Arthur Daley',
                'username' => '320',
                'password' => bcrypt('LiesaLot'),
                'remember_token' => 'nymdZ5QonEHSry6RIyNJkrOWd9bxExjPjckdrmVEfvPYqK3LCic8Hij3ZtyZ',
                'role' => 'admin',
                'created_at' => \Carbon\Carbon::createFromTimestamp(time())
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
        Schema::dropIfExists('users');
    }
}
