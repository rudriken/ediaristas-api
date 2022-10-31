<?php

namespace App\Servicos\ConsultaDistancia;

class EnderecoNaoEncontradoException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Endereço não encontrado no momento do cálculo", 1);
    }
}
