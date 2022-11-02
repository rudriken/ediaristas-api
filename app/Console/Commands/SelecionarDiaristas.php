<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SelecionarDiaristas extends Command
{
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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dd("estou no comando personalizado");
        return 0;
    }
}
