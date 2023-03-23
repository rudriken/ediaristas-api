<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Hateoas\Oportunidade as HateoasOportunidade;

class Oportunidade extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"                    => $this->id,

            "nome_servico"          => $this->servico->nome,

            "cliente"               => [
                "nome_completo"         => $this->cliente->nome_completo,
                "reputacao"             => $this->cliente->reputacao,
                "foto_usuario"          => foto_perfil($this->cliente->foto_usuario),
            ],

            "data_atendimento"      => Carbon::parse($this->data_atendimento)
                ->toIso8601ZuluString(),
            "tempo_atendimento"     => $this->tempo_atendimento,
            "valor_diarista"        => $this->preco - $this->valor_comissao,
            "preco"                 => $this->preco - $this->valor_comissao,

            "logradouro"            => $this->logradouro,
            "numero"                => $this->numero,
            "complemento"           => $this->complemento,
            "bairro"                => $this->bairro,
            "cidade"                => $this->cidade,
            "estado"                => $this->estado,

            "quantidade_quartos"    => $this->quantidade_quartos,
            "quantidade_salas"      => $this->quantidade_salas,
            "quantidade_cozinhas"   => $this->quantidade_cozinhas,
            "quantidade_banheiros"  => $this->quantidade_banheiros,
            "quantidade_quintais"   => $this->quantidade_quintais,
            "quantidade_outros"     => $this->quantidade_outros,

            "avaliacoes_cliente"    => new AvaliacaoCollection(
                $this->cliente->avaliado->take(2)
            ),

            "links"                 => (new HateoasOportunidade)->links($this->resource),
        ];
    }
}
