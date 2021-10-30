<?php

namespace App\Http;

class Response
{
    /**
     * Código de status HTTP
     *
     * @var integer
     */
    private $httpCode = 200;

    /**
     * Cabeçalho do response
     *
     * @var array
     */
    private $headers = [];

    /**
     * Tipo de conteudo que está sendo retornavel
     *
     * @var string
     */
    private $contentType = "text/html";

    /**
     * Conteudo do response
     *
     * @var mixed
     */
    private $content;

    /**
     * Método responsável por criar a classe e definir os valores
     *
     * @param integer $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * Set tipo de conteudo que está sendo retornavel
     *
     * @param  string  $contentType  Tipo de conteudo que está sendo retornavel
     *
     * @return  self
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Método responsável por adicionar um registro no cabeçalho do response
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Método responsável por enviar todos os headers para o navegador
     */
    private function sendHeaders()
    {
        // STATUS
        http_response_code($this->httpCode);

        // ENVIAR HEADERS
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /**
     * Método responsável por enviar a resposta para o usuário
     */
    public function sendResponse()
    {
        // ENVIA OS HEADERS
        $this->sendHeaders();

        // IMPRIME O CONTEUDO DA PÁGINA
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }
}
