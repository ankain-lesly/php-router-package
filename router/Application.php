<?php
/** User: Dev Lee ... */

namespace app\core;

/**
 * Class Router
 * 
 * @author Ankain Lesly <leeleslyank@gmail.com>
 * @package app\core
 */

class Application {
  public static string $ROOT_DIR;
  public Request $request; 
  public Router $router;
  public Response $response;
  public static Application $app;
  public Controller $controller;

  public function __construct($rootPath)
  {
    self::$ROOT_DIR = $rootPath;
    self::$app = $this;
    $this->request = new Request();
    $this->response = new Response();
    $this->router = new Router($this->request, $this->response);
  }

  public function run() {
    echo $this->router->resolve();
  }
  public function getController() {
    return $this->controller;
  }
  public function setController(Controller $controller) {
    return $this->controller = $controller;
  }
}
?>