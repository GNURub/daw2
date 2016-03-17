<?php

class Error extends Controller
{

  function index()
  {
    return $this->notfound();
  }
  function badrequestAction()
  {
    return require VIEWS . 'error/400.php';
  }
  function notfound()
  {
    return require VIEWS . 'error/404.php';
  }
  function unauthorizedAction()
  {
    return require VIEWS . 'error/401.php';
  }
  function internalAction()
  {
    return require VIEWS . 'error/500.php';
  }
}

 ?>
