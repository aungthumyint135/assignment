<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('errorLogger')) {
    function errorLogger($exception, $file = null, $line = null)
    {
        $path = 'logs/errors/' . 'error-log-' . date('Y-m-d') . '.log';

        config()->set('logging.channels.errorlog.path', storage_path($path));

        Log::channel('errorlog')->error(json_encode([
            'time' => localDt('h:i A'), 'msg' => $exception, 'file' => $file, 'line' => $line
        ]));
    }
}


if (!function_exists('localDt')) {
    function localDt($format = 'Y-m-d H:i:s'): string
    {
        $tz = 'Asia/Yangon';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz));
        $dt->setTimestamp($timestamp);

        return $dt->format($format);
    }
}

