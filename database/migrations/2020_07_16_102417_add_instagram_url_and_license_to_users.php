<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInstagramUrlAndLicenseToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add instagram_url and traveler_license to users
            $table->string('instagram_url')->nullable();
            $table->string('traveler_license')->nullable();
            $table->string('vrbo_link')->nullable();
            $table->string('agency_hr_phone')->nullable();
            $table->string('agency_hr_email')->nullable();
            $table->string('is_submitted_documents')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // drop if exist
            $table->dropColumn([
                'instagram_url',
                'traveler_license',
                'vrbo_link',
                'agency_hr_phone',
                'agency_hr_email',
                'is_submitted_documents',
            ]);
        });
    }
}
