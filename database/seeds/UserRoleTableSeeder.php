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
        $roles = ['HEALTHCARE TRAVELER', 'PROPERTY OWNER', 'AGENCY', 'RV HEALTHCARE TRAVELER', 'COHOST'];
        foreach ($roles as $id => $role) {
            \App\Models\UserRole::updateOrCreate(
                [
                    'id' => $id,
                ],
                [
                    'role' => $role,
                    'client_id' => CLIENT_ID,
                    'status' => 1,
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
            );
        }
    }
}
