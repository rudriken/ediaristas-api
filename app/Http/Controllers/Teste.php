<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TeamPickr\DistanceMatrix\Frameworks\Laravel\DistanceMatrix;
use TeamPickr\DistanceMatrix\Licenses\StandardLicense;

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
		$licenca = new StandardLicense("AIzaSyArcCoU0kjYBQ8hNXc3qTJBGOqJXkeTsmQ");

		$resposta = DistanceMatrix::license($licenca)
			->addOrigin('38402075')
			->addDestination('38402028')
			->request();
        
		dd($resposta);
	}
}
