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
  public function render(string $view, array $params = [])
  {
    // Load Data into view
    $view = $this->getView($view, $params);
    $layout = $this->getLayout();
    if ($layout) {
      exit(str_replace("{{content}}", $view, $layout));
    }

    exit($view);
  }
  public function getView(string $view, $params = [])
  {
    // Load Data into view
    if ($params) {
      foreach ($params as $key => $value) {
        $$key  = $value;
      }
    }

    $file = self::$ROOT_DIR . '/' . $view;

    if (self::$VIEWS_MAIN) {
      $file = self::$ROOT_DIR . '/../' . self::$VIEWS_MAIN . '/' . $view;
    }

    if (!file_exists($file . ".php") && !file_exists($file . ".html"))
      $file = self::$ROOT_DIR . '/' . self::$VIEWS_MAIN . '/' . $view;

    if (file_exists($file . ".php")) {
      ob_start();
      include_once $file . ".php";
      return ob_get_clean();
    } elseif (file_exists($file . ".html")) {
      ob_start();
      include_once $file . ".html";
      return ob_get_clean();
    }

    $file = self::$VIEWS_MAIN ? self::$VIEWS_MAIN . '/' : '';
    $message = 'Ooops! Your file could not be located. <br />Check the filename and try again ';
    $message .= "<mark><b> " . $file  . $view . ".php </b></mark> or <b>.html</b> file does not exist your directory!!!";
    throw new RouterException($message, 444);
  }
  public function getLayout()
  {
    $layout = self::$LAYOUT_MAIN;
    if (!$layout) return false;

    $file = self::$ROOT_DIR . '/../' . self::$VIEWS_MAIN . '/' . $layout;

    if (!file_exists($file . ".php") && !file_exists($file . ".html"))
      $file = self::$ROOT_DIR . '/' . self::$VIEWS_MAIN . '/' . $layout;

    if (file_exists($file . ".php")) {
      ob_start();
      include_once $file . ".php";
      return ob_get_clean();
    } elseif (file_exists($file . ".html")) {
      ob_start();
      include_once $file . ".html";
      return ob_get_clean();
    }

    $file = self::$LAYOUT_MAIN ? self::$LAYOUT_MAIN . '/' : '';
    $message = 'Ooops! Your file could not be located. <br />Check the filename and try again ';
    $message .= "<mark><b> " . $layout . ".php </b></mark> or <b>.html</b> file does not exist your directory!!!";
    throw new RouterException($message, 444);
  }


  public function json(array $data)
  {
    exit(json_encode($data));
  }



  /**
   * content => exit with text content
   * json => exit with json content
   * render => exit with a view
   * 
   * 
   */
}
