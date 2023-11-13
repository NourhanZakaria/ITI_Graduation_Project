<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class AppointmentReminder extends Notification
{
    use Queueable;
    protected $appointment;
    //protected $sendAt;
   // protected $user_id;
   // protected $lawyer_id;

    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment)
    {
        //
        $this->appointment = $appointment;
        //$this->user_id = $user_id;
       // $this->lawyer_id = $lawyer_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Appointment Reminder')
        ->greeting("Hello {$this->appointment->user->name}")
        ->line('This is a reminder for your upcoming appointment.')
        ->line('Appointment Date: ' . $this->appointment->appointment_date)
        ->line('With Lawyer: ' . $this->appointment->lawyer_time->lawyer->user->name)
        ->line('Please make sure to attend the appointment on time.')
        ->action('Notification Action', url('/'))
        ->salutation('Thank you!');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            /*
            'message' => 'Hello! This is a reminder for your upcoming appointment. Please make sure to attend the appointment on time.',
            'sendAt' => $this->sendAt,
            'user_id' => $this->user_id,
            'lawyer_id' => $this->lawyer_id,
            */
            'subject' => ("Hello! {$this->appointment->user->name} This is a reminder for your upcoming appointment with the lawyer {$this->appointment->lawyer_time->lawyer->user->name} in date {$this->appointment->appointment_date}"),

        ];
    }
}
