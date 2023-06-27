<?php

/** User: Dev Lee ... */

namespace app\router;

/**
 * Class Router
 * 
 * @author Ankain Lesly <leeleslyank@gmail.com>
 * @package app\core
 */

class Response
{
  // configs
  public static ?string $VIEWS_MAIN = null;
  public static ?string $LAYOUT_MAIN = null;

  public static string $ROOT_DIR;
  public static string $views_folder = 'views';
  // protected array $routes = [];
  // public Request $request;

  public function __construct($root_directory)
  {
    self::$ROOT_DIR =  $root_directory;
  }

  public function status(int $code)
  {
    http_response_code($code);
    return $this;
  }
  public function redirect(string $url)
  {
    $this->status(301);
    header("Location: $url");
  }
  public function content(string $text_content)
  {
    exit($text_content);
  }
  public function render(string $view, $params = [])
  {
    // Load Data into view
    if ($params)
      foreach ($params as $key => $value) {
        $$key  = $value;
      }

    $file = self::$ROOT_DIR . '/' . $view;
    if (file_exists($file . ".php")) {
      return include_once $file . ".php";
    }
    if (file_exists($file . ".html")) {
      return include_once $file . ".html";
    }

    $message = 'Ooops! File Not found <br/>';
    $message .= $file . ".php | .html file does not exist!";
    $this->status(404)->content($message);
  }
  public function json(array $data)
  {
    return json_encode($data);
  }



  /**
   * content => exit with text content
   * json => exit with json content
   * render => exit with a view
   * 
   * 
   */
}
