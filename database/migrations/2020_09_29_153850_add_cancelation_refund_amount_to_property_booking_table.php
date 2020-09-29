<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancelationRefundAmountToPropertyBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_booking', function (Blueprint $table) {
            $table->integer('cancellation_refund_amount')->nullable();
            $table->timestamp('cancellation_refund_processed_at')->nullable();
            $table->timestamp('cancellation_refund_confirmed_at')->nullable();
            $table->timestamp('cancellation_refund_failed_at')->nullable();
            $table->string('cancellation_refund_failed_reason')->nullable();
            $table->string('cancellation_refund_transfer_id')->nullable();
            $table
                ->tinyInteger('cancellation_refund_status')
                ->default(0)
                ->comment('0 = no action, 1 = init, 2 = success, 3 = failed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_booking', function (Blueprint $table) {
            $table->dropColumn([
                'cancellation_refund_amount',
                'cancellation_refund_processed_at',
                'cancellation_refund_confirmed_at',
                'cancellation_refund_failed_at',
                'cancellation_refund_failed_reason',
                'cancellation_refund_transfer_id',
                'cancellation_refund_status',
            ]);
        });
    }
}
