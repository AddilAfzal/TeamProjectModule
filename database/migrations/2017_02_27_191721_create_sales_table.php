<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            //$table->foreign('SaleBy')->references('id')->on('users');
            $table->integer('customer_id')->unsigned();
            $table->integer('blank_id')->unsigned();
            //$table->foreign('SaleTo')->references('id')->on('customers');
            $table->text('SaleRef');
            $table->dateTime('SaleTime');
            $table->integer('SaleCurrency')->unsigned();
            $table->double('CurrencyRate');
            //$table->foreign('SaleCurrency')->references('id')->on('currencies');

            $table->float('SaleFareUSD');
            $table->float('SaleFare');
            $table->float('SaleTaxLocal');
            $table->float('SaleTaxOther');
            $table->float('SaleTotal');

            $table->enum('DiscountType',['NONE','FLEXIBLE','FIXED']);
            $table->float('DiscountAmount');

            $table->float('CommissionRate');
            $table->float('SaleCommission');

            $table->boolean('AwaitingPayment');
            $table->enum('PaymentMethod',['CARD','CASH','CHEQUE','PENDING']);
            $table->text('CardNumber')->nullable();
            $table->text('CardType')->nullable();

            $table->timestamp('PaymentTime')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
