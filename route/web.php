<?php
  $route = new Route;
  $route->any('home',function (){echo "<h1>Welcome To My Framework</h1>";});
  $route->get('admin','admin');
  $route->get('test/:id/:de?','TestController@index');
  $route->any('dd',function ()
  {
    echo "homepost";
  });
  $a = $route->match();
  $a->doRoute();
  // echo $_SERVER['REQUEST_METHOD'];

  // foreach ($_SERVER as $key => $value) {
  //   echo "$key=>$value<br>";
  // }
