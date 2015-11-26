<?php
  require APP.'models/Product.model.php';
  require_once APP.'models/Client.model.php';

  class Product extends Controller {
      private $_params;
      private $product;
      private $admin;


      public function __construct($params = array())
      {
          $this->product = new ProductModel();
          $this->admin   = new ClientModel();
          $this->_params = $params;
      }

      public function index($params = array()){
          if(empty($params[0])){
            require VIEWS . 'error/404.php';
            return;
          }else{
            try {
              $poducto = $this->product->toArray($params[0]);
              if(empty($poducto)){
                require VIEWS . 'error/404.php';
              }else{
                require VIEWS . 'product/show.php';
              }
            } catch (Exception $e) {
              require VIEWS . 'error/500.php';
            }

          }
      }

      public function jsonAction(){
        try {
          $id = !empty($this->_params[0]) ? $this->_params[0] : false;
          $proucts = $this->product->toObject($id);
          echo json_encode($proucts);
        } catch (Exception $e) {
          $error = array(
            'error' => 200,
            'errorMsg' => $e->getMessage()
          );
          echo json_encode($error);
        }

      }

      public function createAction()
      {
          if(self::getSession('username')){
            // viene de un formulario
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
              extract($_POST);
              $isValidProduct = (
                isset($titulo) &&
                isset($marca) &&
                isset($precio) &&
                isset($gastoenvio) &&
                isset($descripcion) &&
                !empty($titulo) &&
                !empty($marca) &&
                !empty($precio) &&
                !empty($gastoenvio) &&
                !empty($descripcion)
              );
              if($isValidProduct){
                try {
                  $this->product->save(array(
                    'titulo' => $titulo,
                    'marca' => $marca,
                    'precio' => $precio,
                    'gatosdeenvio' => $gastoenvio,
                    'descripcion' => $descripcion
                  ));
                } catch (Exception $e) {
                  $error = $e->getMessage();
                  require VIEWS . 'error/500.php';
                }

              }

            }else{
              $client = $this->admin->toArray(self::getSession('username'));
              if($client['rol'] == 'admin' || $client['rol'] == 'administrador'){
                require VIEWS . 'product/create.php';
              }else{
                require VIEWS . 'error/401.php';
              }
            }
          }else{
            require VIEWS . 'error/401.php';
          }
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
