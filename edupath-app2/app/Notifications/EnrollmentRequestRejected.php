<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnrollmentRequestRejected extends Notification
{

    public function __construct(public array $data)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Enrollment Request was Rejected')
            ->greeting('Hello ' . ($this->data['full_name'] ?? 'Student'))
            ->line('Your enrollment request for ' . ($this->data['program_name'] ?? 'your chosen program') . ' was not approved at this time.')
            ->line('You may contact the registrar for more information.');
    }
}


