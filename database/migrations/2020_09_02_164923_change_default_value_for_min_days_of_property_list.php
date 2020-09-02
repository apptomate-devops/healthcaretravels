<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDefaultValueForMinDaysOfPropertyList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_list', function (Blueprint $table) {
            //
            $table
                ->string('min_days')
                ->default(30)
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
        Schema::table('property_list', function (Blueprint $table) {
            //
            $table
                ->string('min_days')
                ->default(1)
                ->change();
        });
    }
}
