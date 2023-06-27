<?php

/** User: Dev Lee ... */
require_once __DIR__ . "/../vendor/autoload.php";

use app\router\Router;

$router = new Router(__DIR__);

$router->get("/", "@home");     // Opening home.php or home.html file;
$router->get("/home", "@homde"); // Opening home.php or home.html file;

$router->get("/contact", "@contact");
$router->get("/product/{meta}", function($req, $res) {
  $data = $req->params('');

  echo '<pre>';
  print_r($data);
  echo '<br />';
  echo '</pre>';
  exit;
});


$router->resolve();
