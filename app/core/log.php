<?php
/**
 * Log class
 */
class Log extends Controller{
    public static function write($text, $nombre_archivo = false){
      if(!$nombre_archivo){
        $nombre_archivo = APP . 'thecatlong.log.text';
      }
      $file = fopen($nombre_archivo, 'a+');
      if(!$file){
        throw new Exception("Error al crear/abrir el fichero", 1);

      }
      // fwrite($file, date("Y-m-d H:i:s")." - ".$text." - ".self::getSession('username')."\n");
      fputs($file, date("Y-m-d H:i:s", time())." - ".$text." - ".self::getSession('username'). PHP_EOL);
      fclose($file);
      return true;

    }

}


 ?>
