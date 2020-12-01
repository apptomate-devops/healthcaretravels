<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\Logger;
use App\Models\EmailConfig;
use Mail;

class SevenDayVerificationReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:verification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends verification reminder email to the users who did not submit the verification documents';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Logger::info('Running verification reminder email job');
        $users = DB::table('users')
            ->where('is_submitted_documents', 0)
            ->where('is_verified', 0)
            ->whereRaw('DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 7 DAY)')
            ->get();
        Logger::info('Number of users found: ' . count($users));
        $reg = EmailConfig::where('type', 8)->first();
        foreach ($users as $user) {
            Logger::info('User data found: ' . $user->email);
            $data = [
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'text' => $reg->message,
                'BASE_URL' => config('app.url') . '/',
                'APP_BASE_NAME' => 'Health Care Travels',
            ];
            try {
                Mail::send('mail.verification-reminder', $data, function ($message) use ($user, $reg) {
                    $message->to($user->email);
                    $message->subject($reg->subject);
                });
            } catch (\Exception $ex) {
                Logger::error('Error sending email to: ' . $user->email . ' : Error: ' . $ex->getMessage());
                return false;
            }
        }
    }
}
