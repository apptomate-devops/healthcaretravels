<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\AdminUsers::updateOrCreate(
            [
                'email' => 'admin@healthcaretravels.com',
            ],
            [
                'name' => 'Admin',
                'password' => bcrypt('qez5n@KGz1aLFu$F'),
                'pages' => 1,
                'status' => 1,
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
    }
}
