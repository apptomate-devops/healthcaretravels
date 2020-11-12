<?php

use Illuminate\Database\Seeder;

define("CLIENT_ID", "15465793");

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EmailConfigTableSeeder::class);
        $this->call(AdminUsersTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(PropertyListSeeder::class);
        $this->call(PropertyListingRoomTypesSeeder::class);
        $this->call(MinDaysPropertyListTableSeeder::class);
        $this->call(HandlePublicURLSeeder::class);
        $this->call(CancellationPolicyTableSeeder::class);
        $this->call(HomeCategorySeeder::class);
    }
}
