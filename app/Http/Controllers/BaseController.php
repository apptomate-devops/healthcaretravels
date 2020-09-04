<?php

namespace App\Http\Controllers;

use App\Services\Logger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Users;
use App\Models\PropertyList;
use App\Models\Propertyamenties;
use App\Models\Becomeowner;
use App\Models\Propertybooking;
use App\Models\Propertyimage;
use App\Models\Paymentgateway;
use App\Models\Couponecode;
use App\Models\PropertyRoom;
use App\Models\PropertyBedrooms;
use App\Models\ShortTermPricing;
use App\Models\Settings;
use App\Models\BecomeScout;
use App\Models\PropertyBookingPrice;
use App\Models\EmailConfig;

use App\Services\Twilio;
use App\Services\Sendgrid;

use Image;
use DB;
use Log;
use Mail;
use finfo;

define('FB_URL', 'https://health-care-travels.firebaseio.com/');
// define('CLIENT_MAIL', 'info@healthcaretravels.com');

class BaseController extends ConstantsController
{
    //
    protected $db;
    protected $log;
    protected $user;
    protected $propertylist;
    protected $become_owner;
    protected $property_booking;
    protected $payment_gateway;
    protected $coupone_code;

    public function __construct(
        Users $user,
        PropertyList $propertylist,
        Propertyimage $PropertyImage,
        Becomeowner $become_owner,
        Propertybooking $property_booking,
        Paymentgateway $payment_gateway,
        Couponecode $coupone_code,
        PropertyRoom $propertyRoom,
        PropertyBedrooms $propertyBedRooms,
        DB $db,
        Log $log,
        Propertyamenties $property_amenities,
        ShortTermPricing $shor_term_pricing,
        BecomeScout $BecomeScout,
        EmailConfig $emailConfig,
        Request $request
    ) {
        $this->CONSTANTS = ['client_id' => CLIENT_ID, 'MOST_POPULAR' => 1, 'base_url' => $this->get_base_url()];
        $this->db = $db;
        $this->log = $log;
        $this->user = $user;
        $this->shor_term_pricing = $shor_term_pricing;
        $this->property_amenities = $property_amenities;
        $this->propertylist = $propertylist;
        $this->become_owner = $become_owner;
        $this->property_booking = $property_booking;
        $this->payment_gateway = $payment_gateway;
        $this->coupone_code = $coupone_code;
        $this->propertyList = $propertylist;
        $this->propertyRoom = $propertyRoom;
        $this->propertyBedRooms = $propertyBedRooms;
        $this->BecomeScout = $BecomeScout;
        $this->emailConfig = $emailConfig;
        $this->PropertyImage = $PropertyImage;
        // $this->Couponecode=$Couponecode;
        $this->request = $request;
        $this->twilio = new Twilio();
        $this->sendgrid = new Sendgrid();
    }

