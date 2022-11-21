<?php

namespace App\Http\Controllers;

use App\Servicos\Pagamento\PagamentoInterface;
use Illuminate\Http\Request;

class Teste extends Controller
{
    public function __construct(private PagamentoInterface $pagamentoServico)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $dadosPagamento = [
            "amount" => "5789",
            "card_hash" => "5718414_xa9091nhAdxhY2vxDJ6In/guiquY1jQgpxpSjqEdSDz03WXOYrG0xL+MOCG0u0t9RetqHK5um4rtYMsIwOfIBWi1ThOQXZfUh/D4YK1hC9XuUkf0AAsYoq3b0P8tKlKBmKVmJ6DXwVsVizbLPi5hPgBLnSbBbQ8kHzkHHcYKpKCVwHFnVg9CEofkJkt31LJRXE6f/UkYYHp229SF8KOZwQrY8DmFeNwTz5eAtOW9sn7NEnXOvrwAal4AcSTfdy9zejH11073qpgpVQp9MSG2bz9HA4cfoOAGF1kHom1xgJcnqo93tTIcOxUp5ze8VPIz+fcQ68dhf9RZoN/sD7D07Q==",
            "async" => false,
        ];
        $resposta = $this->pagamentoServico->pagar($dadosPagamento);
        dd($resposta);
    }
}
