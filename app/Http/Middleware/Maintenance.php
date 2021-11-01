<?php

namespace App\Http\Middleware;

use Exception;

class Maintenance
{
    /**
     * Método responsável por executar os middlewares
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        // VERIFICA O ESTADO DE MANUTENÇÃO DA PÁGINA
        if (getenv('MAINTENANCE') == 'true') {
            throw new Exception('Página em manutenção, tente novamente mais tarde', 200);
        }

        // EXECUTA O PRÓXIMO NÍVEL DO MIDDLEWARE
        return $next($request);
    }
}
