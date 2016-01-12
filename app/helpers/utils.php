<?php
  function isValidEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }
  function isValidPassword($pass){
    return preg_match('/^[\w\s\S]{8,}$/', $pass);
  }

  function escapeText($text){
    return htmlentities(htmlspecialchars($text));
  }

  function uploadImage($file){

    $target_file = IMGS . uniqid() . basename($file["name"]);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $check = getimagesize($file["tmp_name"]);
    if(!$check) {
      throw new Exception("No es una imagen", 1);
    }

    if (file_exists($target_file)) {
      throw new Exception("La imagen ya existe", 1);
    }

    if ($file["size"] > 500000) {
      throw new Exception("La imagen es demasiado grande", 1);
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      throw new Exception("Solo se permiten subir imagenes", 1);
    }

    $temp = explode(".", $file["name"]);
    $newfilename = uniqid() . '.' . end($temp);

    if (move_uploaded_file($file["tmp_name"], IMGS . $newfilename)) {
        return $newfilename;
    }
    throw new Exception("Error al subir la imagen", 1);
  }
  // To transparently support this function on older versions of PHP
  if(!function_exists('hash_equals')) {
    function hash_equals($str1, $str2) {
      if(strlen($str1) != strlen($str2)) {
        return false;
      } else {
        $res = $str1 ^ $str2;
        $ret = 0;
        for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
        return !$ret;
      }
    }
  }

 ?>
