<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RestoreFactory extends Notification implements ShouldQueue
{
    use Queueable;

    private $factory;
    private $name;
    private $factory_name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($factory)
    {
        $this->factory=$factory;
        $this->name=$this->factory->owner->profile->first_name.' '.$this->factory->owner->profile->last_name;
        $this->factory_name=$factory->factory_name;
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
     * Determine which queues should be used for each notification channel.
     *
     * @return array
     */
    public function viaQueues()
    {
        return [
            'mail' => 'mail-queue',
            'slack' => 'slack-queue',
        ];
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
            ->subject('Restore Factory')
            ->line('Hello '. $this->name .' ,')
            ->line('Your factory ' . $this->factory_name . '
                 Your factory has been restored, thank you for trusting our platform and we are happy to stay with us .')
            ->action('your factory', url('/'))
            ->line('Thank you for using our application!')
            ->line('Welcome to TallyBills');
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
