<?php

use Illuminate\Database\Seeder;

class HomeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\HomeListing::updateOrCreate(
            [
                'location' => 'Nevada',
            ],
            [
                'location' => 'Nevada',
                'image_url' => '/storage/public/HomePage/Nevada.webp',
                'lat' => 38.8026,
                'lng' => -116.4194,
            ],
        );
        \App\Models\HomeListing::updateOrCreate(
            [
                'location' => 'New York',
            ],
            [
                'location' => 'New York',
                'image_url' => '/storage/public/HomePage/NewYork.webp',
                'lat' => 40.7128,
                'lng' => -74.006,
            ],
        );
        \App\Models\HomeListing::updateOrCreate(
            [
                'location' => 'Oregon',
            ],
            [
                'location' => 'Oregon',
                'image_url' => '/storage/public/HomePage/Oregon.webp',
                'lat' => 43.8041,
                'lng' => -120.5542,
            ],
        );
        \App\Models\HomeListing::updateOrCreate(
            [
                'location' => 'New Jersey',
            ],
            [
                'location' => 'New Jersey',
                'image_url' => '/storage/public/HomePage/NewJersey.webp',
                'lat' => 40.0583,
                'lng' => -74.4057,
            ],
        );
        \App\Models\HomeListing::updateOrCreate(
            [
                'location' => 'Texas',
            ],
            [
                'location' => 'Texas',
                'image_url' => '/storage/public/HomePage/Texas.webp',
                'lat' => 31.9686,
                'lng' => -99.9018,
            ],
        );
        \App\Models\HomeListing::updateOrCreate(
            [
                'location' => 'Arizona',
            ],
            [
                'location' => 'Arizona',
                'image_url' => '/storage/public/HomePage/Arizona.webp',
                'lat' => 34.0489,
                'lng' => -111.0937,
            ],
        );
        \App\Models\HomeListing::updateOrCreate(
            [
                'location' => 'South Dakota',
            ],
            [
                'location' => 'South Dakota',
                'image_url' => '/storage/public/HomePage/SouthDakota.webp',
                'lat' => 43.9695,
                'lng' => -99.9018,
            ],
        );
        \App\Models\HomeListing::updateOrCreate(
            [
                'location' => 'California',
            ],
            [
                'location' => 'California',
                'image_url' => '/storage/public/HomePage/California.webp',
                'lat' => 36.7783,
                'lng' => -119.4179,
            ],
        );
    }
}
