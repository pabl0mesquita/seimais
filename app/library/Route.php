<?php

namespace app\library;

use app\library\RouteOptions;
use app\library\Request;
use app\library\RouteWildcard;

/**
 * Class Route
 */
class Route
{
  /** @var null|RouteOptions */
  private ?RouteOptions $routeOptions = null;
  
  public ?Request $routeRequest = null;

  private ?RouteWildcard $routeWildcard = null;

  /**
   * construct
   * @param string $uri
   * @param string $request
   * @param string $controller
   */
  public function __construct(
    public string $uri,
    public string $request,
    public string $controller,
    public array $wildcardAliases

  ) {
    $this->routeRequest = new Request;
  }

  /**
   * addRouteGroupOptions
   */
  public function addRouteGroupOptions(RouteOptions $routeOptions)
  {
    $this->routeOptions = $routeOptions;
  }

  /**
   * addRouteWildcard
   */
  public function addRouteWildcard(RouteWildcard $routeWildcard)
  {
    $this->routeWildcard = $routeWildcard;
  }

  /**
   * getRouteWildcardInstance
   */
  public function getRouteWildcardInstance(): ?RouteWildcard
  {
    return $this->routeWildcard;
  }

  /**
   * getRouteOptions
   * @return null|RouteOptions
   */
  public function getRouteOptions(): ?RouteOptions
  {
    return $this->routeOptions;
  }

  private function currentUri()
  {
      return $_SERVER['REQUEST_URI'] !== '/' ? rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') : '/';
  }

  private function currentRequest()
  {
      return strtolower($_SERVER['REQUEST_METHOD']);
  }

  public function getRouteOptionsInstance()
  {
    return $this->routeOptions;
  }
  public function match()
  {

    if($this->routeOptions->optionExist('prefix')){
        $this->uri = rtrim("/{$this->routeOptions->execute('prefix')}{$this->uri}", '/');
        //var_dump($this->uri);
    }

    $this->routeWildcard->replaceWildcardPattern($this->uri);
    $wildcardReplaced = $this->routeWildcard->getWildcardReplaced();

    if($wildcardReplaced !== $this->uri &&       $this->routeWildcard->uriEqualToPattern($this->routeRequest->currentUri, $wildcardReplaced)){
      $this->uri = $this->routeRequest->currentUri;
      $this->routeWildcard->paramsToArray($this->routeRequest->currentUri, $wildcardReplaced, $this->wildcardAliases);
    }


    //$this->currentUri()
    if ($this->uri === $this->routeRequest->currentUri &&
      ($this->request) === $this->routeRequest->method//$this->currentRequest()
    ) {
      return $this;
    }
  }
}
