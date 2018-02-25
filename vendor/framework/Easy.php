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
      function load($method,$argument)
      {
        $arr = explode('@',$method);
        $className = $arr[0];
        $funName = $arr[1];
        $class = new $className;
        is_array($argument)?@$class->$funName(...$argument):$class->$funName($argument);
      }

      if (is_array($methods)) {
        foreach ($methods as $key=>$method) {
          load($method,$argument[$key]);
        }
      }else {
        load($methods,$argument);
      }


    }
  }

?>
