<?php
  require_once 'db.php';
  class DiscountModel extends Model implements iModel
  {
    private $table = "descuentos";
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

    public function toArray($id){
      if($id === false){
        $query = "SELECT * FROM {$this->table}";
      }else{
        $query = "SELECT * FROM {$this->table}
                    WHERE iddescuento = {$id}";
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
