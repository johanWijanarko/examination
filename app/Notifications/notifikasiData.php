<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class notifikasiData extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($affected)
    {
        $this->affected=$affected;
        $this->transaksi = DB::table('trs_forminspect')->where('id_trfinspect ', $affected->id_transaksi_asembling)->first();
        $this->project = DB::table('auditee_pic')->select('pic_id','pic_auditee_id')->where('n
        ama_project', $this->transaksi->id_transaksi_asembling)->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail'];
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
                    // ->line($this->affected['body'])
                    // ->action($this->affected['affectedText'],
                    // $this->affected['url'])
                    // ->line($this->affected['DataReject']);
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
            'keterangan' => $this->affected->keterangan_reject,
           
        ];
    }
}
