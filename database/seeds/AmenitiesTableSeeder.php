<?php

use Illuminate\Database\Seeder;

class AmenitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $amenities = \App\Models\AmenitiesList::query()
            ->where('icon_url', 'LIKE', "%public/%")
            ->get();
        Log::info('amenities that need to replace url count: ' . count($amenities));
        echo 'amenities that need to replace url count: ' . count($amenities) . PHP_EOL;
        foreach ($amenities as $amenity) {
            $new_url = str_replace("public/", "", $amenity->icon_url);
            \App\Models\AmenitiesList::where('id', $amenity->id)->update(['icon_url' => $new_url]);
        }
    }
}
