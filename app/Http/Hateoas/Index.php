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
    public function links(?Model $inutil = null): array
    {
        $this->adicionaLink("GET", "diaristas_cidade", "diaristas.busca_por_cep");
        $this->adicionaLink(
            "GET", "verificar_disponibilidade_atendimento", "enderecos.disponibilidade"
        );
        $this->adicionaLink("GET", "endereco_cep", "enderecos.cep");
        $this->adicionaLink("GET", "listar_servicos", "servicos.index");
        $this->adicionaLink("POST", "cadastrar_usuario", "usuarios.create");
        $this->adicionaLink("POST", "login", "autenticacao.login");
        $this->adicionaLink("GET", "usuario_logado", "usuarios.show");
        $this->adicionaLink(
            "POST",
            "solicitar_alteracao_senha",
            "usuarios.solicitar_alteracao_senha"
        );
        $this->adicionaLink("POST", "confirmar_alteracao_senha", "usuarios.alterar_senha");

        return $this->links;
    }
}
