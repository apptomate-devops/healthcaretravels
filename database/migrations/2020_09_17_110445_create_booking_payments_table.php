<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('payment_cycle');
            $table->integer('service_tax');
            $table->integer('partial_days')->nullable();
            $table->integer('booking_row_id')->comment('Represents primary key id of booking table');
            $table->string('booking_id')->comment('Represents booking id used all over the application');
            $table->integer('cleaning_fee')->nullable();
            $table->integer('security_deposit')->nullable();
            $table->integer('monthly_rate');
            $table->integer('total_amount');
            $table->date('due_date');
            $table
                ->tinyInteger('is_processed')
                ->default(0)
                ->comment('0 = false, 1 = True');
            $table->timestamp('processed_time')->nullable();
            $table->timestamp('confirmed_time')->nullable();
            $table->timestamp('failed_time')->nullable();
            $table->string('failed_reason')->nullable();
            $table->string('transfer_id')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_payments');
    }
}
