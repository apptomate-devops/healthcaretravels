<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOwnerDetailsToBookingPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_payments', function (Blueprint $table) {
            $table
                ->tinyInteger('is_owner')
                ->default(0)
                ->comment('0 = false, 1 = True');
            $table->string('job_id')->nullable();
            $table->string('transfer_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_payments', function (Blueprint $table) {
            $table->dropColumn(['is_owner', 'job_id', 'transfer_url']);
        });
    }
}
