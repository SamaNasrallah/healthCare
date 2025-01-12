<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PatientPaymentNotification extends Notification
{
    use Queueable;
    protected $invoice;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */

    public function toDatabase($notifiable)
    {
        return [
            'invoice_id' => $this->invoice->id,
            'message' => 'Your invoice (ID: ' . $this->invoice->id . ') has been marked as paid.',
            'amount' => $this->invoice->amount,
            'status' => 'Paid',
        ];
    }
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
