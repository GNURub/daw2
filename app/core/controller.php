<?php
session_start();
class Controller
{

  public static function setSession($key, $value){
    $_SESSION[$key] = $value;
    self::getSession($key);
  }

  public static function getSession($key){
    return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
  }
}

 ?>
