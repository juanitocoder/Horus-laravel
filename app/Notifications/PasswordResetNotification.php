<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetNotification extends Notification
{
    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetLink = url('/reset-password/' . $this->token . '?email=' . urlencode($this->email));

        return (new MailMessage)
            ->subject('Restablecer contraseña')
            ->line('Recibiste este correo porque solicitaste restablecer tu contraseña.')
            ->action('Restablecer Contraseña', $resetLink)
            ->line('Si no solicitaste este cambio, puedes ignorar este correo.');
    }
}

