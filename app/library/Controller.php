<?php

namespace app\library;

use Exception;
use app\library\Middleware;
use PhpOption\None;

class Controller
{
  // private const NAMESPACE = 'app\\controllers\';

  /**
   * controllerPath
   */
  private function controllerPath(Route $route, string $controller)
  {
    return ($route->getRouteOptionsInstance()->optionExist('controller')) ? "app\\controllers\\" . $route->getRouteOptionsInstance()->execute('controller') . '\\' . $controller : "app\\controllers\\" . $controller;
  }

  /**
   * call
   * @param Route $route
   * @return void
   */
  public function call(Route $route): void
  {
    $controller = $route->controller;

    if (!str_contains($controller, ':')) {
      throw new Exception("Colon need to controller {$controller} in route");
    }

    [$controller, $action] = explode(':', $controller);

    $controllerInstance = $this->controllerPath($route, $controller);

    if (!class_exists($controllerInstance)) {
      throw new Exception("Controller {$controller} does not exist");
    }

    $controller = new $controllerInstance;

    if (!method_exists($controller, $action)) {
      throw new Exception("Action {$action} does not exist");
    }

    $params = $route->getRouteWildcardInstance()->getParams();

    $route->routeRequest->setParams($params);
    

    //middlewares
    //var_dump($route->getRouteOptionsInstance());
    if($route->getRouteOptionsInstance()?->optionExist('middlewares')){
      (new Middleware($route->getRouteOptionsInstance()->execute('middlewares')))->execute();
    }

    //execute controller
    call_user_func_array([$controller, $action], [$route->routeRequest]);

  }
}
