<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Settings::updateOrCreate(
            [
                'param' => 'client_email',
            ],
            [
                'param' => 'client_email',
                'value' => 'info@healthcaretravels.com',
            ],
        );
        \App\Models\Settings::updateOrCreate(
            [
                'param' => 'support_mail',
            ],
            [
                'param' => 'support_mail',
                'value' => 'support@healthcaretravels.com',
            ],
        );
        \App\Models\Settings::updateOrCreate(
            [
                'param' => 'verification_mail',
            ],
            [
                'param' => 'verification_mail',
                'value' => 'verify@healthcaretravels.com',
            ],
        );
        \App\Models\Settings::updateOrCreate(
            [
                'param' => 'general_mail',
            ],
            [
                'param' => 'general_mail',
                'value' => 'do-not-reply@healthcaretravels.com',
            ],
        );
        \App\Models\Settings::updateOrCreate(
            [
                'param' => 'client_address',
            ],
            [
                'param' => 'client_address',
                'value' =>
                    'Health Care Travels,  7075 Fm 1960 Rd West,  Suite 1010,  Houston, Texas 77069,  United States',
            ],
        );
    }
}
