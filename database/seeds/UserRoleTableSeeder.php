<?php

use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\UserRole::updateOrCreate(
            [
                'id' => 0,
            ],
            [
                'role' => 'HEALTHCARE TRAVELER',
                'client_id' => 15465793,
                'status' => 1,
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
        \App\Models\UserRole::updateOrCreate(
            [
                'id' => 1,
            ],
            [
                'role' => 'PROPERTY OWNER',
                'client_id' => 15465793,
                'status' => 1,
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
        \App\Models\UserRole::updateOrCreate(
            [
                'id' => 2,
            ],
            [
                'role' => 'AGENCY',
                'client_id' => 15465793,
                'status' => 1,
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
        \App\Models\UserRole::updateOrCreate(
            [
                'id' => 3,
            ],
            [
                'role' => 'RV HEALTHCARE TRAVELER',
                'client_id' => 15465793,
                'status' => 1,
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
    }
}
