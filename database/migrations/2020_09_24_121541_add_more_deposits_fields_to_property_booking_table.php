<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreDepositsFieldsToPropertyBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_booking', function (Blueprint $table) {
            $table->integer('security_deposit')->nullable();
            $table->integer('cleaning_fee')->nullable();
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
            $table->dropColumn(['security_deposit', 'cleaning_fee']);
        });
    }
}
