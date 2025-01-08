<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification
{
    use Queueable;

    public $message;
    public $link;
    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->message = $data['message'];  // Set message
        $this->link = $data['link'];        // Set link
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                ->subject('New Notification')
                ->line($this->message)
                ->action('View Notification', url($this->link));
    }
    /**
     * Get the array representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->data['message'],
            'link' => $this->data['link'],
            'user_reg_no' => $notifiable->reg_no,  // Get reg_no from the notifiable user
            'created_at' => now()->toISOString()
        ];
    }

    

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'link' => $this->link,
            'user_reg_no' => $notifiable->reg_no,
            'created_at' => now()
        ];
    }
}
