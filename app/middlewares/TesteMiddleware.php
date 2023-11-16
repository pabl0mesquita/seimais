<?php

namespace app\middlewares;

use app\interfaces\MiddlewareInterface;

class TesteMiddleware implements MiddlewareInterface
{
    public function execute()
    {
        var_dump("execute teste middleware");
    }
}