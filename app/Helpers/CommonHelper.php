<?php

use Carbon\Carbon;

if (!function_exists('getCurrentDateTime')) {
    function getCurrentDateTime()
    {
        return Carbon::now(env('APP_TIMEZONE'))->toDateTimeString();
    }
}

