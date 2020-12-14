<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMonthlyRateAtBookingToPropertyBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_booking', function (Blueprint $table) {
            $table->string('monthly_rate')->default(0);
        });
        DB::statement(
            'UPDATE property_booking, property_list SET property_booking.monthly_rate = property_list.monthly_rate WHERE property_list.id = property_booking.property_id',
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_booking', function (Blueprint $table) {
            $table->dropColumn(['monthly_rate']);
        });
    }
}
