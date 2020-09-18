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
        // Type 10: Traveler has a booking with checkin in less than 24 hours
        // Type 11: Owner has stay in less than 24 hours
        // Type 12: Traveler has a booking ending in less than 24 hours
        // Type 13: Owner has stay ending in less than 24 hours
        // Type 14: Security deposit deposited back into traveler's account

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
                'type' => 4,
                'role_id' => 0,
            ],
            [
                'type' => 4,
                'role_id' => 0,
                'title' => 'Health Care Travels',
                'subject' => 'Booking Request Submitted',
                'message' => 'You have submitted a new booking request for the below property.',
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
        // \App\Models\EmailConfig::updateOrCreate(
        //     [
        //         'type' => 10,
        //     ],
        //     [
        //         'type' => 10,
        //         'title' => 'Health Care Travels',
        //         'subject' => 'Your Stay at {{propertyName}}',
        //         'message' =>
        //             "Your stay at Property Name is starting in 24 hours. Please be sure to contact the property owner to discuss how to enter the property and begin your stay. ",
        //         'role_id' => 0,
        //         'updated_at' => date("Y-m-d H:i:s"),
        //     ],
        // );
        // \App\Models\EmailConfig::updateOrCreate(
        //     [
        //         'type' => 11,
        //     ],
        //     [
        //         'type' => 11,
        //         'title' => 'Health Care Travels',
        //         'subject' => 'Your Booking is Starting Soon',
        //         'message' =>
        //             "Traveler username's stay at your property name is starting in less than 24 hours. Make sure you contact each other beforehand to coordinate entry.",
        //         'role_id' => 0,
        //         'updated_at' => date("Y-m-d H:i:s"),
        //     ],
        // );
        // \App\Models\EmailConfig::updateOrCreate(
        //     [
        //         'type' => 12,
        //     ],
        //     [
        //         'type' => 12,
        //         'title' => 'Health Care Travels',
        //         'subject' => 'Your Stay at {{propertyName}} is Ending',
        //         'message' =>
        //             "Your stay at Property Name is ending in 24 hours. Please be sure to contact the property owner to do a walk-through of the home before you leave. If the property owner finds no damage you will receive your full security deposit three days after check-out.",
        //         'role_id' => 0,
        //         'updated_at' => date("Y-m-d H:i:s"),
        //     ],
        // );
        // \App\Models\EmailConfig::updateOrCreate(
        //     [
        //         'type' => 13,
        //     ],
        //     [
        //         'type' => 13,
        //         'title' => 'Health Care Travels',
        //         'subject' => 'Your Booking at {{propertyName}} is Ending',
        //         'message' =>
        //             "Your booking with Traveler username at Property Name is ending in 24 hours. Please be sure to contact the traveler to do a walk-through of the home before you leave. If you find any damage, be sure to contact us immediately.",
        //         'role_id' => 0,
        //         'updated_at' => date("Y-m-d H:i:s"),
        //     ],
        // );
        \App\Models\EmailConfig::updateOrCreate(
            [
                'type' => 14,
            ],
            [
                'type' => 14,
                'title' => 'Health Care Travels',
                'subject' => 'Security Deposit Return',
                'message' =>
                    "Your security deposit has been returned in full and deposited into your bank account. We hope you enjoyed your stay!",
                'role_id' => 0,
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        );
    }
}
