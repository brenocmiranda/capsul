<?php

namespace App\Notifications;

use App\Usuarios;
use App\ConfigEmails;
use App\ConfigGeral;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecuperacaoSenha extends Notification implements ShouldQueue
{
    use Queueable;
    private $usuario;
    private $emails;
    private $geral;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Usuarios $usuarioNovo)
    {
        $this->usuario = $usuarioNovo;
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
        return ['mail', 'database'];
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
                ->subject('Redefinição de senha')
                ->view('system.emails.recuperacao', ['geral' => $this->geral, 'usuario' => $this->usuario]);
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
            'usuario' => $this->usuario,
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
            'usuario' => $this->usuario,
        ];
    }
}
