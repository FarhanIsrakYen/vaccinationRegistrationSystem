<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class VaccinationScheduledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $user;
    private $vaccinationDate;
    private $vaccineCenter;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @param $vaccinationDate
     * @param $vaccineCenter
     */
    public function __construct($user, $vaccinationDate, $vaccineCenter)
    {
        $this->user = $user;
        $this->vaccinationDate = $vaccinationDate;
        $this->vaccineCenter = $vaccineCenter;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $formattedDate = Carbon::parse($this->vaccinationDate)->toFormattedDateString();

        return (new MailMessage)
            ->subject('Vaccination Schedule Notification')
            ->greeting('Hello ' . $this->user->name . ',')
            ->line('We are pleased to inform you that your COVID-19 vaccination has been scheduled.')
            ->line('Vaccination Date: ' . $formattedDate)
            ->line('Vaccine Center: ' . $this->vaccineCenter->name)
            ->line('Location: ' . $this->vaccineCenter->location)
            ->line('Please make sure to bring your NID and confirmation when you arrive for your vaccination.')
            ->line('We look forward to seeing you on your vaccination day.')
            ->line('Thank you for your cooperation!')
            ->salutation('Regards, The Vaccination Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'vaccination_date' => $this->vaccinationDate,
            'vaccine_center' => $this->vaccineCenter->id,
        ];
    }
}
