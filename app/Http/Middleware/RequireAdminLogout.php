<?php

namespace App\Http\Middleware;

use App\Session\Admin\LoginSession;

class RequireAdminLogout
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
        // VERIFICA SE O USUÁRIO ESTÁ LOGADO
        if (LoginSession::isLogged()) {
            $request->getRouter()->redirect('/admin');
        }

        // CONTINUA A EXECUÇÃO
        return $next($request);
    }
}
