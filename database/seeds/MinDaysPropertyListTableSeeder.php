<?php

use Illuminate\Database\Seeder;

class MinDaysPropertyListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $updatedRows = DB::table('property_list')
            ->where('min_days', '<', 30)
            ->update(['min_days' => 30]);
        Log::info("Number of properties updated for min days: " . $updatedRows);
    }
}
