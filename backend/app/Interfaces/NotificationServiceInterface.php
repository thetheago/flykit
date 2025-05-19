<?php

namespace App\Interfaces;

interface NotificationServiceInterface
{
    public function sendNotification(string $email, string $subject, string $body): void;
}