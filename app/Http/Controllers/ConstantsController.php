<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

$BASE_URL = config("app.url");

define("MAP_MARKER_ICON", "http://api.estatevue2.com/cdn/img/marker-green.png");
define("PROFILE_IMAGE", "https://demo.rentalslew.com/public/user_profile_default.png");
define("STATIC_IMAGE", "http://vyrelilkudumbam.com/wp-content/uploads/2014/07/NO_DATAy.jpg");
define("APP_BASE_NAME", "Health Care Travels");

define("APP_LOGO_URL", "https://demo.rentalslew.com/public/keepers_logo.png");
define("TIMEZONE", "Asia/Kolkata");

define("BASE_URL", $BASE_URL . "/");

define("BASE_COLOR", "e88016");
define("CLIENT_ID", "15465793");
define("RADIUS", 100);
define("MOST_POPULAR", 1);
define("ACTIVE", 1);
define("BLOCK", 0);
define("SUCCESS", "SUCCESS");
define("SAMPLE_IMAGE", "http://res.cloudinary.com/dazx7zpzb/image/upload/v1519884570/sample.jpg");
define("CLEANING_FEE_TYPES", serialize(["Per Night", "Per Guest", "Per Night Per Guest", "Single Fee"]));
define("CITY_FEE_TYPES", serialize(["Per Night", "Per Guest", "Per Night Per Guest", "Single Fee"]));

define("UPLOAD_CLOUD_NAME", "dazx7zpzb");
define("UPLOAD_API_KEY", "139546971995199");
define("UPLOAD_API_SECRET", "knkkiEXjEsceHTNjfSRADRvmSHQ");
define("UPLOAD_BASE_DELIVERY_URL", "http://res.cloudinary.com/dazx7zpzb");
define("UPLOAD_SECURE_DELIVERY_URL", "https://res.cloudinary.com/dazx7zpzb");

define("UPLOAD_API_BASE_URL", "https://api.cloudinary.com/v1_1/dazx7zpzb");

define("COUNTRY_CODE", config("app.country_code"));

define("ZERO", 0);
define("ONE", 1);
define("TWO", 2);
define("THREE", 3);
define("FOUR", 4);
define("FIVE", 5);
define("SIX", 6);
define("SEVEN", 7);
define("EIGHT", 8);
define("NINE", 9);
define("TEN", 10);

define("PROPERTY_IMAGE_WIDTH", 520);
define("PROPERTY_IMAGE_HEIGHT", 400);
define("DOUBLE_BED", $BASE_URL . "/bedicons/King,-Queen,Double-Bed.png");
define("QUEEN_BED", $BASE_URL . "/bedicons/King,-Queen,Double-Bed.png");
define("SINGLE_BED", $BASE_URL . "/bedicons/Single.png");
define("SOFA_BED", $BASE_URL . "/bedicons/Sofa.png");
define("BUNK_BED", $BASE_URL . "/bedicons/Bunk-Bed.png");
define("COMMON_SPACE_BED", $BASE_URL . "/bedicons/Couch.png");

define("GOOGLE_MAPS_API_KEY", config("services.google.maps_api_key"));
define("RECAPTCHA_SITE_KEY", config("services.google.captcha_site_key"));
define("RECAPTCHA_SECRET_KEY", config("services.google.captcha_secret_key"));

define("INSTANT_CHAT", "instant_chat");
define("REQUEST_CHAT", "request_chat");
define("PERSONAL_CHAT", "personal_chat");

define(
    "MONTHS",
    serialize([
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ]),
);

//define("UPLOAD_CLOUD_NAME","dazx7zpzb");
define("START_YEAR", "2018");
define("END_YEAR", "2040");
$Settings = Settings::where("param", "logo")->first();
define("LOGO", $Settings->value);
$Settings = Settings::where("param", "app_name")->first();
define("APP_NAME", $Settings->value);
$Settings = Settings::where("param", "currency")->first();
define("CURRENCY", $Settings->value);
$Settings = Settings::where("param", "client_email")->first();
define("CLIENT_MAIL", $Settings->value);
$Settings = Settings::where("param", "client_phone")->first();
define("CLIENT_PHONE", $Settings->value);
$Settings = Settings::where("param", "client_web")->first();
define("CLIENT_WEB", $Settings->value);
$Settings = Settings::where("param", "client_address")->first();
define("CLIENT_ADDRESS", $Settings->value);
$Settings = Settings::where("param", "contact_content")->first();
define("CONTACT_CONTENT", $Settings->value);
$Settings = Settings::where("param", "verification_mail")->first();
define("VERIFY_MAIL", $Settings->value);
$Settings = Settings::where("param", "support_mail")->first();
define("SUPPORT_MAIL", $Settings->value);
$Settings = Settings::where("param", "facebook")->first();
define("FACEBOOK", $Settings->value);
$Settings = Settings::where("param", "twitter")->first();
define("TWITTER", $Settings->value);
$Settings = Settings::where("param", "google")->first();
define("GOOGLE", $Settings->value);
$Settings = Settings::where("param", "instagram")->first();
define("INSTAGRAM", $Settings->value);

class ConstantsController extends Controller
{
    public function generate_hash($value)
    {
        return hash_hmac("ripemd160", "sparkout", $value);
    }

    public function get_percentage($percentage, $value)
    {
        return $percentage_amount = ($percentage / 100) * $value;
    }
}
