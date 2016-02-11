<?php
  require_once 'db.php';
  class ProductModel  extends Model implements iModel
  {
    private $table = "productos";
    public  $id;

    function __construct(){
      $this->connect();
    }

    function save($data, $table = "productos"){
      $parsed = DB::parseValues($data, true);
      $keys = $parsed["keys"];
      $values = $parsed["values"];
      $query = "INSERT INTO {$table}($keys) VALUES ({$values})";
      if(!$this->db->query($query)){
        throw new Exception($this->db->error);
      }
      return $this->id = $this->db->insert_id;
    }


    function selecWithCategorySubcatAndProduct($idcat, $idsub = false){
      $idcat = escapeText($idcat);
      $idsub = escapeText($idsub);
      $query = "SELECT *
        FROM productos p
        NATURAL JOIN productos_subcategorias_categorias a NATURAL JOIN imagenes i NATURAL JOIN productos_tallas_colores WHERE idcategoria = '{$idcat}'";
      if($idsub){
        if(!$idcat){
          $query = "SELECT *
            FROM productos p
            NATURAL JOIN productos_subcategorias_categorias a NATURAL JOIN imagenes i NATURAL JOIN productos_tallas_colores WHERE idsubcategoria = '{$idsub}'";
        }else{
          $query = "SELECT *
            FROM productos p
            NATURAL JOIN productos_subcategorias_categorias a NATURAL JOIN imagenes i NATURAL JOIN productos_tallas_colores WHERE idcategoria = '{$idcat}' AND idsubcategoria = '{$idsub}'";
        }
      }
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
      if(!!$id){
        $id = escapeText($id);
        $query = "SELECT *
        FROM {$this->table} p
        NATURAL JOIN imagenes i WHERE idproducto = '{$id}'";
        if(!$_puntero = $this->db->query($query)){
          throw new Exception($this->db->error, 1);
        }
        return $_puntero->fetch_assoc();
      }
      $query = "SELECT *
      FROM {$this->table}
      NATURAL JOIN imagenes";

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
