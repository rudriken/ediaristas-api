<?php

namespace App\Observers;

use App\Models\User;

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
}
