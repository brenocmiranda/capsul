<?php

namespace App\Notifications;

use App\Pedidos;
use App\PedidosStatus;
use App\Status;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NovoPedidoCliente extends Notification
{
    use Queueable;
    private $pedido;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PedidosStatus $aStatus)
    {
        $this->status = $aStatus;
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
                    ->subject('Atualização do pedido: #'.$this->status->RelationPedido1->codigo)
                    ->greeting('Olá, '.ucwords(strtolower(explode(" ", $this->status->RelationPedido1->RelationCliente->nome)[0])).'!')
                    ->line('Temos uma ótima notícia para você, seu pedido teve o status alterado para: '.$this->status->RelationStatus1->nome)
                    ->action('Acompanhe seu pedido', route('checkout.acompanhamento.pedido', $this->status->RelationPedido1->codigo))
                    ->line($this->status->RelationStatus1->descricao);
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
