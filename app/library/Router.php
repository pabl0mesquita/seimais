<?php

namespace app\library;

use Closure;
use app\library\RouteWildcard;

class Router
{
  private array $routes = [];

  private array $routeOptions = [];

  private Route $route;

  public function add(
    string $uri,
    string $request,
    string $controller,
    ?array $wildcardAliases = []
  ) {
    $this->route = new Route($uri, $request, $controller, $wildcardAliases);
    $this->route->addRouteWildcard(new RouteWildcard);
    $this->route->addRouteGroupOptions(new RouteOptions($this->routeOptions));
    $this->routes[] = $this->route;

    return $this;
  }

  /**
   * middlewares
   * @param array $middlewares
   */
  public function middleware(array $middlewares)
  {
    $options = !empty($this->routeOptions) ?
      $optionsMiddleware = array_merge($this->routeOptions, ["middlewares" => $middlewares])
    : ["middlewares" => $middlewares];

    $this->route->addRouteGroupOptions(new RouteOptions($options));
  }

  /**
   * group
   * @param array $routeOptions
   * @param Closure $callback
   */
  public function group(array $routeOptions, Closure $callback)
  {
    $this->routeOptions = $routeOptions;
    $callback->call($this);
    $this->routeOptions = [];
  }

  /**
   * options
   * @param array $options
   * @return void
   */
  public function options(array $options): void
  {
    if(!empty($this->routeOptions)){
      $options = array_merge($this->routeOptions, $options);
    }

    $this->route->addRouteGroupOptions(new RouteOptions($options));
  }

  public function init()
  {

    //var_dump($this->routes);

    foreach ($this->routes as $route) {
      if ($route->match()) {
        Redirect::register($route);
        return (new Controller)->call($route);
      }
    }

    //deixar dinâmico
    Redirect::to("/404");
    //return (new Controller)->call(new Route('/404', 'GET', 'NotFoundController:index'));

  }
}
