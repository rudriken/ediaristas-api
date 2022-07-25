<?php
$cidade1 = App\Models\Cidade::find(2);
$cidade1->diaristas->where("tipo_usuario", " = ", 2);
