<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CleanUpDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('ad_commision');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('country');
        Schema::dropIfExists('country_code');
        Schema::dropIfExists('home_images');
        Schema::dropIfExists('owner_rating');
        Schema::dropIfExists('property_long_term_pricing');
        Schema::dropIfExists('property_short_term_pricing');
        Schema::dropIfExists('property_special_pricing');
        Schema::dropIfExists('property_video');
        Schema::dropIfExists('recent_locations');
        Schema::dropIfExists('request_chat');
        Schema::dropIfExists('request_chat_details');
        Schema::dropIfExists('room_types');
        Schema::dropIfExists('state');
        Schema::dropIfExists('verify_mobile');
        try {
            Schema::table('property_list', function (Blueprint $table) {
                $table->dropColumn([
                    'minimum_guests',
                    'minimum_childs',
                    'location',
                    'property_type',
                    'before_label',
                    'after_label',
                    'surroundings',
                    'sort',
                    'on_stage',
                    'on_popular',
                    'on_recomended',
                    'view_count',
                    'cancel_before_1_week',
                    'cancel_before_1_day',
                    'cancel_before_15_days',
                    'cancel_before_30_days',
                    'currency_type',
                    'deposit_amount',
                    'video_url',
                    'reqest_book',
                    'instant_pay',
                    'is_camera',
                    'cleaning_type',
                    'property_type_rv_or_home',
                ]);
            });
        } catch (\Exception $ex) {
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
