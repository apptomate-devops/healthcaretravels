<?php

use Illuminate\Database\Seeder;

class AmenityListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // newly added amenities
        \App\Models\AmenitiesList::updateOrCreate(
            [
                'amenities_name' => 'Roku',
            ],
            [
                'amenities_name' => 'Roku',
                'icon_url' => 'amenities/roku.png',
                'client_id' => 15465793,
                'status' => 1,
            ],
        );
        \App\Models\AmenitiesList::updateOrCreate(
            [
                'amenities_name' => 'Iron/Ironing Board',
            ],
            [
                'amenities_name' => 'Iron/Ironing Board',
                'icon_url' => 'amenities/iron.png',
                'client_id' => 15465793,
                'status' => 1,
            ],
        );
        \App\Models\AmenitiesList::updateOrCreate(
            [
                'amenities_name' => 'Smart TV',
            ],
            [
                'amenities_name' => 'Smart TV',
                'icon_url' => 'amenities/smarttv.png',
                'client_id' => 15465793,
                'status' => 1,
            ],
        );
        \App\Models\AmenitiesList::updateOrCreate(
            [
                'amenities_name' => 'All Utilities Included',
            ],
            [
                'amenities_name' => 'All Utilities Included',
                'icon_url' => 'amenities/utilities.png',
                'client_id' => 15465793,
                'status' => 1,
            ],
        );
        \App\Models\AmenitiesList::where('amenities_name', 'Security Cameras')->update([
            'amenities_name' => 'Security Cameras (Exterior)',
            'client_id' => 15465793,
            'status' => 1,
        ]);
        \App\Models\AmenitiesList::where('amenities_name', 'Dryer')->update([
            'amenities_name' => 'Dryer',
            'icon_url' => 'amenities/Washer.png',
            'client_id' => 15465793,
            'status' => 1,
        ]);
        \App\Models\AmenitiesList::updateOrCreate(
            [
                'amenities_name' => 'Blow dryer',
            ],
            [
                'amenities_name' => 'Blow dryer',
                'icon_url' => 'amenities/hair-dyer.png',
                'client_id' => 15465793,
                'status' => 1,
            ],
        );
    }
}
