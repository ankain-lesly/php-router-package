<?php

/** User: Dev Lee ... */
require_once __DIR__ . "/../vendor/autoload.php";

use app\router\Router;

$router = new Router(__DIR__);

// Opening home.php or home.html file;
$router->get("/", "@home");     

// Send and print text/raw content on page;
$router->get("/test", "My Test Page");     

// Opening contact.php or home.html file;
$router->get("/contact", "@contact");

// $router->get("/contact", function($req, $res) {
//   $res->render('contact');
// });

// Running function with Request and Response Objects as parameters
$router->get("/product/{id}", function($req, $res) {
  $p_id = $req->params('id');
  $data = array('product_id' => $p_id);   // OR ['product_id' => $p_id]
 
  $res->render('product', $data);
});

// Running function with Request and Response Objects as parameters
$router->post("/contact", function($req, $res) {
  $data = $req->body();

  echo '<pre>';
  print_r($data);
  echo '</pre>';
  exit;
});


$router->resolve();
