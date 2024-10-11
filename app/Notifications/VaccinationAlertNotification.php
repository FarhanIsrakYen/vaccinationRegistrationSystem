<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VaccinationAlertNotification extends Notification
{
    use Queueable;

    private $user;
    private $vaccineCenter;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @param $vaccineCenter
     */
    public function __construct($user, $vaccineCenter)
    {
        $this->user = $user;
        $this->vaccineCenter = $vaccineCenter;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Vaccination Reminder')
                    ->greeting('Hello ' . $this->user->name . ',')
                    ->line('Your vaccination is scheduled for tomorrow at ' . $this->vaccineCenter . '.')
                    ->line('Please arrive at the center at your scheduled time.')
                    ->line('Thank you for registering for vaccination!')
                    ->salutation('Regards, The Vaccination Team');;
    }
}
