<?php

namespace App\Http\Controllers\Diaria;

use App\Http\Resources\Diaria;
use App\Actions\Diaria\CriarDiaria;
use App\Http\Controllers\Controller;
use App\Http\Requests\DiariaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Diaria as ModelDiaria;
use App\Http\Resources\DiariaCollection;

class CadastroController extends Controller
{

    /**
     * Lista as diárias do usuário logado
     *
     * @return DiariaCollection
     */
    public function index(): DiariaCollection
    {
        $usuario = Auth::user();
        $diarias = ModelDiaria::todasDoUsuario($usuario);
        return new DiariaCollection($diarias);
    }

    /**
     * Grava uma nova diária no banco de dados
     *
     * @param  DiariaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiariaRequest $request, CriarDiaria $criarDiaria)
    {
        $diaria = $criarDiaria->executar($request->all());
        return response(new Diaria($diaria), 201);
    }

    /**
     * Mostra uma diária por ID
     *
     * @param ModelDiaria $diaria
     * @return Diaria
     */
    public function show(ModelDiaria $diaria): Diaria
    {
        Gate::authorize("dono-diaria", $diaria);
        return new Diaria($diaria);
    }
}
