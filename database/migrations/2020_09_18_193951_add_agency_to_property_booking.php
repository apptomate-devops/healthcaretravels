<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgencyToPropertyBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_booking', function (Blueprint $table) {
            $table->string('name_of_agency')->nullable();
            $table->string('other_agency')->nullable();
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
            $table->dropColumn(['name_of_agency', 'other_agency']);
        });
    }
}
