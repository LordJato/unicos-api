<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token, $name;

    
    public function __construct($token, $name)
    {
        $this->token = $token;
        $this->name = $name;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $resetPasswordUrl = env('SPA_URL') . "/" . env('SPA_URL_FORGOT_PASSWORD')."?token={$this->token}";

        return (new MailMessage)
            ->greeting('Hello ' . $this->name . ',')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Click here', $resetPasswordUrl)
            ->line('If you did not request a password reset, no further action is required.');
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
