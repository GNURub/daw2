<?php
  require_once 'db.php';
  class ImageModel extends Model implements iModel
  {
    private $table = "imagenes";
    public  $id;

    function __construct(){
      $this->connect();
    }

    function save($data){
      $parsed = DB::parseValues($data);
      $keys = $parsed["keys"];
      $values = $parsed["values"];
      $query = "INSERT INTO {$this->table}($keys) VALUES ({$values})";
      if(!$this->db->query($query)){
        throw new Exception($this->db->error);
      }
      $this->id = $this->db->insert_id;

    }

    function  delete(){

    }

    function update(){

    }

    function toArray($id = false){
      $query = "SELECT * FROM {$this->table}
                    WHERE idimagen = '{$this->id}'";
      $result = $this->db->query($query);
      return $result->fetch_object();
    }
  }

 ?>
