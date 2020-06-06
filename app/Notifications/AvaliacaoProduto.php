<?php

namespace App\Notifications;

use App\PedidosStatus;
use App\ConfigEmails;
use App\ConfigGeral;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AvaliacaoProduto extends Notification implements ShouldQueue
{
    use Queueable;
    private $status;
    private $emails;
    private $geral;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PedidosStatus $statusNovo)
    {
        $this->status = $statusNovo;
        $this->emails = ConfigEmails::first();
        $this->geral = ConfigGeral::first();
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
                    ->from($this->emails->email, $this->emails->nome_remetente)
                    ->subject('Agora é com você!')
                    ->view('system.emails.avaliacao', ['geral' => $this->geral, 'status' => $this->status]);
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
            'pedido' => $this->status->RelationPedido1,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'pedido' => $this->status->RelationPedido1,
        ];
    }
}
