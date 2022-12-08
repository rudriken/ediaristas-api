<?php

namespace App\Http\Controllers\Pagamento;

use App\Actions\Pagamento\ObterPagamentosDiarista;
use App\Http\Controllers\Controller;
use App\Http\Resources\PagamentoCollection;
use Illuminate\Http\Request;

class ObtemPagamentosDiarista extends Controller
{
    public function __construct(private ObterPagamentosDiarista $obterPagamentosDiarista)
    {
    }

    public function __invoke(Request $request)
    {
        $pagamentos = $this->obterPagamentosDiarista->executar();
        return new PagamentoCollection($pagamentos);
    }
}