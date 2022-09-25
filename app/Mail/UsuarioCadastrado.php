<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UsuarioCadastrado extends Mailable
{
    use Queueable, SerializesModels;

    private User $novoUsuario;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $observador)
    {
        $this->novoUsuario = $observador;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return (
            $this
                ->subject("Bem Vindo(a) ao E-diaristas")
                ->from("nao-responda@e-diaristas.com.br", "E-diaristas")
                ->view('email.mensagens.cadastro', [
                    "usuario" => $this->novoUsuario,
                ])
        );
    }
}
