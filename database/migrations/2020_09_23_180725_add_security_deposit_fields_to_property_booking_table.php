<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSecurityDepositFieldsToPropertyBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_booking', function (Blueprint $table) {
            $table->string('admin_remarks')->nullable();
            $table->string('owner_remarks')->nullable();
            $table->string('traveler_remarks')->nullable();
            $table
                ->tinyInteger('is_deposit_handled')
                ->default(0)
                ->comment('0 = false, 1 = True');
            $table
                ->tinyInteger('is_deposit_handled_by_admin')
                ->default(0)
                ->comment('0 = false, 1 = True');
            $table
                ->tinyInteger('should_auto_deposit')
                ->default(1)
                ->comment('0 = false, 1 = True:: Mark 0 if needs to be handled by admin');
            $table->integer('owner_cut')->nullable();
            $table->integer('traveler_cut')->nullable();
            $table->timestamp('deposit_handled_at')->nullable();
            $table->timestamp('owner_deposit_processed_at')->nullable();
            $table->timestamp('owner_deposit_confirmed_at')->nullable();
            $table->timestamp('owner_deposit_failed_at')->nullable();
            $table->string('owner_deposit_failed_reason')->nullable();
            $table->string('owner_deposit_transfer_id')->nullable();
            $table->timestamp('traveler_deposit_processed_at')->nullable();
            $table->timestamp('traveler_deposit_confirmed_at')->nullable();
            $table->timestamp('traveler_deposit_failed_at')->nullable();
            $table->string('traveler_deposit_failed_reason')->nullable();
            $table->string('traveler_deposit_transfer_id')->nullable();
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
                'admin_remarks',
                'owner_remarks',
                'traveler_remarks',
                'is_deposit_handled',
                'is_deposit_handled_by_admin',
                'should_auto_deposit',
                'owner_cut',
                'traveler_cut',
                'deposit_handled_at',
                'owner_deposit_processed_at',
                'owner_deposit_confirmed_at',
                'owner_deposit_failed_at',
                'owner_deposit_failed_reason',
                'owner_deposit_transfer_id',
                'traveler_deposit_processed_at',
                'traveler_deposit_confirmed_at',
                'traveler_deposit_failed_at',
                'traveler_deposit_failed_reason',
                'traveler_deposit_transfer_id',
            ]);
        });
    }
}
