<?php

namespace App\Actions\Diaria;

use App\Models\Diaria;
use App\Models\Servico;
use Illuminate\Support\Facades\Auth;

class CriarDiaria
{

    /**
     * Cria a diária no banco de dados
     *
     * @param array $dados
     * @return object
     */
    public function executar(array $dados): object
    {
        $dados["status"] = 1;
        $dados["servico_id"] = $dados["servico"];
        $dados["valor_comissao"] = $this->calcularComissão($dados);
        $dados["cliente_id"] = Auth::user()->id;
        unset($dados["servico"]);
        return Diaria::create($dados);
    }

    /**
     * Calcula o valor da comissão para a plataforma E-diaristas
     *
     * @param array $dados
     * @return float
     */
    private function calcularComissão(array $dados): float {
        $serviço = Servico::find($dados["servico_id"]);
        $porcentagem = $serviço->porcentagem_comissao / 100;
        return $dados["preco"] * $porcentagem;
    }
}
