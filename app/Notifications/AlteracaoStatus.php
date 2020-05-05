<?php

namespace App\Notifications;

use App\PedidosStatus;
use App\ConfigEmails;
use App\Pedidos;
use App\Clientes;
use App\Status;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlteracaoStatus extends Notification implements ShouldQueue
{
    use Queueable;
    private $status;
    private $emails;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PedidosStatus $statusNovo)
    {
        $this->status = $statusNovo;
        $this->emails = ConfigEmails::first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
                    ->from($this->emails->email_remetente, $this->emails->nome_remetente)
                    ->subject('Obaa! Novidades do seu pedido '.$this->status->RelationPedido1->codigo)
                    ->greeting('Olá, '.ucwords(strtolower(explode(" ", $this->status->RelationPedido1->RelationCliente->nome)[0])).'!')
                    ->line('Temos uma ótima notícia para você, seu pedido teve nova atualização, encontra-se em '.$this->status->RelationStatus1->nome)
                    ->action('Acompanhe meu pedido', route('checkout.acompanhamento.pedido', $this->status->RelationPedido1->codigo))
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
            'pedido' => $this->status->id_pedido,
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
            'pedido' => $this->status->id_pedido,
        ];
    }
}
