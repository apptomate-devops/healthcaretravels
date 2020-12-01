<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveOlderAmenities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // current Amenities
        $valid_amenties = [
            "Air Conditioner",
            "All Bills Included",
            "All Utilities Included",
            "Breakfast Included",
            "Cable",
            "Coffee Pot",
            "Computer",
            "Doorman",
            "Dryer",
            "Elevator in Building",
            "Fax",
            "Free Parking on Premises",
            "Garage",
            "Gym",
            "Heating",
            "Hot Tub",
            "Indoor Fireplace",
            "Iron/Ironing Board",
            "Kid Friendly",
            "Kitchen",
            "Netflix",
            "Non Smoking",
            "Pets Allowed",
            "Phone",
            "Pool",
            "Pots/Pans",
            "Roku",
            "Scanner / Printer",
            "Security Cameras (Exterior)",
            "Smart TV",
            "Smoking Allowed",
            "TV",
            "Towels",
            "Washer",
            "Wheelchair Accessible",
            "Wireless Internet",
        ];

        DB::table('amenities_list')
            ->whereNotIn('amenities_name', $valid_amenties)
            ->update(['status' => 0]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amenities_list', function (Blueprint $table) {
            //
        });
    }
}
