<?php

use Illuminate\Database\Seeder;

class EmailConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\EmailConfig::updateOrCreate(
            [
                'type' => 6,
            ],
            [
                'type' => 6,
                'title' => 'Health Care Travels',
                'subject' => 'Account Verified',
                'message' =>
                    "Welcome to Health Care Travels! Your account has been verified. Now you are able to access our platform's full functionality. Login at the link below.",
                'role_id' => 0,
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
    }
}
