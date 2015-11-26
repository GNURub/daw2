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

    }

    function toArray($id = false){
      $query = "SELECT * FROM {$this->table}";
      if(!empty($id)){
        $query = "SELECT * FROM {$this->table}
                    WHERE idproducto = '{$id}'";
      }
      if(!$resultado = $this->db->query($query)){
        throw new Exception($this->db->error, 1);
      }
      return $resultado->fetch_assoc();
    }
  }

 ?>
