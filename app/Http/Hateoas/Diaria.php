<?php

namespace App\Http\Hateoas;

use Illuminate\Database\Eloquent\Model;

class Diaria extends HateoasBase implements HateoasInterface
{
    /**
     * Retorna os links do HATEOAS para a diária
     *
     * @param Model|null $diaria
     * @return array
     */
    public function links(?Model $diaria): array
    {
        $this->adicionaLink("GET", "self", "diarias.show", ["diaria" => $diaria->id]);
        $this->linkPagar($diaria);
        return $this->links;
    }

    /**
     * Adiciona o link de pagamento na diária
     *
     * @param Model $diaria
     * @return void
     */
    private function linkPagar(Model $diaria): void
    {
        if ($diaria->status == 1) {
            $this->adicionaLink(
                "POST",
                "pagar_diaria",
                "diarias.pagar",
                ["diaria" => $diaria->id]
            );
        }
    }
}
