<?php

  class Subcategory extends Controller {
      private $_params;
      private $subcategory;
      private $product;
      private $admin;

      public function __construct($params = array())
      {
        $this->_params     = $params;
        $this->subcategory = new SubcategoryModel();
        $this->admin       = new ClientModel();
        $this->product     = new ProductModel();
      }

      public function index($params = array()){
        if(empty($params[0])){
          Log::write("Error en la subcategoria, no hay parametro para encontrar una.");
          return require VIEWS . 'error/404.php';
        }
        try {
          $subcatego = $this->subcategory->toArray($params[0]);

          if(empty($subcatego)){
            Log::write("No existe la subcategoria que se esta buscando.");
            return require VIEWS . 'error/404.php';
          }
          try {
            $selectedSubcategory = $subcatego['idsubcategoria'];
            $productos = $this->product->selecWithCategorySubcatAndProduct(
            false,
            $subcatego['idsubcategoria'],
            'idproducto'
            );
            Log::write("Se muestra la categoria.");
            return require VIEWS . 'home/index.php';
          } catch (Exception $e) {
            echo $e->getMessage();
            return;
          }
        } catch (Exception $e) {
          $error = $e->getMessage();
          Log::write("Se ha producido una excepción, ". $error);
          return require VIEWS . 'error/500.php';
        }
      }


      public function createAction()
      {
        if(self::getSession('username') && self::getSession('admin')){
          // viene de un formulario
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
            extract($_POST);
            $isValidSubcategory = (
              isset($nombre) &&
              !empty($nombre)
            );
            if($isValidSubcategory){
              try {
                $this->subcategory->save(array(
                  'idsubcategoria' => $nombre
                ));
                return header('location: /');
              } catch (Exception $e) {
                $error = $e->getMessage();
                return require VIEWS . 'error/500.php';
              }
            }
          }
          $client = $this->admin->toArray(self::getSession('username'));
          if($client['rol'] == 'admin' || $client['rol'] == 'administrador'){
            return require VIEWS . 'subcategory/create.php';
          }
          return require VIEWS . 'error/401.php';
        }
        return require VIEWS . 'error/400.php';
      }

      public function xmlAction(){

      }

      public function readAction()
      {
          //read all the todo items
      }

      public function updateAction()
      {
          //update a todo item
      }

      public function deleteAction()
      {
          //delete a todo item
      }
  }

 ?>
