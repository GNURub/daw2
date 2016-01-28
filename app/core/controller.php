<?php

session_start();
class Controller
{
    public static function setSession($key, $value)
    {
      $_SESSION[$key] = $value;
      self::getSession($key);
    }

    public static function pushInSession($key, $value)
    {
      $array = self::getSession($key);
      if ($array && is_array($array)) {
        if(array_key_exists($value, $array)){
          ++$array[$value];
        }else{
          $array[$value] = 1;
        }
        self::setSession($key, $array);
      }else{
        $_SESSION[$key] = array($value => 1);
      }
    }

    public static function getSession($key)
    {
      if ($key == 'admin') {
        $isAdmin = isset($_SESSION[$key]) && (
                  $_SESSION[$key] == 'administrador' ||
                  $_SESSION[$key] == 'admin'
                );
        return $isAdmin ? true : false;
      }

      return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
    }

    public static function destroySession($key)
    {
      if (self::getSession($key)) {
        unset($_SESSION[$key]);
        return true;
      }
      return false;
    }

    public static function setCookie($key, $value, $time = 1233332)
    {
      setcookie($key, $val, time() + $time);
      self::getCookie($key);
    }

    public static function getCookie($key)
    {
      return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
    }

    public static function destroyCookie($key)
    {
      if (self::getCookie($key)) {
        setcookie($key, '', time() - 3600);
        return true;
      }
      return false;
    }
}
