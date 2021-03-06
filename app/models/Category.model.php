<?php
  require_once 'db.php';
  class CategoryModel extends Model implements iModel
  {
    private $table = "categorias";
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

    function saveWithSubcategory($data){
      $parsed = DB::parseValues($data, true);
      $keys   = $parsed["keys"];
      $values = $parsed["values"];
      $query = "INSERT INTO subcategorias_categorias($keys) VALUES ({$values})";
      if(!$this->db->query($query)){
        throw new Exception($this->db->error);
      }
    }

    public function toArray($id = false, $withSubcat = false, $group =""){
      $selectSubcat = "";
      $group = escapeText($group);
      if($withSubcat){
        $selectSubcat = "NATURAL JOIN subcategorias_categorias";
      }
      if(!empty($group)){
        $group = "GROUP BY ".$group;
      }
      if(!!$id){
        $id = escapeText($id);
        $query = "SELECT * FROM {$this->table} $selectSubcat
        WHERE idcategoria = '{$id}' " .$group;
        if(!$_puntero = $this->db->query($query)){
          throw new Exception($this->db->error, 1);
        }
        return $_puntero->fetch_assoc();
      }
      $query = "SELECT * FROM {$this->table} $selectSubcat " .$group;
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
