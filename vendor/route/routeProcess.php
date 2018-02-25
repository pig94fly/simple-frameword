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
    private $middleWare = array();
    /**
    * 构造函数
    * @var __construct
    */
    function __construct($uri,$storage,$middleWare=null,$method=null)
    {
      $this->uri = $uri;
      $this->storage = $storage;
      is_null($middleWare)? :$this->middleWare = $middleWare;
      if ($method!==null) $this->methods = $method;
    }

    public function match()
    {
      if ($this->methods!='ANY'&&$_SERVER['REQUEST_METHOD']!=$this->methods) {
        return false;
      }
      $this->uri_arr = explode('/',$this->uri);   //explode uri array
      $uri_arr = explode('/',URI);        //explode requesturi
      $this->matchLastUri();                      //last argument is need？
      $uri_num = count($this->uri_arr);           //matching uri num
      $requestUri_num = count($uri_arr);          //request uri num
      if ($this->ignore_last&&abs($requestUri_num-$uri_num)>1) {
        return false;
      }elseif (!$this->ignore_last&&$requestUri_num!==$uri_num) {
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
      $storage = 'app\Http\Controller\\'.$this->storage;
      Easy::loadFunction($storage,$this->params);
    }

    private function doMiddleWare()
    {
      $middleWare = new MiddleWare($this->middleWare);
      $middleWare->doMiddleWare();
    }

    private function checkUriNum()
    {
      # code...
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
            $this->params[] = $uri_arr[$i];
            continue;
          }elseif ($this->uri_arr[$i]!=$uri_arr[$i]) {
            return false;
          }
        }
        if (isset($uri_arr[$i])) $this->params[] = $uri_arr[$i];
        return true;
      }
      foreach ($this->uri_arr as $key => $value) {
        if (preg_match('/:[^\?]+/',$value)) {
          $this->params[] = $uri_arr[$key];
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
