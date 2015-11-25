<?php
  require_once 'db.php';
  class DiscountModel implements iModel
  {
    private $db;
    private $instance;
    private $table = "descuentos";
    public  $id;

    function __construct(){
      $this->instance = DB::getInstance();
      $this->db = $this->instance->getConnection();
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

    function toArray(){
      $query = "SELECT * FROM {$this->table}
                    WHERE iddescuento = '{$this->id}'";
      $result = $this->db->query($query);
      return $result->fetch_object();
    }
  }

 ?>
