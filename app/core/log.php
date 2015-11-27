<?php
/**
 * Log class
 */
class Log extends Controller{
    public static function write($text, $nombre_archivo = APP.'thecatlong.log.text'){
      if(is_writable($nombre_archivo)){
        $file = fopen($nombre_archivo, 'a+');
        if(!$file){
          throw new Exception("Error al crear/abrir el fichero", 1);
        }
        fwrite($file, date("Y-m-d H:i:s")." - ".$text." - ".self::getSession('username')."\n");
        fclose($file);
        return true;
      }
    }

}


 ?>
