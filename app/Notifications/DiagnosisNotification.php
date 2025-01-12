<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DiagnosisNotification extends Notification
{
    use Queueable;
    protected $diagnosis;
    protected $prescription;
    protected $doctor;

    /**
     * Create a new notification instance.
     */
    public function __construct($diagnosis, $prescription,$doctor)
    {
        $this->diagnosis = $diagnosis;
        $this->prescription = $prescription;
        $this->doctor = $doctor;

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
    public function toArray(object $notifiable): array
    {

        return [
            'message' => 'You have received a new diagnosis and prescription from Dr. ' . $this->doctor->first_name . ' ' . $this->doctor->last_name . '.',
            'diagnosis' => $this->diagnosis,
            'prescription' => $this->prescription,
            'doctor_name' => $this->doctor->first_name . ' ' . $this->doctor->last_name,
        ];

    }
}
