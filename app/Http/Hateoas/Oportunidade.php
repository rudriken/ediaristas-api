<?php

namespace App\Http\Hateoas;

use Illuminate\Database\Eloquent\Model;

class Oportunidade extends HateoasBase implements HateoasInterface
{

    /**
     * Retorna os links do HATEOAS para a rota inicial
     *
     * @return array
     */
    public function links(?Model $diaria = null): array
    {
        $this->adicionaLink("POST", "candidatar_diaria", "diarias.candidatar", [
            "diaria" => $diaria->id
        ]);
        return $this->links;
    }
}
