<?php

namespace App\Repositories\Notifications;

interface NotificationInterface
{
    public function send($to, $mailable): bool;
}