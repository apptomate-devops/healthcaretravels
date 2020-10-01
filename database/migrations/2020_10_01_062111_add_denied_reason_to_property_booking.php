<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeniedReasonToPropertyBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_booking', function (Blueprint $table) {
            //
            $table->string('deny_reason')->nullable();
            DB::statement(
                "ALTER TABLE `property_booking` CHANGE `status` `status` INT(3) NOT NULL DEFAULT '0' COMMENT '0 created 1 pending 2 approved 3 completed 4 denied 8 cancelled';",
            );
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
            //
            $table->dropColumn(['deny_reason']);
        });
    }
}
