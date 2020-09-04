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
        // Email type details:
        // Type 3 Role 0: Normal Booking request
        // Type 3 Tole 1: Instant Booking
        // Type 6: Account verification email
        // Type 7: Account verification failed email
        // Type 8: Urgent verify your account email
        // Type 9: Profile picture removal notice
        \App\Models\EmailConfig::updateOrCreate(
            [
                'type' => 3,
                'role_id' => 0,
            ],
            [
                'type' => 3,
                'role_id' => 0,
                'title' => 'Health Care Travels',
                'subject' => 'New booking Request from Health Care Travels',
                'message' =>
                    'You have received a new booking request for the below property. Please log in to accept or deny the reservation.',
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
        \App\Models\EmailConfig::updateOrCreate(
            [
                'type' => 3,
                'role_id' => 1,
            ],
            [
                'type' => 3,
                'role_id' => 1,
                'title' => 'Health Care Travels',
                'subject' => 'New booking Request from Health Care Travels',
                'message' =>
                    'You have received a new booking for the below property. Please log in to view the details and contact the traveler.',
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
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
        \App\Models\EmailConfig::updateOrCreate(
            [
                'type' => 7,
            ],
            [
                'type' => 7,
                'title' => 'Health Care Travels',
                'subject' => 'Account Verification Failed',
                'message' =>
                    "Unfortunately, we were unable to verify one or more of the items you shared with us. Your account is not verified at this time.",
                'role_id' => 0,
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
        \App\Models\EmailConfig::updateOrCreate(
            [
                'type' => 8,
            ],
            [
                'type' => 8,
                'title' => 'Health Care Travels',
                'subject' => 'Urgent – Verify Your Account',
                'message' =>
                    "In order to use your Health Care Travels profile, you must submit information and/or documents to verify your account within seven days after opening.",
                'role_id' => 0,
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
        \App\Models\EmailConfig::updateOrCreate(
            [
                'type' => 9,
            ],
            [
                'type' => 9,
                'title' => 'Health Care Travels',
                'subject' => 'Removing Profile Image',
                'message' => "As your profile picture was inappropriate, it is removed by Health Care Travels",
                'role_id' => 0,
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
    }
}
