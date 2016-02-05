<?php
  require_once 'db.php';
  class SubcategoryModel extends Model implements iModel
  {
    private $table = "subcategorias";
    public  $id;
    static $subcategories;

    function __construct(){
      $this->connect();
      self::$subcategories = $this->toArray();
    }

    function save($data){
      $parsed = DB::parseValues($data, true);
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

    function ofCategory($category){
      $query = "SELECT * FROM subcategorias_categorias WHERE idcategoria = '{$category}'";
      if(!$_puntero = $this->db->query($query)){
        throw new Exception($this->db->error, 1);
      }
      $result = array();
      while ($row = $_puntero->fetch_assoc()) {
        array_push($result, $row);
      }
      return $result;
    }

    public function toArray($id = false){
      if(!!$id){
        $query = "SELECT * FROM {$this->table}
        WHERE idsubcategoria = '{$id}'";
        if(!$_puntero = $this->db->query($query)){
          throw new Exception($this->db->error, 1);
        }
        return $_puntero->fetch_assoc();
      }
      $query = "SELECT * FROM {$this->table}";
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
