<?php

use Illuminate\Database\Seeder;

class PropertyListingRoomTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $room_types = ['Entire Place', 'Private Room', 'Shared Room', 'RV Parking'];
        foreach ($room_types as $key => $value) {
            $id = $key + 1;
            \App\Models\PropertyRoomTypes::updateOrCreate(
                [
                    'id' => $id,
                ],
                [
                    'name' => $value,
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
            );
        }
    }
}
