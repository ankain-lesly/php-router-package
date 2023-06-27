<?php

namespace app\controllers;

class SiteController
{

  public function products($req, $res)
  {
    $res->content("<h2>My Products Page</h2>");
  }
  public function product_details($req, $res)
  {
    $p_id = $req->params('product_id');
    $page = "<h2>Product Details</h2>";

    $page .= "<p>Details for product with ID : <b>$p_id</b></p>";
    $res->content($page);
  }
  public function create_product($req, $res)
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
