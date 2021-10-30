<?php

namespace App\Http\Middleware;

use App\Http\Response;
use Exception;
use Closure;

class Queue
{
    /**
     * Mapeamento de middlewares
     *
     * @var array
     */
    private static $map = [];
    /**
     * Fila de middlewares a serem executados
     *
     * @var array
     */
    private $middlewares = [];

    /**
     * Função de execução do controlador
     *
     * @var Closure
     */
    private $controller;

    /**
     * Argumentos da função do controlador
     *
     * @var array
     */
    private $controllerArgs = [];

    /**
     * Método responsável por construir a classe de middlewares de fila
     *
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs)
    {
        $this->middlewares    = $middlewares;
        $this->controller     = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * Método responsável por definir mapear os middlewares
     *
     * @param array $map
     */
    public static function setMap($map)
    {
        self::$map = $map;
    }

    /**
     * Método responsável por executar o próximo nível da fila de middlewares
     *
     * @param Request $request
     * @return Response
     */
    public function next($request)
    {
        // VERIFICA SE A FILA ESTÁ VAZIA
        if (empty($this->middlewares)) {
            return call_user_func_array($this->controller, $this->controllerArgs);
        }

        $middleware = array_shift($this->middlewares);

        if (!isset(self::$map[$middleware])) {
            throw new Exception('Problemas ao passar middleware da requisição', 500);
        }
    }
}
