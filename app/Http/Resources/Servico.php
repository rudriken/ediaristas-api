<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Servico extends JsonResource {
	/**
	 * Define como cada serviço será retornado
	 *
	 * @param [type] $request
	 * @return array
	 */
    public function toArray($request) {
        return [
            'id' 					=> $this->id,
            'nome' 					=> $this->nome,
            'valor_minimo' 			=> $this->valor_minimo,
            'qtd_horas' 			=> $this->qtd_horas,
            'porcentagem_comissao' 	=> $this->porcentagem_comissao,
            'valor_quarto' 			=> $this->valor_quarto,
            'horas_quarto' 			=> $this->horas_quarto,
            'valor_sala' 			=> $this->valor_sala,
            'horas_sala' 			=> $this->horas_sala,
            'valor_banheiro' 		=> $this->valor_banheiro,
            'horas_banheiro' 		=> $this->horas_banheiro,
            'valor_cozinha' 		=> $this->valor_cozinha,
            'horas_cozinha' 		=> $this->horas_cozinha,
            'valor_quintal' 		=> $this->valor_quintal,
            'horas_quintal' 		=> $this->horas_quintal,
            'valor_outros' 			=> $this->valor_outros,
            'horas_outros' 			=> $this->horas_outros,
            'icone' 				=> $this->icone,
            'posicao' 				=> $this->posicao,
        ];
    }
}
