<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ForceDeleteFactory extends Notification implements ShouldQueue
{
    use Queueable;
    private $name;
    private $factory_name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($factory)
    {
        $this->name=$factory['name'];
        $this->factory_name=$factory['factory_name'];
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
            ->subject('Force Delete Factory')
            ->line('Welcome '. $this->name .' ,')
            ->line('We apologize, but your factory ' . $this->factory_name . ' has been deleted as per your request,
             and we hope that our services are not bad or did not meet your business needs.')
            ->line('Thank you for using our application!')
            ->action('your factories', url('http://localhost:4200/allFactories'))
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
