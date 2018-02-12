<?php
  namespace vendor\framework;
  /**
   *
   */
  class LoadFunction
  {
    private $functionName = array();
    private $argumentStr = '()';

    static function load($fun_name,$argument = null)
    {
      $this->functionName = explode('@',$fun_name);
      $class = new $this->functionName[0];
      $class->this->functionName[1]($this->processArgument($argument));
    }

    private function processArgument($params)
    {
      if (is_null($params)) {
        return null;
      }
    }
  }

?>
