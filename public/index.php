<?php

/** User: Dev Lee ... */
require_once __DIR__ . "/../vendor/autoload.php";

use app\controllers\SiteController;
use app\router\Router;

$router = new Router(__DIR__);

// Router Configurations
$router->config("views", "main");

// $router->get($route, $handler);
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
$router->get("/blog", "@blog");
$router->get("/blog/{id}", function ($req, $res) {
  $blog_id = $req->params('id');
  $data = array('blog_id' => $blog_id);   // OR ['blog_id' => $blog_id]

  $res->render('blog', $data);
});

// Running function with Request and Response Objects as parameters
$router->post("/contact", function ($req, $res) {
  $data = $req->body();

  echo '<pre>';
  print_r($data);
  echo '</pre>';
  exit;
});


$router->get("/products", [SiteController::class, 'products']);
$router->get("/products/{product_id}", [SiteController::class, 'product_details']);
$router->get("/create/product", [SiteController::class, 'create_product']);
$router->post("/create/product", [SiteController::class, 'create_product']);

$router->resolve();
