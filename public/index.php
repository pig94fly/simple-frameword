<?php
  //项目时区设置
  date_default_timezone_set('Asia/Shanghai');
  header('Content-type:text/html;charset=utf-8');

  //调试模式
  define('APP_DEBUG',TRUE);

  //引入配置文件
  include '../config.php';
  //自动加载文件
  include '../bootstrap/autoload.php';

  echo URI;
