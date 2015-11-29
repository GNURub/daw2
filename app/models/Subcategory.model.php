<?php
  require_once 'db.php';
  class SubcategoryModel extends Model implements iModel
  {
    private $table = "subcategorias";
    public  $id;
    static $categories;

    function __construct(){
      $this->connect();
      self::$categories = $this->toArray();
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

    public function toArray($id = false){
      if($id === false){
        $query = "SELECT * FROM {$this->table}";
      }else{
        $query = "SELECT * FROM {$this->table}
                    WHERE idsubcategoria = '{$id}'";
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
