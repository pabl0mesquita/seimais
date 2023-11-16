<?php

namespace app\middlewares;

use app\interfaces\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function execute()
    {
        var_dump("execute auth middleware");
    }
}