    public static function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $oldValue = strtok($str, "{$envKey}=");

        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);

        // Reload the cached config
        if (file_exists(App::getCachedConfigPath())) {
            Artisan::call("config:cache");
        }
    }

    public function validate_image($request)
    {
        if (!$request->file('image')) {
            return ['status' => false, 'error_message' => 'Please upload image'];
        } else {
            $ext = $request->file('image')->getClientOriginalExtension();
            $format = ['jpg', 'jpeg', 'png', 'JPEG', 'PNG', 'JPG'];
            if (!in_array($ext, $format)) {
                return ['status' => false, 'error_message' => 'Please upload valid image'];
            }
        }
        return ['status' => true];
    }

    public function base_image_upload($request, $key, $path)
    {
        $file = $request->file($key);
        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $imageName = self::generate_random_string() . '.' . $ext;
            $path = $file->storeAs($path, $imageName);
            return '/storage/' . $path;
        }
        return '';
    }

    public function base_image_upload_array($file, $path)
    {
        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $imageName = self::generate_random_string() . '.' . $ext;
            $path = $file->storeAs($path, $imageName);
            return '/storage/' . $path;
        }
        return '';
    }

    public function get_storage_file($filePath)
    {
        $qualifiedFilePath = storage_path('app/' . $filePath);
        if (!\Storage::disk('local')->exists($filePath)) {
            return abort('404');
        }
        return response()->file($qualifiedFilePath);
    }

    public function base_document_upload_with_key($request, $key)
    {
        $file = $request->file($key);
        $image = $request->$key;
        $ext = $image->getClientOriginalExtension();
        $imageName = self::generate_random_string() . '.' . $ext;
        $this->store_encrypted_file($file, $imageName);
        return $image_url = "documents/" . $imageName;
    }

    public function store_encrypted_file($file, $fileName)
    {
        $fileContent = file_get_contents($file->getRealPath());
        $encryptedContent = \Crypt::encrypt($fileContent);
        \Storage::put($fileName . '.dat', $encryptedContent);
    }

    public function get_encrypted_file($fileName)
    {
        $encryptedContents = \Storage::get($fileName . '.dat');
        $decryptedContents = \Crypt::decrypt($encryptedContents);
        $type = (new finfo(FILEINFO_MIME))->buffer($decryptedContents);
        $data = [
            'type' => (new finfo(FILEINFO_MIME))->buffer($decryptedContents),
            'content' => $decryptedContents,
        ];
        return $data;
    }

    public function base_image_upload_with_key($request, $key)
    {
        // var_dump($request->$key);exit; keepers_logo.png
        $image = $request->$key;
        //$imageName = $request->file($key)->getClientOriginalName();
        $ext = $image->getClientOriginalExtension();
        $imageName = self::generate_random_string() . '.' . $ext;
        $request->file($key)->move('public/uploads/', $imageName);
        return $image_url = "public/uploads/" . $imageName;
    }

    public function base_image_upload_with_keys($request, $key)
    {
        // var_dump($request->$key);exit; keepers_logo.png
        $image = $request->$key;
        //$imageName = $request->file($key)->getClientOriginalName();
        $ext = $image->getClientOriginalExtension();
        $imageName = 'keepers_logo.png';
        $request->file($key)->move('public/', $imageName);
        return $image_url = BASE_URL . "public/uploads/" . $imageName;
    }

    public function get_email($id)
    {
        $data = DB::table('users')
            ->where('client_id', CLIENT_ID)
            ->where('id', $id)
            ->first();
        return $data->email;
    }

    public function send_email($email, $view_name, $data)
    {
        try {
            Mail::send($view_name, $data, function ($message) use ($email) {
                $message->from('gotocva@gmail.com', 'Mail from ' . APP_BASE_NAME);
                $message->to($email);
                $message->subject('Mail from ' . APP_BASE_NAME);
            });
        } catch (\Exception $ex) {
            Logger::error('Error sending email to: ' . $email);
            return false;
        }
    }
    public function send_email_listing($email, $view_name, $data, $subject)
    {
        try {
            Mail::send($view_name, $data, function ($message) use ($email) {
                $message->from('gotocva@gmail.com', 'Mail from ' . APP_BASE_NAME);
                $message->to($email);
                $message->subject($subject);
            });
        } catch (\Exception $ex) {
            Logger::error('Error sending email to: ' . $email);
            return false;
        }
    }

    public function send_email_contact($email, $subject, $view_name, $data, $name)
    {
        try {
            Mail::send($view_name, $data, function ($message) use ($email, $subject, $name) {
                $message->from($email, 'Mail from ' . $name);
                $message->replyTo($email, $name);
                $message->to(SUPPORT_MAIL);
                $message->subject($subject);
            });
        } catch (\Exception $ex) {
            Logger::error('Error sending email to: ' . $email);
            return false;
        }
    }

    public function send_custom_email($email, $subject, $view_name, $data, $title, $from = GENERAL_MAIL)
    {
        $mail_title = $title;
        $mail_from = $from ? $from : GENERAL_MAIL;
        try {
            Mail::send($view_name, $data, function ($message) use ($email, $mail_title, $subject, $mail_from) {
                Logger::info('Sending Mail From: ' . $mail_from . ' To: ' . $email);
                $message->from($mail_from, config('mail.from.name'));
                $message->to($email);
                $message->subject($subject);
            });
        } catch (\Exception $ex) {
            Logger::error('Error sending email to: ' . $email . ' : Error: ' . $ex->getMessage());
            return false;
        }
    }
    public function send_custom_email_admin($email, $subject, $view_name, $data)
    {
        try {
            Mail::send($view_name, $data, function ($message) use ($email, $subject) {
                $message->from('gotocva@gmail.com', "Mail from " . APP_BASE_NAME);
                $message->to($email);
                $message->subject($subject);
            });
        } catch (\Exception $ex) {
            Logger::error('Error sending email to: ' . $email);
            return false;
        }
    }

    public static function null_safe_obj($arr)
    {
        $newArr = [];
        foreach ($arr as $key => $value) {
            $newArr[$key] = $value == null ? "" : $value;
            $newArr[$key] = $value == null ? "" : $value;
        }
        return $newArr;
    }

    public static function null_safe($data)
    {
        array_walk_recursive($data, function (&$item, $key) {
            $item = null === $item ? '' : $item;
        });
        return $data;
    }

    public function remove_null($data)
    {
        # code...
        foreach ($data as $k => $obj) {
            foreach ($obj as $key => $value) {
                if (is_null($value)) {
                    $obj->$key = "";
                }
            }
        }
        return $data;
    }

    public function remove_null_obj($data)
    {
        # code...
        foreach ($data as $key => $value) {
            if (is_null($value)) {
                $data->$key = "";
            }
        }
        return $data;
    }

    public function send_push_notification($user_id, $title, $message)
    {
        $user = DB::table('users')
            ->where('id', $user_id)
            ->first();
        $device_token = $user->device_token;
        // $device_token = "f_ZXeVPxK5k:APA91bE3FxmrPDQAeTc17j17CHyliLQ3D0iOhnQfsQz4coqyBfeHPYF6zMeJKDfX1wrwLWzp6bAkGCYRQ3Z_VUv0Z6xyUBKurpfXAT4-vJLO_X6PtlIyHE4UtKdZwdsy1ua8c_3V4zRZ";
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = [
            'registration_ids' => [$device_token],
            'data' => [
                "title" => $title,
                "message" => $message,
            ],
        ];
        // var_dump($fields);
        $fields = json_encode($fields);
        $headers = ['Authorization: key= AIzaSyBjeS0XBquWYp2ns9aGejcne0KLp77cp7k', 'Content-Type: application/json'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);

        // print_r($result);exit;
        curl_close($ch);
    }

    public function send_push($device_token, Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = [
            'registration_ids' => [$device_token],
            'data' => [
                "title" => "test",
                "message" => "test message content main",
            ],
        ];
        $fields = json_encode($fields);
        $headers = [
            'Authorization: key=' . "AIzaSyBjeS0XBquWYp2ns9aGejcne0KLp77cp7k",
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);
    }

    public function get_static_image()
    {
        return STATIC_IMAGE;
    }

    public function get_base_url()
    {
        //return 'http://localhost/keepers/';http://13.127.130.227
        return BASE_URL;
    }

    public function firebase_base_url()
    {
        return FB_URL;
    }

    public function constants()
    {
        $constants = [
            'client_id' => CLIENT_ID,
            'MOST_POPULAR' => 1,
            'base_url' => $this->get_base_url(),
        ];
        return $constants;
    }

    public function get_client_id()
    {
        return CLIENT_ID;
    }

    public function get_radius()
    {
        return RADIUS;
    }

    public function get_firebase_last_message($key, $id)
    {
        $data = file_get_contents(FB_URL . $key . "/" . $id . "/.json");
        $data = json_decode($data);
        $data = (array) $data;
        $d = count($data);
        $numItems = count($data);
        $i = 0;
        foreach ($data as $key => $value) {
            if (++$i === $numItems) {
                return $value->message;
            }
        }
    }

    public function image_upload($width, $height, $image)
    {
        $file_name = time();
        $file_name .= rand();
        if ($image) {
            $ext = $image->getClientOriginalExtension();
            $path_url = public_path('uploads/' . date("dmY"));
            if ($image->move($path_url, $file_name . "." . $ext)) {
                $local_url = $file_name . "." . $ext;
                $s3_url = BASE_URL . "public/uploads/" . $local_url;
                return $s3_url;
            }
        }
        return "";

        $file_name = 'public/uploads/' . date('dmY') . '-' . rand(1111, 9999) . '.jpg';
        Image::make($image)
            ->resize($width, $height)
            ->save($file_name);
        return BASE_URL . $file_name;
    }

    public function upload_picture($picture)
    {
        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);
        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $path_url = public_path('uploads/carpic/' . date("dmY"));
            $picture->move($path_url, $file_name . "." . $ext);
            $local_url = $file_name . "." . $ext;

            $s3_url = BASE_URL . $path_url . $local_url;

            return $s3_url;
        }
        return "";
    }

    public function encrypt_password($password)
    {
        return bcrypt($password);
    }

    public function decrypt_password($encrypted_password)
    {
        $key = hash('sha256', 'sparkout');
        $iv = substr(hash('sha256', 'developer'), 0, 16);
        $output1 = openssl_decrypt(base64_decode($encrypted_password), "AES-256-CBC", $key, 0, $iv);
        return $output1;
    }

    public function auth_check($client_id, $auth_id, $auth_token)
    {
        return 1;

        $errors = [];
        $errors['status'] = 'FAILED';

        if (!$client_id) {
            $errors['error_message'] = 'Client id should not be null';
            return $errors;
        }
        if (!$auth_id) {
            $errors['error_message'] = 'auth id should not be null';
            return $errors;
        }
        if (!$auth_token) {
            $errors['error_message'] = 'auth token should not be null';
            return $errors;
        }
        $auth_token = (int) $auth_token;
        LOG::info("client_id is : " . $client_id);
        LOG::info("Auth id : " . $auth_id);
        LOG::info("auth_token is : " . $auth_token);
        $check = DB::table('client_settings')
            ->where('client_id', '=', $client_id)
            ->first();
        if (count($check) == 0) {
            $errors['error_message'] = 'Wrong client id provided';
            return $errors;
        }
        $check_auth = DB::table('users')
            ->where('client_id', '=', $client_id)
            ->where('id', $auth_id)
            ->where('auth_token', $auth_token)
            ->first();
        if (count($check_auth) == 0) {
            $errors['error_message'] = 'Auth id , Auth token doesn`t match';
            return $errors;
        }
        return 1;
    }

    public function throw_error($error)
    {
        $errors = [];
        $errors['status'] = 'FAILED';
        $errors['error_message'] = $error;
        return $errors;
    }

    public function client_check($client_id)
    {
        if (!$client_id) {
            return 0;
        }
        $check = DB::table('client_settings')
            ->where('client_id', '=', $client_id)
            ->first();
        if (count($check) == 0) {
            return 0;
        } else {
            return 1;
        }
    }

    /** sendTwilioMessage - Sends message to the specified number using twilio.
     * @param Number $number string phone number of recipient
     * @param String $body Body/Message of sms
     */
    public function sendTwilioMessage($number, $body)
    {
        return $this->twilio->sendMessage($number, $body);
    }

    /** sendOTPMessage - Sends otp message to the specified number using twilio.
     * @param Number $number string phone number of recipient
     * @param $otp
     * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
     */
    public function sendOTPMessage($number, $otp)
    {
        $body = "Your Health Care Travels verification code is: " . $otp;
        return $this->twilio->sendMessage(COUNTRY_CODE . $number, $body);
    }

    public function sendSms($NUMBER, $OTP)
    {
        $NAME = "User ";
        $API_KEY = "d37cc8c6-18f7-11e7-9462-00163ef91450";
        $SENDER_ID = "SPRKOT";

        $data =
            "module=TRANS_SMS&apikey=" .
            $API_KEY .
            "&to=" .
            $NUMBER .
            "&from=" .
            $SENDER_ID .
            "&templatename=" .
            $SENDER_ID .
            "&var1=" .
            $NAME .
            "&var2=" .
            $OTP;
        $ch = curl_init('https://2factor.in/API/R1/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // This is the result from the API
        curl_close($ch);
        LOG::info("SEND sms success with phone : " . $NUMBER . "--OTP -- : " . $OTP);
        return $result;
        //        return true;
        //return file_get_contents($URL);
    }

    public function get_weekend_count($start, $end)
    {
        $current = $start;
        $end = date('Y-m-d', strtotime($end . ' +1 day'));
        $friday_count = 0;
        $saturday_count = 0;
        $sunday_count = 0;
        $total = 0;
        while ($current != $end) {
            if (date('l', strtotime($current)) == 'Friday') {
                $friday_count++;
            }
            if (date('l', strtotime($current)) == 'Saturday') {
                $saturday_count++;
            }
            if (date('l', strtotime($current)) == 'Sunday') {
                $sunday_count++;
            }
            $total++;
            $current = date('Y-m-d', strtotime($current . ' +1 day'));
        }

        $result = [];
        $result['friday_count'] = $friday_count;
        $result['saturday_count'] = $saturday_count;
        $result['sunday_count'] = $sunday_count;
        $result['total'] = $total;

        return $result;
    }

    public function createDateRangeArray($strDateFrom, $strDateTo)
    {
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.
        // could test validity of dates here but I'm already doing
        // that in the main script

        $aryRange = [];

        $iDateFrom = mktime(
            1,
            0,
            0,
            substr($strDateFrom, 5, 2),
            substr($strDateFrom, 8, 2),
            substr($strDateFrom, 0, 4),
        );
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
            while ($iDateFrom < $iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }
        return $aryRange;
    }

    public function generate_random_string()
    {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return strtoupper($randomString);
    }

    public function general_error()
    {
        return view('general_error');
    }

    public function yelp_hospitals($latitude, $longitude)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL =>
                "https://api.yelp.com/v3/businesses/search?term=Hospitals&latitude=" .
                $latitude .
                "&longitude=" .
                $longitude .
                "&categories=Hospitals",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                ": ",
                "Authorization: Bearer 2VrGpTKudSRtKANUG7AyV1U3XUmBfncI9j2elSL6ToFTWAcLL7OmoKUvSsk6UUDIvEZ2K0L6wvmE_og_ietPZzadSzJSuBHv_ScRrlQlP6FOOquLJdfT0zUCv4zUWnYx",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $result = json_decode($response);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $result;
        }
    }

    public function yelp_pets($latitude, $longitude)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL =>
                "https://api.yelp.com/v3/businesses/search?term=pets&latitude=" .
                $latitude .
                "&longitude=" .
                $longitude .
                "&categories=pets",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                ": ",
                "Authorization: Bearer 2VrGpTKudSRtKANUG7AyV1U3XUmBfncI9j2elSL6ToFTWAcLL7OmoKUvSsk6UUDIvEZ2K0L6wvmE_og_ietPZzadSzJSuBHv_ScRrlQlP6FOOquLJdfT0zUCv4zUWnYx",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $result = json_decode($response);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $result;
        }
    }

    public function read_ical($file)
    {
        // $file="https://www.airbnb.co.in/calendar/ical/29372541.ics?s=fb0311e20d44e41ce4c2b489a6751f20";
        ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 6.0)');
        $icalString = file_get_contents($file);
        $icsDates = [];
        /* Explode the ICs Data to get datas as array according to string ‘BEGIN:’ */
        $icsData = explode("BEGIN:", $icalString);
        /* Iterating the icsData value to make all the start end dates as sub array */
        foreach ($icsData as $key => $value) {
            $icsDatesMeta[$key] = explode("\n", $value);
        }
        /* Itearting the Ics Meta Value */
        foreach ($icsDatesMeta as $key => $value) {
            foreach ($value as $subKey => $subValue) {
                /* to get ics events in proper order */
                $icsDates = $this->getICSDates($key, $subKey, $subValue, $icsDates);
            }
        }
        return $icsDates;
    }

    public function getICSDates($key, $subKey, $subValue, $icsDates)
    {
        if ($key != 0 && $subKey == 0) {
            $icsDates[$key]["BEGIN"] = $subValue;
        } else {
            $subValueArr = explode(":", $subValue, 2);
            if (isset($subValueArr[1])) {
                $icsDates[$key][$subValueArr[0]] = $subValueArr[1];
            }
        }
        return $icsDates;
    }
}
