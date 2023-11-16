<?php

namespace app\library;

class Response
{
    public function __construct(
        private mixed $body,
        private int $statusCode,
        private array $headers = []
    ){

    }

    public function send()
    {
        http_response_code($this->statusCode);

        if(!empty($this->headers)){
            
        }
    }
}