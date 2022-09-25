<?php

namespace App\Actions\Diaria;

use App\Models\Diaria;
use App\Models\Servico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Servicos\ConsultaCidade\Provedores\Ibge;

class CriarDiaria
{

    private Ibge $consultaCidade;

    public function __construct(Ibge $servico)
    {
        $this->consultaCidade = $servico;
    }

    /**
     * Cria a diária no banco de dados
     *
     * @param array $dados
     * @return Diaria
     */
    public function executar(array $dados): Diaria
    {
        Gate::authorize("tipo-cliente");
        $this->consultaCidade->códigoIBGE($dados["codigo_ibge"]);
        $dados["status"] = 1;
        $dados["servico_id"] = $dados["servico"];
        $dados["valor_comissao"] = $this->calcularComissao($dados);
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
    private function calcularComissao(array $dados): float {
        $servico = Servico::find($dados["servico_id"]);
        $porcentagem = $servico->porcentagem_comissao / 100;
        return $dados["preco"] * $porcentagem;
    }
}
