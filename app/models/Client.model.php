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

    function save($data, $table = "usuarios"){
      $parsed = DB::parseValues($data);
      $keys = $parsed["keys"];

      $values = $parsed["values"];
      $query = "INSERT INTO {$table}($keys) VALUES ({$values})";
      echo $query;
      exit;
      if(!$this->db->query($query)){
        throw new Exception($this->db->error);
      }
      $this->id = $this->db->insert_id;
      return $this->id;
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
      if($by){
        $query = "SELECT * FROM {$this->table}
        WHERE username = '{$by}' OR email = '{$by}'";
        if(!$resultado = $this->db->query($query)){
          throw new Exception($this->db->error, 1);
        }
        return $resultado->fetch_assoc();
      }
      $query = "SELECT * FROM {$this->table}";
      if(!$resultado = $this->db->query($query)){
        throw new Exception($this->db->error, 1);
      }
      $result = array();
      while ($row = $resultado->fetch_assoc()) {
        array_push($result, $row);
      }
      return $result;
    }

    function getOrders($username = false, $id = false){
      $by = !empty($username) ? $username : $this->id;
      $by = escapeText($by);
      $id =  escapeText($id);
      $q = "";
      $query = "SELECT * FROM compras
      WHERE username = '{$by}'";
      if(!!$id){
        $q = " AND (c.idcompra = {$id} OR c.hash_compra = '{$id}')";
      }
      if($id){
        $query = "SELECT * FROM compras c LEFT JOIN compras_productos_tallas_colores USING(idcompra)
        WHERE c.username = '{$by}'".$q;
      }
      if(!$resultado = $this->db->query($query)){
        throw new Exception($this->db->error, 1);
      }
      $result = array();
      while ($row = $resultado->fetch_assoc()) {
        array_push($result, $row);
      }
      return $result;
    }

  }

 ?>
