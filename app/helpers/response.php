<?php

  class Router
  {
    static function createPath($view){
      if(!preg_match('/([a-z\-_\.]+)\.php$/', $view)){
        $view .= '.php';
      }
      return join(DIRECTORY_SEPARATOR, array(VIEWS, $view));
    }
    static function renderView($view, $data, $statusCode = 200){
      http_response_code($statusCode);
      $_yield = self::createPath($view);
      echo print_r($data);
      if(!file_exists($_yield)){
        $_yield = self::createPath('error/500');
      }
      // echo print_r($data);
      require_once self::createPath('layout/main');
      exit();

    }
    static function renderJSON($data){
      return json_encode($data);
    }
  }

 ?>
