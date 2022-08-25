<?php

namespace App\Actions\Diaria;

use App\Models\Diaria;
use Illuminate\Support\Facades\Auth;

class CriarDiaria
{
    public function executar(array $dados)
    {
        $dados["status"] = 1;
        $dados["servico_id"] = $dados["servico"];
        $dados["valor_comissao"] = 1.00;
        $dados["cliente_id"] = Auth::user()->id;
        unset($dados["servico"]);
        return Diaria::create($dados);
    }
}
