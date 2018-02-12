<?php
  namespace vendor\middleware;
  use app\Http\Kernel;
  /**
   *
   */
  class MiddleWare
  {
    /**
     * 路由匹配的中间件
     */
    private $middleWare = array();
    /**
     * middleware配置文件读取
     */
    private $middleWare_list = array();
    /**
    * @var construct middleware
    */
    function __construct($middleWare)
    {
      $this->middleWare = $middleWare;
    }

    public function doMiddleWare()
    {
      foreach ($this->middleWare as $fun) {

      }
    }

    private function getConfig()
    {
      $config = new Kernel();
      $this->middleWare_list = $config->getMiddleWare();
    }
  }

?>
