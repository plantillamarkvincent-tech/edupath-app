<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAnnouncementNotification extends Notification
{

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected Announcement $announcement
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $typeLabels = [
            'general' => 'General Announcement',
            'course' => 'Course Update',
            'class' => 'Class Update'
        ];

        $type = $typeLabels[$this->announcement->type] ?? ucfirst($this->announcement->type);

        return (new MailMessage)
                    ->subject("New {$type}: {$this->announcement->title}")
                    ->greeting('Hello!')
                    ->line("A new {$type} has been posted.")
                    ->line("**{$this->announcement->title}**")
                    ->line($this->announcement->content)
                    ->action('View Announcement', url('/student/announcements'))
                    ->line('Thank you for staying updated with our announcements.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $this->announcement->id,
            'type' => $this->announcement->type,
            'title' => $this->announcement->title,
        ];
    }
}
