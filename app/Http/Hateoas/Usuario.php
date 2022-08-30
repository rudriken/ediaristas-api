<?php

namespace App\Http\Hateoas;

use Illuminate\Database\Eloquent\Model;

class Usuario extends HateoasBase implements HateoasInterface
{
    public function links(?Model $usuário): array
    {
        if ($usuário->tipo_usuario === 1) {
            $this->adicionaLink("POST", "cadastrar diária", "diárias.store");
        }
        return $this->links;
    }
}
