<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class UnreadMessageCount
{
    private $request;

    public function get_unread_chat_count($key, $id)
    {
        $user_id = $this->request->session()->get('user_id');
        $unread_count = 0;
        $data = file_get_contents(FB_URL . $key . "/" . $id . "/.json");
        $data = json_decode($data);
        $data = (array) $data;

        foreach ($data as $message) {
            if ($message->sent_by != $user_id && property_exists($message, 'read') && $message->read == false) {
                $unread_count++;
                break;
            }
        }
        return $unread_count;
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
        $user_id = $request->session()->get('user_id');
        $this->request = $request;
        $has_unread_message = 0;
        if ($user_id) {
            $personal_chats = DB::table('personal_chat')
                ->where(function ($query) use ($user_id) {
                    $query->where('owner_id', '=', $user_id)->orWhere('traveller_id', '=', $user_id);
                })
                ->get();
            foreach ($personal_chats as $personal_chat) {
                $has_unread_message = $this->get_unread_chat_count('personal_chat', $personal_chat->id);
                if ($has_unread_message) {
                    break;
                }
            }

            if ($has_unread_message == 0) {
                $instant_chats = DB::table('instant_chat')
                    ->where(function ($query) use ($user_id) {
                        $query->where('owner_id', '=', $user_id)->orWhere('traveller_id', '=', $user_id);
                    })
                    ->get();

                foreach ($instant_chats as $instant_chat) {
                    $has_unread_message = $this->get_unread_chat_count('instant_chat', $instant_chat->id);
                    if ($has_unread_message) {
                        break;
                    }
                }
            }

            if ($has_unread_message == 0) {
                $request_chats = DB::table('request_chat')
                    ->where(function ($query) use ($user_id) {
                        $query->where('owner_id', '=', $user_id)->orWhere('traveller_id', '=', $user_id);
                    })
                    ->get();
                foreach ($request_chats as $request_chat) {
                    $has_unread_message = $this->get_unread_chat_count('request_chat', $request_chat->id);
                    if ($has_unread_message) {
                        break;
                    }
                }
            }
        }
        $request->session()->put('has_unread_message', $has_unread_message);
        $request->has_unread_message = $has_unread_message;
        return $next($request);
    }
}
