<?php

namespace App\Actions\Diaria\EscolheDiarista;

use App\Models\Diaria;
use Carbon\Carbon;

class SelecionaAutomaticamente
{
    public function executar()
    {
        $diarias = Diaria::where("status", 2)
            ->where("created_at", "<", Carbon::now()->subHours(24))
            ->get();
        foreach ($diarias as $diaria) {
            var_dump($diaria);
        }
    }
}
