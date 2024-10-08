<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DueInvoiceNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
	protected $message_en , $message_ar ,$type,$tapType , $dataArray ; 
	/**
	 * * tapType => هي عباره عن الرو دا هيتحط في انهي تابه ؟ هل تابه ال كاستمرز ولا ولا
	 */
    public function __construct($messageEn , $messageAr,$type,$tapType,array $dataArray)
    {
   
		$this->message_en = $messageEn;
		$this->message_ar = $messageAr;
		$this->type = $type;
		$this->tapType = $tapType;
		$this->dataArray = $dataArray ;
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
			'type'=>$this->type,
			'message_en'=>$this->message_en,
			'message_ar'=>$this->message_ar,
			'tap_type'=>$this->tapType,
			'data_array'=>$this->dataArray
        ];
    }
}
