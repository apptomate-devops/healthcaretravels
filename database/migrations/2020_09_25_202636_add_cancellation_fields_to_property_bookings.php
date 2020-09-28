<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancellationFieldsToPropertyBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_booking', function (Blueprint $table) {
            $table
                ->tinyInteger('cancellation_requested')
                ->default(0)
                ->comment('0 = not yet, 1 = requested, 2 = request processed');
            $table
                ->tinyInteger('already_checked_in')
                ->default(0)
                ->comment('0 = false, 1 = True');
            $table->string('cancellation_reason');
            $table->longText('cancellation_explanation')->nullable();
            $table->string('cancelled_by');
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
                'cancellation_requested',
                'already_checked_in',
                'cancellation_reason',
                'cancellation_explanation',
                'cancelled_by',
            ]);
        });
    }
}
