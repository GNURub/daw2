<?php
  require_once 'db.php';
  require_once APP.'core/model.php';
  class CategoryModel extends Model implements iModel
  {
    private $table = "categorias";
    public  $id;

    function __construct(){
      $this->connect();
    }

    function save($data){
      $parsed = DB::parseValues($data);
      $keys   = $parsed["keys"];
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

    function toArray(){
      $query = "SELECT * FROM {$this->table}
                    WHERE idcategoria = '{$this->id}'";
      $result = $this->db->query($query);
      return $result->fetch_object();
    }
  }

 ?>
