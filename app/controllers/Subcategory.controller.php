<?php

  class Subcategory extends Controller {
      private $_params;
      private $subcategory;
      private $product;
      private $admin;

      public function __construct($params = array())
      {
          $this->_params  = $params;
          $this->subcategory = new SubcategoryModel();
          $this->admin    = new ClientModel();
          $this->product  = new ProductModel();
      }

      public function index($params = array()){
          if(empty($params[0])){
            Log::write("Error en la subcategoria, no hay parametro para encontrar una.");
            require VIEWS . 'error/404.php';
            return;
          }else{
            try {
              $subcatego = $this->subcategory->toArray($params[0]);

              if(empty($subcatego[0])){
                Log::write("No existe la subcategoria que se esta buscando.");
                require VIEWS . 'error/404.php';
              }else{
                try {
                  $selectedSubcategory = $subcatego[0]['idsubcategoria'];
                  // $productos = $this->product->selecWithSubcategory($subcatego[0]['idcategoria']);
                  // no va
                  Log::write("Se muestra la categoria.");
                  require VIEWS . 'subcategory/show.php';
                } catch (Exception $e) {
                  echo $e->getMessage();
                }

              }
            } catch (Exception $e) {
              $error = $e->getMessage();
              Log::write("Se ha producido una excepción, ". $error);
              require VIEWS . 'error/500.php';
            }

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
                  'idcategoria' => $nombre
                ));
              } catch (Exception $e) {
                $error = $e->getMessage();
                require VIEWS . 'error/500.php';
              }

            }

          }else{
            $client = $this->admin->toArray(self::getSession('username'));
            if($client['rol'] == 'admin' || $client['rol'] == 'administrador'){
              require VIEWS . 'subcategory/create.php';
            }else{
              require VIEWS . 'error/401.php';
            }
          }
        }else{
          require VIEWS . 'error/400.php';
        }


      }

      public function jsonAction(){
        try {
          $id = !empty($this->_params[0]) ? $this->_params[0] : false;
          $categories = $this->subcategory->toArray($id);
          if (empty($categories)) {
            $categories = array(
              'error' => 400,
              'errorMsg' => "Categoria no encontrada"
            );
          }
          echo json_encode($categories);
        } catch (Exception $e) {
          $error = array(
            'error' => 200,
            'errorMsg' => $e->getMessage()
          );
          echo json_encode($error);
        }

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
