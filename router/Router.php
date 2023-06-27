<?php

/** User: Dev Lee ... */

namespace app\router;

/**
 * Class Router
 * 
 * @author Ankain Lesly <leeleslyank@gmail.com>
 * @package app\router
 */
class Router
{
  // public static string $ROOT_DIR;
  protected array $routes = [];
  public Request $request;
  public Response $response;

  public function __construct($root_directory)
  {
    // self::$ROOT_DIR = $root_directory;
    $this->request = new Request($root_directory);
    $this->response = new Response($root_directory);
  }

  public function get($path, $callback)
  {
    //finding if there is any {?} parameter in $path
    preg_match_all("/(?<={).+?(?=})/", $path, $paramMatchesKeys);

    if (empty($paramMatchesKeys[0])) {
      return $this->routes['get'][$path] = $callback;
    }

    $response = $this->getQueryParams($path, $paramMatchesKeys[0]);

    if ($response) {
      $this->routes['get'][$response] = $callback;
      // $this->request->setBody($response['params']);
    }
  }

  public function post($path, $callback)
  {
    $this->routes['post'][$path] = $callback;
  }

  public function getQueryParams($path, $paramKey)
  {
    $uri = $this->request->path();
    $params = [];

    //exploding path and request uri string to array
    $path = explode("/", $path);
    $reqUri = explode("/", $uri);

    //will store index number where {?} parameter is required in the $path 
    $indexNum = [];

    //storing index number, where {?} parameter is required with the help of regex
    foreach ($path as $index => $param) {

      if (preg_match("/{.*}/", $param)) {
        $indexNum[] = $index;
        continue;
      }

      if ($path[$index] !== $reqUri[$index]) return implode('/', $path);
    }

    //running for each loop to set the exact index number with reg expression
    foreach ($indexNum as $key => $index) {
      if (empty($reqUri[$index])) {
        return;
      }
      //setting params with params names
      $params[$paramKey[$key]] = $reqUri[$index];
      $path[$index] = $reqUri[$index];
      // $reqUri[$index] = "{.*}";
    }

    $this->request->setParams($params);
    return implode("/", $path);
  }

  public function resolve()
  {
    $response = $this->response;
    $path = $this->request->path();
    $method = $this->request->method();
    $callback = $this->routes[$method][$path] ?? false;

    //Undefined Page Handler
    if ($callback === false) {
      $response->status(404);
      $message = "<b>Page Not Found..</b>";
      return $response->content($message);
      // return $response->render('_404');
    }

    //String Handler
    if (is_string($callback)) {

      if (str_contains($callback, '@')) {
        $callback = str_replace('@', '', $callback);
        return $response->render($callback);
      }
      exit;
      return $response->content($callback);
    }

    //Array Handler
    if (is_array($callback)) {
      $callback[0] = new $callback[0]();
      // Application::$app->setController($callback[0]);
    }

    if (is_callable($callback)) {
      return call_user_func($callback, $this->request, $response);
    }

    $message = "<b>Page Not Found..</b>";
    return $response->content($message);
  }
}
