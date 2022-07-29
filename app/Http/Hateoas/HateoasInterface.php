<?php

namespace App\Http\Hateoas;

interface HateoasInterface {
	public function links(): array;
}