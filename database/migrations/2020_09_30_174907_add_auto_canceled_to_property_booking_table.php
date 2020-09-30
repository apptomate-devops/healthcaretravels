<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutoCanceledToPropertyBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_booking', function (Blueprint $table) {
            $table->tinyInteger('auto_canceled')->default(0)->comment('0 = false, 1 = true');
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
            $table->dropColumn(['auto_canceled']);
        });
    }
}
