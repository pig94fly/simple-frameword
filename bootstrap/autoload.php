<?php
  function __autoload($class)
  {
    $preg = explode('\\',$class);
    $num = count($preg);
    $path = '';
    for ($i=0; $i < $num-1; $i++) {
      $path .= mb_strtolower($preg[$i]).'/';
    }
    $path .= $preg[$num-1];
    // $class = str_replace('\\','/',$class);
    // print_r(count($preg));
    require_once BASE_PATH.'/'.$path.'.php';
  }
?>
