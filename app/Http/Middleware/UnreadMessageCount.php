<?php

namespace App\Http\Middleware;

use App\Services\Logger;
use Closure;
use DB;

class UnreadMessageCount
{
    private $request;

    public static function date_compare($a, $b)
    {
        if (gettype($a->date) == "string") {
            $t1 = strtotime($a->date);
        } else {
            $t1 = strtotime($a->date->date);
        }
        if (gettype($b->date) == "string") {
            $t2 = strtotime($b->date);
        } else {
            $t2 = strtotime($b->date->date);
        }
        return $t1 - $t2;
    }

    public function get_unread_chat_count($key, $id)
    {
        try {
            $user_id = $this->request->session()->get('user_id');
            $unread_count = 0;
            $unread_message_data = [];
            if (empty($key) || empty($id)) {
                return [
                    'unread_message_data' => $unread_message_data,
                    'unread_count' => $unread_count,
                ];
            }
            if (defined('FB_URL')) {
                $data = file_get_contents(FB_URL . $key . "/" . $id . ".json");
                $data = json_decode($data);
                $data = (array) $data;
                usort($data, [$this, 'date_compare']);

                foreach ($data as $message) {
                    if ($message->sent_by != $user_id && property_exists($message, 'read') && $message->read == false) {
                        $unread_count++;
                        $unread_message_data = ['message_id' => $id, 'message_key' => $key];
                        break;
                    }
                }
            }
            $data = [
                'unread_message_data' => $unread_message_data,
                'unread_count' => $unread_count,
            ];
            return $data;
        } catch (\Exception $ex) {
            Logger::error('Error getting unread messages' . $ex->getMessage());
            return [
                'unread_message_data' => [],
                'unread_count' => 0,
            ];
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $is_logout_path = strpos($request->path(), 'logout');
        $is_public_ical_path = strpos($request->path(), 'ical/');
        if ($is_logout_path === false && $is_public_ical_path === false) {
            $user_id = $request->session()->get('user_id');
            $this->request = $request;
            $unread_data = [
                'unread_message_data' => [],
                'unread_count' => 0,
            ];
            if ($user_id) {
                $personal_chats = DB::table('personal_chat')
                    ->where(function ($query) use ($user_id) {
                        $query->where('owner_id', '=', $user_id)->orWhere('traveller_id', '=', $user_id);
                    })
                    ->get();
                foreach ($personal_chats as $personal_chat) {
                    $unread_data = $this->get_unread_chat_count('personal_chat', $personal_chat->id);
                    if ($unread_data['unread_count']) {
                        break;
                    }
                }

                if ($unread_data['unread_count'] == 0) {
                    $instant_chats = DB::table('instant_chat')
                        ->where(function ($query) use ($user_id) {
                            $query->where('owner_id', '=', $user_id)->orWhere('traveller_id', '=', $user_id);
                        })
                        ->get();

                    foreach ($instant_chats as $instant_chat) {
                        $unread_data = $this->get_unread_chat_count('instant_chat', $instant_chat->id);
                        if ($unread_data['unread_count']) {
                            break;
                        }
                    }
                }

                if ($unread_data['unread_count'] == 0) {
                    $request_chats = DB::table('request_chat')
                        ->where(function ($query) use ($user_id) {
                            $query->where('owner_id', '=', $user_id)->orWhere('traveller_id', '=', $user_id);
                        })
                        ->get();
                    foreach ($request_chats as $request_chat) {
                        $unread_data = $this->get_unread_chat_count('request_chat', $request_chat->id);
                        if ($unread_data['unread_count']) {
                            break;
                        }
                    }
                }
            }
            $request->session()->put('has_unread_message', $unread_data['unread_count']);
            $request->session()->put('unread_message_data', $unread_data['unread_message_data']);
            $request->has_unread_message = $unread_data['unread_count'];
        }
        return $next($request);
    }
}
