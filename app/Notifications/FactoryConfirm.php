<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FactoryConfirm extends Notification implements ShouldQueue
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
            ->subject('Confirmed Factory')
            ->line('Welcome '. $this->name .' ,')
            ->line('Your factory '.$this->factory_name.' data has been verified, and your factory has been successfully built on our platform,
             and now you can access it and start adding categories and products to display and sell.')
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
