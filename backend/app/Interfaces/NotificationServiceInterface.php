<?php

namespace App\Interfaces;

interface NotificationServiceInterface
{
    public function sendNotification(string $message): void;
}