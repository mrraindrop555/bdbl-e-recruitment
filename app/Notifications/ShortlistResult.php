<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShortlistResult extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Application $application)
    {
        $this->application->load('vacancy');

        $this->afterCommit();
    }

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
        return (new MailMessage)
            ->greeting("Hello {$this->application->name}!")
            ->lineIf($this->application->is_selected, "Congratulations! You have been shortlisted for {$this->application->vacancy->position_title}.")
            ->lineIf(!$this->application->is_selected, "Sorry! You have not been shortlisted for {$this->application->vacancy->position_title}.")
            ->action('Result', url("/result/{$this->application->vacancy->id}"))
            ->line('For more information, please contact the employer.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
