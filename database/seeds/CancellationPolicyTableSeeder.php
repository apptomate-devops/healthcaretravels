<?php

use Illuminate\Database\Seeder;

class CancellationPolicyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cancellation_policy')
            ->where(['title' => 'Super Strict'])
            ->delete();
    }
}
