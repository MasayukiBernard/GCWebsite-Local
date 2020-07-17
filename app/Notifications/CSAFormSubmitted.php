<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CSAFormSubmitted extends Notification
{
    use Queueable;

    private $academic_year;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($academic_year)
    {
        $this->academic_year = $academic_year;
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
            ->subject('CSA Form Has Been Submitted')
            ->markdown('mail.csa_form.submitted', [
                'user_name' => $notifiable->name,
                'academic_year' => $this->academic_year
            ]);
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
