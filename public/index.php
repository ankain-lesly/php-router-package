<?php

/** User: Dev Lee ... */
require_once __DIR__ . "/../vendor/autoload.php";

use app\router\Router;

$router = new Router(__DIR__);

$router->get("/", "@home");     // Opening home.php or home.html file;
$router->get("/home", "@home"); // Opening home.php or home.html file;

$router->get("/test", "My Test Page");     // Print send and print data on page;

$router->get("/contact", "@contact");
$router->get("/product/{meta}", function($req, $res) {
  $data = $req->params('meta');

  echo $data;
  exit;
});


$router->resolve();
