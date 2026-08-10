<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class NuevaSolicitudAcceso extends Notification implements ShouldQueue
{
    use Queueable;

    public $solicitud;

    public function __construct(User $solicitud)
    {
        $this->solicitud = $solicitud;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        
        return (new MailMessage)
            ->subject('Nueva solicitud de acceso institucional - SESEA')
            ->greeting('Estimado Administrador de Sistemas,')
            ->line("Se ha recibido una nueva solicitud de registro en la plataforma por parte de: **{$this->solicitud->name}** ({$this->solicitud->email}).")
            ->line('Para autorizar su ingreso, seleccione el rol institucional que se le asignará:')
            ->action('Aprobar como Colaborador', URL::signedRoute('admin.aprobar.solicitud', ['user' => $this->solicitud->id, 'role' => 2])) // ID del rol Colaborador
            ->action('Aprobar como Invitado / Practicante', URL::signedRoute('admin.aprobar.solicitud', ['user' => $this->solicitud->id, 'role' => 3])) // ID del rol Invitado/Practicante
            ->line('Si no reconoce a esta persona o considera que no debe tener acceso, simplemente ignore este mensaje y la cuenta permanecerá bloqueada.');
    }
}