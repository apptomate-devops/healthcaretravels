<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetFieldsNullablePropertyList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_list', function (Blueprint $table) {
            $table
                ->string('zip_code')
                ->nullable()
                ->change();
            $table
                ->string('address')
                ->nullable()
                ->change();
            $table
                ->string('city')
                ->nullable()
                ->change();
            $table
                ->string('state')
                ->nullable()
                ->change();
            $table
                ->string('country')
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
        Schema::table('property_list', function (Blueprint $table) {
            //
        });
    }
}
