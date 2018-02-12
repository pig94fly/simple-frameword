<?php
  function __autoload($class)
  {
    $path = str_replace('\\','/',$class);
    require_once BASE_PATH.'/'.$path.'.php';
  }
?>
