<?php

class Error
{

  function index()
  {
    return $this->notfound();
  }
  function badrequestAction()
  {
    require VIEWS . 'error/400.php';
  }
  function notfound()
  {
    require VIEWS . 'error/404.php';
  }
  function unauthorizedAction()
  {
    require VIEWS . 'error/401.php';
  }
  function internalAction()
  {
    require VIEWS . 'error/500.php';
  }
}

 ?>
