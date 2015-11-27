<?php
  require_once 'db.php';
  class ProductModel  extends Model implements iModel
  {
    private $table = "productos";
    public  $id;

    function __construct(){
      $this->connect();
    }

    function save($data){
      $parsed = DB::parseValues($data, true);
      $keys = $parsed["keys"];
      $values = $parsed["values"];
      $query = "INSERT INTO {$this->table}($keys) VALUES ({$values})";
      if(!$this->db->query($query)){
        throw new Exception($this->db->error);
      }
      return $this->id = $this->db->insert_id;
    }

    function saveWithCategory($data){
      $parsed = DB::parseValues($data);
      $keys = $parsed["keys"];
      $values = $parsed["values"];
      $query = "INSERT INTO productos_categorias($keys) VALUES ({$values})";
      if(!$this->db->query($query)){
        throw new Exception($this->db->error);
      }
      $this->id = $this->db->insert_id;
    }

    public function toArray($id){
      if($id === false){
        $query = "SELECT * FROM {$this->table}";
      }else{
        $query = "SELECT * FROM {$this->table}
                    WHERE idproducto = {$id}";
      }
      if(!$_puntero = $this->db->query($query)){
        throw new Exception($this->db->error, 1);
      }
      $result = array();
      while ($row = $_puntero->fetch_assoc()) {
        array_push($result, $row);
      }
      return $result;

    }

  }

 ?>
