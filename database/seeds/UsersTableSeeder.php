<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UsersTableSeeder extends Seeder
{
    public function decrypt_password($encrypted_password)
    {
        $key = hash('sha256', 'sparkout');
        $iv = substr(hash('sha256', 'developer'), 0, 16);
        $output1 = openssl_decrypt(base64_decode($encrypted_password), "AES-256-CBC", $key, 0, $iv);
        return $output1;
    }

    public function encrypt_password_original($password)
    {
        $key = hash('sha256', 'sparkout');
        $iv = substr(hash('sha256', 'developer'), 0, 16);
        $output = openssl_encrypt($password, "AES-256-CBC", $key, 0, $iv);
        $output2 = base64_encode($output);
        return $output2;
    }

    public function encrypt_password($password)
    {
        return bcrypt($password);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\Users::where('is_encrypted', 0)->get();
        Log::info('Encrypting passwords for users count: ' . count($users));
        echo 'Encrypting passwords for users count: ' . count($users) . PHP_EOL;
        foreach ($users as $user) {
            $decrypted_password = $this->decrypt_password($user->password);
            $password = $this->encrypt_password($decrypted_password);
            \App\Models\Users::where('id', $user->id)->update(['password' => $password, 'is_encrypted' => 1]);
        }
    }
}
