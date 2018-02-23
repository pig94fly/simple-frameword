<?php
  /**
   *
   */
  class Easy
  {
    /**
    * 自动加载函数
    * 可以加载多个函数，以array（）传参
    */
    static function loadFunction($methods,$argument)
    {
      if (is_array($methods)) {
        foreach ($methods as $key=>$method) {
          load($method,$argument[$key]);
        }
      }else {
        load($methods,$argument);
      }

      function load($method,$argument)
      {
        $method = explode('@',$method);
        $class = new $method[0];
        $class->$method[1](...$argument);
      }
    }
  }

?>
