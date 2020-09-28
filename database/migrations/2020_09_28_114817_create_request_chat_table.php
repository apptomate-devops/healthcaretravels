<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE TABLE IF NOT EXISTS `request_chat` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `client_id` int(11) NOT NULL,
            `owner_id` int(11) NOT NULL,
            `traveller_id` int(11) NOT NULL,
            `sent_by` int(11) NOT NULL,
            `property_id` int(11) NOT NULL,
            `guest_count` int(11) NOT NULL,
            `check_in` varchar(10) NOT NULL,
            `check_out` varchar(10) NOT NULL,
            `message` text NOT NULL,
            `status` int(3) NOT NULL DEFAULT 0,
            `created_at` TIMESTAMP NOT NULL DEFAULT NOW(),
            `updated_at` TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE now(),
            PRIMARY KEY (`id`)
        )');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_chat');
    }
}
