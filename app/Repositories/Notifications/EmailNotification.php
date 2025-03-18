<?php

namespace App\Repositories\Notifications;

use Illuminate\Support\Facades\Mail;
use App\Repositories\Notifications\NotificationInterface;

class EmailNotification implements NotificationInterface
{
    public function send($to, $mailable): bool
    {
        Mail::to($to)->queue($mailable);
        return true;
    }
}