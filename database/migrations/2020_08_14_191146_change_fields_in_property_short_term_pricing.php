<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsInPropertyShortTermPricing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_short_term_pricing', function (Blueprint $table) {
            //
            $table
                ->string('is_extra_guest')
                ->nullable()
                ->change();
            $table
                ->string('price_per_extra_guest')
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_short_term_pricing', function (Blueprint $table) {
            //
        });
    }
}
