<?php

use Illuminate\Database\Seeder;

class InitialDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $path = 'database/healthcare.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Healthcare database seeded!');
    }
}
