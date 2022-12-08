<?php

namespace App\Actions\Pagamento;

use App\Models\Diaria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ObterPagamentosDiarista
{
    public function executar()
    {
        Gate::authorize("tipo-diarista");
        $diarista = Auth::user();
        return Diaria::where("diarista_id", $diarista->id)
            ->whereIn("status", [4, 6, 7])
            ->get();
    }
}
