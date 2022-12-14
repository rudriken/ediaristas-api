<?php

namespace App\Actions\Diarista;

use App\Models\User;
use App\Models\Cidade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Servicos\ConsultaCidade\ConsultaCidadeInterface;

class DefinirCidadesAtendidas
{
    public function __construct(private ConsultaCidadeInterface $consultaCidade)
    {
    }

    /**
     * Define as cidades que o(a) diarista atende
     *
     * @param array $cidades
     * @return array
     */
    public function executar(array $cidades): array
    {
        Gate::authorize("tipo-diarista");
        $cidadesIDs = [];
        foreach ($cidades as $cidade) {
            $cidadeValida = $this->consultaCidade->codigoIBGE($cidade["codigo_ibge"]);
            $cidadeModel = Cidade::firstOrCreate(
                ["codigo_ibge" => $cidade["codigo_ibge"]],
                [
                    "cidade" => $cidadeValida->cidade,
                    "codigo_ibge" => $cidade["codigo_ibge"],
                    "estado" => $cidadeValida->estado
                ]
            );
            $cidadesIDs[] = $cidadeModel->id;
        }
        $usuario = Auth::user();

        /* as linhas de baixo foram um paliativo, para evitar erro de tipagem já que o tipo
         * do objeto $usuario é 'Authenticatable' e o tipo do objeto $diarista é 'User'.
         */
        $diarista = new User;
        $diarista["id"]                 = $usuario->id;
        $diarista["nome_completo"]      = $usuario->nome_completo;
        $diarista["cpf"]                = $usuario->cpf;
        $diarista["nascimento"]         = $usuario->nascimento;
        $diarista["foto_documento"]     = $usuario->foto_documento;
        $diarista["foto_usuario"]       = $usuario->foto_usuario;
        $diarista["telefone"]           = $usuario->telefone;
        $diarista["tipo_usuario"]       = $usuario->tipo_usuario;
        $diarista["chave_pix"]          = $usuario->chave_pix;
        $diarista["reputacao"]          = $usuario->reputacao;
        $diarista["email"]              = $usuario->email;
        $diarista["email_verified_at"]  = $usuario->email_verified_at;
        $diarista["password"]           = $usuario->password;
        $diarista["remember_token"]     = $usuario->remember_token;
        $diarista["created_at"]         = $usuario->created_at;
        $diarista["updated_at"]         = $usuario->updated_at;

        return $diarista->cidadesAtendidas()->sync($cidadesIDs);
    }
}
