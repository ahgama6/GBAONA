<?php

use App\Models\Notification;

if(!function_exists('get_notifications'))
{

    function get_notifications()
    {
        $notifications = Notification::where('user_id',auth()->user()->id)->where('status',0)->get();
        return $notifications;
    }

}
