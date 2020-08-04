<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //property_tax_url
            $table->string('property_tax_url')->nullable();
            $table->string('homeowner_first_name')->nullable();
            $table->string('homeowner_last_name')->nullable();
            $table->string('homeowner_email')->nullable();
            $table->string('homeowner_phone_number')->nullable();
            $table->string('property_address')->nullable();
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
            //
            $table->dropColumn([
                'property_tax_url',
                'homeowner_first_name',
                'homeowner_last_name',
                'homeowner_email',
                'homeowner_phone_number',
                'property_address',
            ]);
        });
    }
}
