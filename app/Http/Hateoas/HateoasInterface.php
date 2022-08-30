<?php

namespace App\Http\Hateoas;

use Illuminate\Database\Eloquent\Model;

interface HateoasInterface {
	public function links(?Model $recurso): array;
}
