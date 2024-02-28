<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PastDueInvoiceNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
	protected $invoice_number,$due_days ; 
    public function __construct($invoiceNumber , $dueDays)
    {
        $this->invoice_number = $invoiceNumber ; 
		$this->due_days = $dueDays ; 
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
			'message_en'=>__('Invoice Number ') . $this->invoice_number . ' '.__('Is Past Due Since ') . ' ' . $this->due_days . ' ' . 'days',
			'message_ar'=>__('Invoice Number ') . $this->invoice_number . ' '.__('Is Past Due Since ') . ' ' . $this->due_days . ' ' . 'days'
        ];
    }
}
