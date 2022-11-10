<?php

namespace App\Tarefas\Usuario;

use App\Models\User;

class CalculaReputacao
{

    /**
     * Calcula a reputação do(a) usuário e salva na tabela "users"
     *
     * @param integer $usuarioAvaliadoId
     * @return void
     */
    public function executar(int $usuarioAvaliadoId): void
    {
        $usuarioAvaliado = User::find($usuarioAvaliadoId);
        $novaReputacaoDoUsuario = $usuarioAvaliado->avaliado()->avg("nota");
        $usuarioAvaliado->reputacao = $novaReputacaoDoUsuario;
        $usuarioAvaliado->save();
    }
}
