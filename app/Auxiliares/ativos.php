<?php

if (!function_exists("foto_perfil")) {

    /**
     * Cria o caminho para a foto do perfil do usuário
     *
     * @param string|null $caminhoRelativo
     * @return string|null
     */
    function foto_perfil(?string $caminhoRelativo): ?string
    {
        return $caminhoRelativo ?
            sprintf("%s/%s", config("app.url"), $caminhoRelativo) :
            $caminhoRelativo;
    }
}
