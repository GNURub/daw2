<?php
  function isValidEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }
  function isValidPassword($pass){
    return preg_match('/^[\w\s\S]{8,}$/', $pass);
  }


 ?>
