<?php

namespace App\Observers;

use App\Models\User;
use App\Mail\UsuarioCadastrado;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Define a reputação antes de criar o usuário
     *
     * @param User $novoUsuario
     * @return void
     */
    public function creating(User $novoUsuario): void
    {
        if (User::count() === 0) {
            $novoUsuario->reputacao = 5;
            return;
        }
        $novoUsuario->reputacao = round(User::avg("reputacao"));
    }

    /**
     * Envio do e-mail de boas-vindas para o novo usuário
     *
     * @param User $novoUsuario
     * @return void
     */
    public function created(User $novoUsuario): void
    {
        Mail::to($novoUsuario->email)->send(new UsuarioCadastrado($novoUsuario));
    }
}
