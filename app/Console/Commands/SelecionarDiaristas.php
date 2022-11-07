<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Actions\Diaria\EscolheDiarista\SelecionaAutomaticamente;

class SelecionarDiaristas extends Command
{
    public function __construct(
        private SelecionaAutomaticamente $selecionaAutomaticamente
    ) {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diarias:selecionar:diaristas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica as diárias com mais de 24 horas e seleciona o(a) diarista mais apropriado(a)';

    /**
     * Busca as diárias pagas com mais de 24 horas de criadas e
     * escolhe o(a) diarista mais apropriado(a) para ela
     *
     * @return int
     */
    public function handle()
    {
        $this->selecionaAutomaticamente->executar();
        return 0;
    }
}
