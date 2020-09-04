<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;

class Logger
{
    public static function getFilePrefix()
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        $fileCaller = $trace[1];
        $functionCaller = $trace[2];
        $path_parts = pathinfo($fileCaller['file']);
        $fileName = $path_parts['filename'];
        $functionName = $functionCaller['function'];
        return $fileName . "(" . $functionName . "): ";
    }
    public static function info($message, $context = [])
    {
        Log::info(Logger::getFilePrefix() . $message, $context);
    }
    public static function error($message)
    {
        Log::error(Logger::getFilePrefix() . $message);
    }
}
