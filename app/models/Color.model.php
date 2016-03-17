<?php
  require_once 'db.php';
  class ColorModel extends Model implements iModel
  {
    private $table = "color";
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
      return $this->id;
    }

    function  delete(){

    }

    function update(){

    }

    public function toArray($id = false){
      $id = escapeText($id);
      $query = "SELECT * FROM {$this->table}";
      if(!!$id){
        $query = "SELECT * FROM {$this->table}
                    WHERE idcolor = '{$id}'";
        if(!$_puntero = $this->db->query($query)){
          throw new Exception($this->db->error, 1);
        }
        return $_puntero->fetch_assoc();
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
