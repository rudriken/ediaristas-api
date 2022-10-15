<?php

namespace App\Http\Hateoas;

use Illuminate\Database\Eloquent\Model;

class Usuario extends HateoasBase implements HateoasInterface
{

    /**
     * Retorna os links do HATEOAS para o usuário
     *
     * @param Model|null $usuario
     * @return array
     */
    public function links(?Model $usuario): array
    {
        $this->adicionaLink("GET", "lista_diarias", "diarias.index");
        $this->linksDoCliente($usuario);
        $this->linksDoDiarista($usuario);
        return $this->links;
    }

    /**
     * Adiciona os links específicos do usuário do tipo 'cliente'
     *
     * @param Model $usuario
     * @return void
     */
    private function linksDoCliente(Model $usuario): void
    {
        if ($usuario->tipo_usuario === 1) {
            $this->adicionaLink("POST", "cadastrar_diaria", "diarias.store");
        }
    }

    /**
     * Adiciona os links específicos do usuário do tipo 'diarista'
     *
     * @param Model $usuario
     * @return void
     */
    private function linksDoDiarista(Model $usuario): void
    {
        if ($usuario->tipo_usuario === 2) {
            $this->adicionaLink("PUT", "cadastrar_endereco", "usuarios.definir-endereco");
            $this->adicionaLink("PUT", "relacionar_cidades", "usuarios.definir-cidades");
        }
    }
}
