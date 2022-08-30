<?php

namespace App\Http\Hateoas;

use Illuminate\Database\Eloquent\Model;

class Index extends HateoasBase implements HateoasInterface
{

    /**
     * Retorna os links do HATEOAS para a rota inicial
     *
     * @return array
     */
    public function links(?Model $inútil = null): array
    {
        $this->adicionaLink("GET", "diaristas_cidade", "diaristas.busca_por_cep");
        $this->adicionaLink(
            "GET", "verificar_disponibilidade_atendimento", "endereços.disponibilidade"
        );
        $this->adicionaLink("GET", "endereco_cep", "endereços.cep");
        $this->adicionaLink("GET", "listar_servicos", "serviços.index");
        $this->adicionaLink("POST", "cadastrar_usuario", "usuários.create");
        $this->adicionaLink("POST", "login", "autenticação.login");
        $this->adicionaLink("GET", "usuario_logado", "usuários.show");

        return $this->links;
    }
}
