<?php
  require_once 'db.php';
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

    private function _query($id){
      $query = "SELECT * FROM {$this->table}";
      if(!empty($id)){
        $query = "SELECT * FROM {$this->table}
                    WHERE idcategoria = {$id}";
      }
      if(!$resultado = $this->db->query($query)){
        throw new Exception($this->db->error, 1);
      }
      return $resultado;
    }

    function toArray($id = false){
      try {
        return $this->_query($id)->fetch_assoc();
      } catch (Exception $e) {
        throw new Exception($e->getMessage());
      }

    }

    function toObject($id){
      try {
        return $this->_query($id)->fetch_object();
      } catch (Exception $e) {
        throw new Exception($e->getMessage());
      }
    }
  }

 ?>
