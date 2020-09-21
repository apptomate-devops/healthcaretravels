<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDwollaEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dwolla_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dwolla_id');
            $table->string('resource_id');
            $table->string('topic');
            $table->string('links');
            $table->string('proposed_signature');
            $table->string('generated_signature');
            $table
                ->tinyInteger('is_valid_request')
                ->default(0)
                ->comment('0 = false, 1 = True');
            $table
                ->tinyInteger('is_used')
                ->default(0)
                ->comment('0 = false, 1 = True');
            $table->timestamp('timestamp');
            $table->timestamp('dwolla_created');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dwolla_events');
    }
}
