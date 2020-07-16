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
                'role' => 'RV TRAVELLER',
            ],
            [
                'role' => 'RV TRAVELLER',
                'client_id' => 15465793,
                'status' => 1,
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
    }
}
