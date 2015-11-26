<?php

  class Router
  {
    static function createPath($view){
      if(!preg_match('/([a-z\-_\.]+)\.php$/', $view)){
        $view .= '.php';
      }
      return VIEWS . $view;
    }
    static function renderView($view, $data, $statusCode = 200){
      http_response_code($statusCode);
      $_yield = self::createPath($view);

      if(!file_exists($_yield)){
        $_yield = self::createPath('error/500');
      }
      require self::createPath('layout/main');

    }
    static function renderJSON($data){
      return json_encode($data);
    }
  }

 ?>
