<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationLatLngToHomeCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_listings', function (Blueprint $table) {
            //
            $table->string('lat')->default(0);
            $table->string('lng')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_listings', function (Blueprint $table) {
            //
            $table->dropColumn(['lat, lng']);
        });
    }
}
