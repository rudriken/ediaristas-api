<?php

namespace App\Actions\Pagamento;

use App\Models\Diaria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;

class ObterPagamentosDiarista
{

    /**
     * Retorna a lista de diárias como pagamento do(a) diarista
     *
     * @return Collection
     */
    public function executar(): Collection
    {
        Gate::authorize("tipo-diarista");
        $diarista = Auth::user();
        return Diaria::pagamentosDiarista($diarista);
    }
}
