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
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PodcastWasPurchased;

class CarrinhoAbandonado extends Notification 
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
     * Execute the job.
     *
     * @param  AudioProcessor  $processor
     * @return void
     */
    public function handle()
    {
        if($this->pedido->RelationStatus->last()->posicao != 4){
            $this->delete();
        }
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
        Pedidos::find($this->pedido->id)->update(['carrinho_abandonado' => $this]);
        return (new MailMessage)
            ->from($this->emails->email_remetente, $this->emails->nome_remetente)
            ->subject('Ops! Você esqueceu desses itens')
            ->view('system.emails.carrinho', ['geral' => $this->geral, 'pedido' => $this->pedido, 'emails' => $this->emails]);
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
