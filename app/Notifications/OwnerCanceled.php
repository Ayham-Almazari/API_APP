<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OwnerCanceled extends Notification
{
    use Queueable;

    private $owner;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($owner)
    {
        $this->owner=$owner;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Canceled Account')
            ->line('Welcome '.$this->owner->first_name.' '.$this->owner->first_name.' ,')
            ->line('We apologize, your request was not accepted and this is related to the verification file .')
            ->line('You can try again please .')
            ->action('register', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
