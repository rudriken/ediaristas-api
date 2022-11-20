<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PagarMe\Client;

class Teste extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $pagarme = new Client("ak_test_nE14ZiG433nQG0D3aR0XhpzCj4iPkR");
        $transacao = $pagarme->transactions()->create([
            "amount" => "2000",
            "card_hash" => "123123",
            "async" => false,
        ]);
        dd($transacao);
    }
}
