<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CSAFormNominated extends Notification
{
    use Queueable;

    private $academic_year;
    private $partner;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($academic_year, $partner)
    {
        $this->academic_year = $academic_year;
        $this->partner = $partner;
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
            ->subject('Congrats! You have been nominated to a partner university')
            ->markdown('mail.csa_form.nominated', [
                'user_name' => $notifiable->name,
                'partner_name' => $this->partner->name,
                'partner_location' => $this->partner->location,
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
