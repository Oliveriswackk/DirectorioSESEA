<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\UploadedFile;

class InformacionDirectorioRecibida extends Mailable
{
    use Queueable, SerializesModels;

    public UploadedFile $archivo;
    public string $usuario;
    public string $fecha;

    public function __construct(
        UploadedFile $archivo,
        string $usuario,
        string $fecha
    ) {
        $this->archivo = $archivo;
        $this->usuario = $usuario;
        $this->fecha = $fecha;
    }

    public function build()
    {
        return $this
            ->to(config('mail.admin_email_notifications'))
            ->subject('Nueva información para el Directorio')
            ->view('emails.informacion-directorio')
            ->attach(
                $this->archivo->getRealPath(),
                [
                    'as' => $this->archivo->getClientOriginalName(),
                    'mime' => $this->archivo->getMimeType(),
                ]
            );
    }
}