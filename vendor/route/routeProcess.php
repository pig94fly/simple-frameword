<?php
  use vendor\middleware\MiddleWare;
  /**
   *  定义一个Route的处理类
   */
  class RouteProcess
  {
    /**
     * 提供匹配的uri
     * @var String
     */
    private $uri = null;
    /**
     * 提供匹配的uri数组形式
     * @var Array
     */
    private $uri_arr = array();
    /**
     * 提供方法存储空间;
     * @var Array
     */
    private $storage = null;
    /**
     * 提供匹配HTTP方法
     * @var Array
     */
    private $methods=['GET','POST','PUT','DELETE','PATCH'];
    /**
     * 提供自定义的参数
     * @var Array
     */
    private $params = null;
    /**
     * 不匹配的key值
     * @var Bool
     */
    private $ignore_last = false;
    /**
     * 中间件匹配方法
     * @var Array
     */
    private $middleWare = null;
    /**
    * 构造函数
    * @var __construct
    */
    function __construct($uri,$storage,$middleWare=null,$method=null)
    {
      $this->uri = $uri;
      $this->storage = $storage;
      is_null($middleWare)? :$this->$middleWare = $middleWare;
      if ($method!==null) $this->methods = $method;
    }

    public function match($requestUri)
    {
      $this->uri_arr = explode('/',$this->uri);
      $uri_arr = explode('/',$requestUri);
      $this->matchLastUri();
      $uri_num = count($this->uri_arr);
      $requestUri_num = count($uri_arr);
      if ($this->ignore_last&&abs($requestUri_num-$uri_num)>1) {
        return false;
      }elseif ($requestUri_num!==$uri_num) {
        return false;
      }
      return $this->matchUriArr($uri_arr);
    }

    public function doRoute()
    {
      if (!empty($middleWare)) {
        $this->doMiddleWare();
      }
      if (is_object($this->storage)) {
        $func = $this->storage;
        $func();return ;
      }
      Easy::loadFunction($this->storage,$this->params);
    }

    private function doMiddleWare()
    {
      $middleWare = new MiddleWare($this->middleWare);
      $middleWare->doMiddleWare();
    }

    private function matchLastUri()
    {
      if (preg_match('/:\S+\?/',$this->uri_arr[count($this->uri_arr)-1])) {
        $this->ignore_last = true;
      }
    }

    private function matchUriArr($uri_arr)
    {
      if ($this->ignore_last) {
        for ($i=0;$i<count($this->uri_arr)-1;$i++) {
          if (preg_match('/:[^\?]+/',$this->uri_arr[$i])) {
            $this->params[substr($this->uri_arr[$i],0,-1)] = $uri_arr[$i];
            continue;
          }elseif ($this->uri_arr[$i]!=$uri_arr[$i]) {
            return false;
          }
        }
        if (isset($uri_arr[$i])) $this->params[substr($this->$uri_arr[$i],1,-1)] = $uri_arr[$i];
        return true;
      }
      foreach ($this->uri_arr as $key => $value) {
        if (preg_match('/:[^\?]+/',$value)) {
          $this->params[substr($value,0,-1)] = $uri_arr[$key];
          continue;
        }elseif ($value!=$uri_arr[$key]) {
          return false;
        }
      }
      return true;
    }

    public function getStorage()
    {
      echo $this->storage;
    }

  }
