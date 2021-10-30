<?php

namespace App\Http;

class Request
{

    /**
     * Instancia do Router
     *
     * @var Router
     */
    private $router;
    /**
     * Método HTTP da requisição
     *
     * @var array
     */
    private $httpMethods;

    /**
     * URI da página
     *
     * @var string
     */
    private $uri;

    /**
     * Parametros da URL ($_GET)
     *
     * @var array
     */
    private $queryParams = [];

    /**
     * Parametros da POST da página ($_POST)
     *
     * @var array
     */

    private $postParams = [];

    /**
     * Cabeçalho da requisação
     *
     * @var array
     */
    private $headers = [];

    public function __construct($router)
    {
        $this->router     = $router;
        $this->queryParams = $_GET ?? '';
        $this->postParams  = $_POST ?? '';
        $this->headers     = getallheaders();
        $this->httpMethods = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
    }

    /**
     * Método responsável por definir a URI
     */
    private function setUri()
    {
        // URI COMPLETA (COM GET)
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        // REMOVE GETS DA URI
        $xUri = explode('?', $this->uri);
        $this->uri = $xUri[0];
    }

    /**
     * Get cabeçalho da requisação
     *
     * @return  array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get the value of postParams
     */
    public function getPostVars()
    {
        return $this->postParams;
    }

    /**
     * Get parametros da URL ($_GET)
     *
     * @return  array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Get método HTTP da requisição
     *
     * @return  array
     */
    public function getHttpMethods()
    {
        return $this->httpMethods;
    }

    /**
     * Get uRI da página
     *
     * @return  string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Get instancia do Router
     *
     * @return  Router
     */
    public function getRouter()
    {
        return $this->router;
    }
}
