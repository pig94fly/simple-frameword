<?php
  $route = new Route;
  $route->get('admin','admin');
  $a = $route->match('admin');
  $a->getStorage();
