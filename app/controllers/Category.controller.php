<?php
  require APP.'models/Category.model.php';
  require_once APP.'models/Client.model.php';
  class Category extends Controller {
      private $_params;
      private $category;
      private $admin;

      public function __construct($params = array())
      {
          $this->_params  = $params;
          $this->category = new CategoryModel();
          $this->admin    = new ClientModel();
      }

      public function index($params = array()){
          if(empty($params[0])){
            require VIEWS . 'error/404.php';
            return;
          }else{
            try {
              $catego = $this->category->toArray($params[0]);
              if(empty($catego)){
                require VIEWS . 'error/404.php';
              }else{
                require VIEWS . 'category/show.php';
              }
            } catch (Exception $e) {
              require VIEWS . 'error/500.php';
            }

          }
      }


      public function createAction()
      {
        if(self::getSession('username')){
          // viene de un formulario
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
            extract($_POST);
            $isValidCategory = (
              isset($nombre) &&
              !empty($nombre)
            );
            if($isValidCategory){
              try {
                $this->category->save(array(
                  'nombre' => $nombre
                ));
              } catch (Exception $e) {
                $error = $e->getMessage();
                require VIEWS . 'error/500.php';
              }

            }

          }else{
            $client = $this->admin->toArray(self::getSession('username'));
            if($client['rol'] == 'admin' || $client['rol'] == 'administrador'){
              require VIEWS . 'category/create.php';
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
