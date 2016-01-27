<?php

  class Category extends Controller {
      private $_params;
      private $category;
      private $product;
      private $admin;

      public function __construct($params = array())
      {
          $this->_params  = $params;
          $this->category = new CategoryModel();
          $this->admin    = new ClientModel();
          $this->product  = new ProductModel();
      }

      public function index($params = array()){
          if(empty($params[0])){
            Log::write("Error en categoria, no hay parametro para encontrar una.");
            require VIEWS . 'error/404.php';
            return;
          }else{
            $selectedCategory = $params[0];
            if($params[0] == 'Imagenes'){

              $gallery_imgs = scandir(PUBLICO . 'images_gallery'. DIRECTORY_SEPARATOR, 1);
              // echo isImageValid(PUBLICO. 'images_gallery'. DIRECTORY_SEPARATOR . $gallery_img[0]);

              $categories = array(array('idcategoria'=> 'Imagenes'), array('idcategoria'=>'Videos'));
              require VIEWS . "category/imagenes.php";
              return;
            }else if($params[0] == 'Videos'){
              $categories = array(array('idcategoria'=> 'Imagenes'), array('idcategoria'=>'Videos'));
              require VIEWS . "category/imagenes.php";
              return;
            }

            try {
              $catego = $this->category->toArray($params[0]);

              if(empty($catego[0])){
                Log::write("No existe la categoria que se esta buscando.");
                require VIEWS . 'error/404.php';
              }else{
                try {
                  $selectedCategory = $catego[0]['idcategoria'];
                  $productos = $this->product->selecWithCategory($catego[0]['idcategoria']);
                  // no va
                  Log::write("Se muestra la categoria.");
                  require VIEWS . 'category/show.php';
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
                  'idcategoria' => $nombre
                ));
                header('location: /');
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
          require VIEWS . 'error/400.php';
        }


      }

      public function jsonAction(){
        try {
          $id = !empty($this->_params[0]) ? $this->_params[0] : false;
          $categories = $this->category->toArray($id);
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
