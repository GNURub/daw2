<?php
  require_once 'db.php';
  class ClientModel extends Model implements iModel
  {
    private $table = "usuarios";
    public  $id;
    public $category;

    function __construct(){
      $this->connect();
      $this->category = new CategoryModel();
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

    function  delete($id){
      $id = escapeText($id);
      $query = "DELETE FROM {$this->table} WHERE username = '{$id}' OR email = '{$id}'";
      if(!$this->db->query($query)){
        throw new Exception($this->db->error);
      }
      return true;
    }

    function update($id){

    }

    function toArray($id = false){
      $by = !empty($id) ? $id : $this->id;
      $by = escapeText($by);
      $query = "SELECT * FROM {$this->table}
                    WHERE username = '{$by}' OR email = '{$by}'";
      if(!$resultado = $this->db->query($query)){
        throw new Exception($this->db->error, 1);
      }
      return $resultado->fetch_assoc();
    }

  }

 ?>
