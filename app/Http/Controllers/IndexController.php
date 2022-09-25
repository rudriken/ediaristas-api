<?php

namespace App\Http\Controllers;

use App\Http\Hateoas\Index;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller {
	private Index $indexHateoas;

	public function __construct(Index $parametro) {
		$this->indexHateoas = $parametro;
	}

    public function __invoke(): JsonResponse {
		$links = $this->indexHateoas->links();
		return response()->json(["links" => $links]);
    }
}
