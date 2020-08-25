<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPetDetailsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('is_pet_travelling')->default(0);
            $table->string('pet_name')->nullable();
            $table->string('pet_breed')->nullable();
            $table->string('pet_weight')->nullable();
            $table->string('pet_image')->nullable();
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
            $table->dropColumn(['is_pet_travelling, pet_name, pet_breed, pet_weight, pet_image']);
        });
    }
}
