<?php

namespace app\enums;

use app\middlewares\AuthMiddleware;
use app\middlewares\TesteMiddleware;

enum RouteMiddlewares: string
{
    case auth = AuthMiddleware::class;
    case teste = TesteMiddleware::class;
}