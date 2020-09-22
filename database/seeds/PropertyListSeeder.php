<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class PropertyListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //        $selected_property = 9;
        //        $last_date = '2020-7-30';
        //        $properties = DB::select(
        //            DB::raw(
        //                "select `id`, `created_at` from `property_list` where `id` <> " .
        //                    $selected_property .
        //                    " and date(`created_at`) <= date('" .
        //                    $last_date .
        //                    " 00:00:00')",
        //            ),
        //        );
        //
        //        if (count($properties)) {
        //            $ids = array_map(function ($v) {
        //                return $v->id;
        //            }, $properties);
        //            $this->command->info("Deleting these properties: " . implode(', ', $ids));
        //            $delete_records = \App\Models\PropertyList::whereIn('id', $ids)->delete();
        //            Log::info("Number of properties deleted: " . $delete_records);
        //        }
        DB::table('property_list')
            ->where(['room_type' => 'Shared Room'])
            ->update(['room_type' => 'Share Room']);
        DB::table('property_list')
            ->where(['room_type' => 'Entire House'])
            ->update(['room_type' => 'Entire Place']);
    }
}
