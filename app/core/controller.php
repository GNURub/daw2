<?php
session_start();
class Controller
{

  public static function setSession($key, $value){
    $_SESSION[$key] = $value;
    self::getSession($key);
  }

  public static function getSession($key){
    if($key == 'admin'){
      $isAdmin = isset($_SESSION[$key]) && (
                      $_SESSION[$key] == 'administrador' ||
                      $_SESSION[$key] == 'admin'
                    );
      return $isAdmin ? true : false;
    }
    return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
  }

  public static function destroySession($key){
    if(self::getSession($key)){
      unset($_SESSION[$key]);
      return true;
    }
    return false;
  }
}

 ?>
