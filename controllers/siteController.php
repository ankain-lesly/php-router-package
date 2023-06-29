<?php

namespace app\controllers;

use app\router\Request;
use app\router\Response;

class SiteController
{

  public function myBlog(Request $req, Response $res)
  {
    // $res->content("<h2>My Blog Page</h2>");
    $res->render('blog');
  }
  public function product_details(Request $req, Response $res)
  {
    $blog_id = $req->params('blog_id');
    // $content = "<h2>Product Details</h2>";

    // $content .= "<p>Details for product with ID : <b>$blog_id</b></p>";
    // $res->content($content);
    $res->render('blog', ['blog_id' => $blog_id]);
  }
  public function create_product(Request $req, Response $res)
  {
    if ($req->isPost()) {
      $data = $req->body();
      echo "Handling Product Form";

      echo '<pre>';
      print_r($data);
      echo '</pre>';
      return true;
    }

    $res->render('create-product');
  }
}
