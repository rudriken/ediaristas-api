<?php

namespace App\Console\Commands;

use App\Actions\Diaria\Cancelamento\CancelarAutomaticamente;
use Illuminate\Console\Command;

class CancelarDiariasSemDiarista extends Command
{
	public function __construct(private CancelarAutomaticamente $cancelarAutomaticamente)
	{
		parent::__construct();
	}

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'diarias:cancelar:sem-diarista';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Cancela as diárias com menos de 24 horas para a data de atendimento e que não possuem diarista definido(a)';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		$this->cancelarAutomaticamente->executar();
		return 0;
	}
}
