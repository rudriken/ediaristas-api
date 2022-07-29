<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ServicoCollection extends ResourceCollection {

	/**
	 * Define a coleção de serviços
	 *
	 * @param [type] $request
	 * @return array
	 */
    public function toArray($request) {
        return $this->collection;
    }
}
