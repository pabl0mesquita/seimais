<?php
namespace app\library;

class Request
{

    public string $uri;
    public array $headers;

    public string $method;

    public string $currentUri;

    public array $params = [];

    public function __construct()
    {
        $this->headers = getallheaders();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->currentUri = $_SERVER['REQUEST_URI'] !== '/' ? rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') : '/';
    }

    public function getUri()
    {

    }

    public function setParams(array $params)
    {
        $this->params =  $params;
    }

    public function setUri(){

    }
    private function currentUri()
    {
        return $_SERVER['REQUEST_URI'] !== '/' ? rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') : '/';
    }

    private function currentRequest()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}