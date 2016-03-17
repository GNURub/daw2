<?php
/**
 * Log class
 */
class Log extends Controller{
    public static function write($text, $nombre_archivo = false){
      if(!$nombre_archivo){
        $nombre_archivo = './thecatlong.log.text';
        echo $nombre_archivo;
      }
      $file = fopen($nombre_archivo, 'a+');
      if(!$file){
        echo "Error al crear/abrir el fichero";
      }
      // fwrite($file, date("Y-m-d H:i:s")." - ".$text." - ".self::getSession('username')."\n");
      fputs($file, date("Y-m-d H:i:s", time())." - ".$text." - ".self::getSession('username'). PHP_EOL);
      fclose($file);
      return true;

    }

}


 ?>
