<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeleteFactory extends Notification implements  ShouldQueue
{
    use Queueable;
    private $messageInfo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message_info)
    {
        $this->messageInfo=$message_info;
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
            ->subject("Factory Under Deleting")
            ->line("{$this->messageInfo['owner']} your factory {$this->messageInfo['factory_name']} under deleting . It will be deleted after a week during this period. You can contact us if you have decided to return to deleting your factory .")
            ->line("Notice ! All categories and products that belong to it will be deleted .")
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
