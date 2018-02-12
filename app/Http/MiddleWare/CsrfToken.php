<?php
  /**
   *
   */
  class CsrfToken
  {

    public function handle()
    {
      if (!isset($_POST['_csrftoken'])) {
        return '<h1>Miss CsrfToken!</h1>';
      }
    }
  }

?>
