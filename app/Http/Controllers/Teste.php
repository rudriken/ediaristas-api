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
            "card_hash" => "5718027_NUgfl4eYznXXW5rjcBIfxKaAmukMZh/rnZwi74SFectJF8ZjELupPbmtW4ZeO5r5yHv93cvTqNiCmrdYlzMFwmBKdsHttu1y6HJu5xkinSufxX+3I4Qw7guarBVlgCn5jPOOw5A5sbw3kYQorzXlfvEWqxteA5ARR8gJ3vRv+TpoqQXkZPMspWma0NdxIpPthbHYCfJtL5e2g4XaT9bVHhyRei5/lXhGM+P6M92jL1EGu0HEUtAbOtUF1orA4Cgh1cgqaYC4pQB24D6NSSPxtJROZ4HBBzQpmopJoql9CzAJx2sBAc0VoRKSUTAl+72dCxZaTh1qObLCVOxZeihy9A==",
            "async" => false,
        ]);
        dd($transacao);
    }
}
