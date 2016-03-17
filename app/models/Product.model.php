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


    function selecWithCategorySubcatAndProduct($idcat, $idsub = false, $group = ""){
      $idcat = escapeText($idcat);
      $idsub = escapeText($idsub);
      $group = escapeText($group);
      if(!empty($group)){
        $group = "GROUP BY " . $group;
      }
      $query = "SELECT *
        FROM productos p
        NATURAL JOIN productos_subcategorias_categorias a NATURAL JOIN imagenes i NATURAL JOIN productos_tallas_colores WHERE idcategoria = '{$idcat}' ".$group;
      if($idsub){
        if(!$idcat){
          $query = "SELECT *
            FROM productos p
            NATURAL JOIN productos_subcategorias_categorias a NATURAL JOIN imagenes i NATURAL JOIN productos_tallas_colores WHERE idsubcategoria = '{$idsub}' ".$group;
        }else{
          $query = "SELECT *
            FROM productos p
            NATURAL JOIN productos_subcategorias_categorias a NATURAL JOIN imagenes i NATURAL JOIN productos_tallas_colores WHERE idcategoria = '{$idcat}' AND idsubcategoria = '{$idsub}' ".$group;
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

    public function productoTallaColor($pro, $size, $color){
      $query = "SELECT *
      FROM productos_tallas_colores WHERE idproducto = '{$pro}' AND
      idcolor = '{$color}' AND idtalla = '{$size}'";
      if(!$_puntero = $this->db->query($query)){
        throw new Exception($this->db->error, 1);
      }
      return $_puntero->fetch_assoc();
    }

    public function tallasColoresProducto($pro, $size = ""){
      if(!empty($size)){
        $size = " and idtalla = '{$size}'";
      }
      $query = "SELECT *
      FROM productos_tallas_colores WHERE stock > 0 AND idproducto = {$pro}".$size;
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
        $id = escapeText($id);

        $query = "SELECT *
        FROM {$this->table} p
        NATURAL JOIN imagenes i WHERE idproducto = '{$id}' OR titulo = '{$id}'";
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

    public function search($query){
        $query = escapeText($query);
        $q = "SELECT *
        FROM {$this->table} p
        NATURAL JOIN imagenes i
        WHERE
        (
            titulo LIKE '%{$query}%'
            OR descripcion LIKE '%{$query}%'
            OR marca LIKE '%{$query}%'
            OR precio LIKE '%{$query}%'
        )";

      if(!$_puntero = $this->db->query($q)){
        throw new Exception($this->db->error, 1);
      }
      $result = array();
      while ($row = $_puntero->fetch_assoc()) {
        array_push($result, $row);
      }
      return $result;
    }

    public function edit($data, $id){
      $set = "";
      foreach ($data as $key => $value) {
        if(!empty($value)){
          if(is_numeric($value)){
            $set .= $set == "" ? "$key = " . $value : ",$key = ".$value;
          }else{
            $set .= $set == "" ? "$key = '{$value}'" : ",$key = '{$value}'";
          }
        }
      }
      $query = "UPDATE {$this->table}
        SET {$set}
        WHERE idproducto = {$id}";

      if (!$this->db->query($query)) {
          throw new Exception($this->db->error, 1);
      }
    }

  }

 ?>
