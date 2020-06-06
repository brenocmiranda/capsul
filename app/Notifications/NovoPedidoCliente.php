<?php

namespace App\Notifications;

use App\Pedidos;
use App\ConfigEmails;
use App\ConfigGeral;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NovoPedidoCliente extends Notification implements ShouldQueue
{
    use Queueable;
    private $pedido;
    private $emails;
    private $geral;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Pedidos $pedidoNovo)
    {   
        $this->pedido = $pedidoNovo;
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
            ->subject('A gente recebeu o seu pedido :)')
            ->view('system.emails.pedido', ['geral' => $this->geral, 'pedido' => $this->pedido, 'emails' => $this->emails]);    
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
            'pedido' => $this,
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
            'pedido' => $this,
        ];
    }
}
