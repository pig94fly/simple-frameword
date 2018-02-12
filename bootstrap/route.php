<?php
  use vendor\framework\LoadFunction;
  require BASE_PATH.'/vendor/route/routeProcess.php';

  /**
   *  Route类，实现路由的分写
   *  由__callStatic魔术方法，返回实例化的post类和get类以及any方法
   *  返回实例化的类后，能够调用方法
   */
  class Route
  {
    /**
     * 存储路由资源
     * @var Array
     */
    private $routes = array();
    /**
     * 调用route存储类
     * @var Function
     */
    public function add($uri,$storage,$middleWare=null,$method=null)
    {
      $route = new RouteProcess($uri,$storage,$middleWare,$method);
      $this->routes[] = $route;
      return $route;
    }
    /**
     * uri匹配函数
     * @var Function
     */
    public function match($requestUri)
    {
      foreach ($this->routes as $route) {
        if ($route->match($requestUri)) return $route;
      }
      header('Location:'.HTTP_HOST);exit;
    }

    //GET FUNCTION()
    public function get($uri,$storage,$middleWare=null)
    {
      return $this->add($uri,$storage,$middleWare,'GET');
    }
    //POST FUNCTION()
    public function post($uri,$storage,$middleWare=null)
    {
      is_array($middleWare)?$middleWare[] = 'csrfToken':$middleWare = $this->processMiddleWare($middleWare,'csrfToken');
      return $this->add($uri,$storage,$middleWare,'POST');
    }
    //PUT FUNCTION()
    public function put($uri,$storage,$middleWare=null)
    {
      return $this->add($uri,$storage,$middleWare,'PUT');
    }
    //DELETE FUNCTION()
    public function delete($uri,$storage,$middleWare=null)
    {
      return $this->add($uri,$storage,$middleWare,'DELETE');
    }
    //PATCH FUNCTION()
    public function patch($uri,$storage,$middleWare=null)
    {
      return $this->add($uri,$storage,$middleWare,'PATCH');
    }
    //中间件配置函数
    private function processMiddleWare($preMethod,$additional)
    {
      return $middleWare = array($preMethod,$additional);
    }

  }



?>
