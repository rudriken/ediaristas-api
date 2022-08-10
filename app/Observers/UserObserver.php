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
     * @param User $novoUsuário
     * @return void
     */
    public function creating(User $novoUsuário): void
    {
        if (User::count() === 0) {
            $novoUsuário->reputacao = 5;
            return;
        }
        $novoUsuário->reputacao = User::avg("reputacao");
    }

    /**
     * Envio do e-mail de boas-vindas para o novo usuário
     *
     * @param User $novoUsuário
     * @return void
     */
    public function created(User $novoUsuário): void
    {
        Mail::to($novoUsuário->email)->send(new UsuarioCadastrado($novoUsuário));
    }
}
