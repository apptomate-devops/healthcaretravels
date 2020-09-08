<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

$BASE_URL = config("app.url");

define("MAP_MARKER_ICON", "http://api.estatevue2.com/cdn/img/marker-green.png");
define("PROFILE_IMAGE", "https://demo.rentalslew.com/public/user_profile_default.png");
define("STATIC_IMAGE", "http://vyrelilkudumbam.com/wp-content/uploads/2014/07/NO_DATAy.jpg");
define("APP_BASE_NAME", "Health Care Travels");
define("APP_ENV", env("APP_ENV", "local"));
define("DWOLLA_ENV", config('services.dwolla.env'));

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

define("IS_GOOGLE_SOCIAL_ENABLED", (bool) config("services.google.client_id"));
define("IS_FACEBOOK_SOCIAL_ENABLED", (bool) config("services.facebook.client_id"));

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

define(
    'PASSWORD_REGEX',
    'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#^_+=.:;><~$!%*?&])[A-Za-z\d@#^_+=.:;><~$!%*?&]{8,}$/i',
);
define(
    'PASSWORD_REGEX_MESSAGE',
    'Password should be at least 8 characters long and should contain at least 1 uppercase, 1 lowercase, 1 number and 1 special character',
);

define('ETHNICITY', [
    'American Indian or Alaskan Native',
    'Asian',
    'Black or African American',
    'Native Hawaiian or Pacific Islander',
    'White',
    'Other',
]);

//define("UPLOAD_CLOUD_NAME","dazx7zpzb");
define("START_YEAR", "2018");
define("END_YEAR", "2040");
define("SEARCH_ITEM_COUNT", 10);
$all_settings = Settings::all();
foreach ($all_settings as $setting) {
    switch ($setting->param) {
        case 'logo':
            define("LOGO", $setting->value);
            break;
        case 'app_name':
            define("APP_NAME", $setting->value);
            break;
        case 'currency':
            define("CURRENCY", $setting->value);
            break;
        case 'client_email':
            define("CLIENT_MAIL", $setting->value);
            break;
        case 'client_phone':
            define("CLIENT_PHONE", $setting->value);
            break;
        case 'client_web':
            define("CLIENT_WEB", $setting->value);
            break;
        case 'client_address':
            define("CLIENT_ADDRESS", $setting->value);
            break;
        case 'contact_content':
            define("CONTACT_CONTENT", $setting->value);
            break;
        case 'verification_mail':
            define("VERIFY_MAIL", $setting->value);
            break;
        case 'support_mail':
            define("SUPPORT_MAIL", $setting->value);
            break;
        case 'general_mail':
            define("GENERAL_MAIL", $setting->value);
            break;
        case 'facebook':
            define("FACEBOOK", $setting->value);
            break;
        case 'twitter':
            define("TWITTER", $setting->value);
            break;
        case 'google':
            define("GOOGLE", $setting->value);
            break;
        case 'instagram':
            define("INSTAGRAM", $setting->value);
            break;
        default:
            break;
    }
}

define("TEMPLATE_REGISTER", 1);
define("TEMPLATE_VERIFICATION", 2);
define("TEMPLATE_BOOKING", 3);
define("TEMPLATE_CANCEL_BOOKING", 4);
define("TEMPLATE_PASSWORD_RESET", 5);
define("TEMPLATE_APPROVAL", 6);
define("TEMPLATE_DENIAL", 7);
define("TEMPLATE_VERIFICATION_REMINDER", 8);
define("TEMPLATE_REMOVE_PROFILE_IMAGE", 9);

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
