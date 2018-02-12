<?php
namespace app\Http;
/**
 *
 */
class Kernel
{
  private $middleWare = [
    'csrfToken' => 'app\Http\MiddleWare\CsrfToken',
  ];
  public function getMiddleWare()
  {
    return $this->middleWare;
  }
}


?>
