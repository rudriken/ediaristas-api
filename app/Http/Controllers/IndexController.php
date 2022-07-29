<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $links = [
			[
				"type" => "GET",
				"rel" => "diaristas_cidade",
				"uri" => route("diaristas.busca_por_cep")
			],
			[
				"type" => "GET",
				"rel" => "verificar_disponibilidade_atendimento",
				"uri" => route("endereços.disponibilidade")
			],
			[
				"type" => "GET",
				"rel" => "endereco_cep",
				"uri" => route("endereços.cep")
			],
			[
				"type" => "GET",
				"rel" => "listar_servicos",
				"uri" => route("serviços.index")
			],
		];

		return response()->json([
			"links" => $links,
		]);
    }
}
