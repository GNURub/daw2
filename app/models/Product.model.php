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
      return $this->id = $this->db->insert_id;
    }

    function saveWithImage($data){
      $parsed = DB::parseValues($data);
      $keys = $parsed["keys"];
      $values = $parsed["values"];
      $query = "INSERT INTO imagenes($keys) VALUES ({$values})";
      if(!$this->db->query($query)){
        throw new Exception($this->db->error);
      }
      return $this->id = $this->db->insert_id;
    }

    function selecWithCategory($id){
      $id = escapeText($id);
      $query = "SELECT *
        FROM productos p
        NATURAL JOIN productos_categorias a NATURAL JOIN imagenes i WHERE idcategoria = '{$id}'";
      if(!$_puntero = $this->db->query($query)){
        throw new Exception($this->db->error);
      }
      $result = array();
      while ($row = $_puntero->fetch_assoc()) {
        array_push($result, $row);
      }
      return $result;
    }

    public function toArray($id = false){
      if($id === false){
        // $query = "SELECT * FROM {$this->table}";
        $query = "SELECT *
          FROM {$this->table}
          NATURAL JOIN imagenes";
      }else{
        $id = escapeText($id);
        $query = "SELECT *
          FROM {$this->table} p
          NATURAL JOIN imagenes i WHERE idproducto = '{$id}'";
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
