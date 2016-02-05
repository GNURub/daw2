<?php

  class Category extends Controller
  {
      private $_params;
      private $category;
      private $subcategory;
      private $product;
      private $admin;

      public function __construct($params = array())
      {
        $this->_params     = $params;
        $this->category    = new CategoryModel();
        $this->admin       = new ClientModel();
        $this->product     = new ProductModel();
        $this->subcategory = new SubcategoryModel();
      }

      public function index($params = array())
      {
        if (empty($params[0])) {
          Log::write('Error en categoria, no hay parametro para encontrar una.');
          return require VIEWS.'error/404.php';
        }
        $selectedCategory = $params[0];
        switch ($params[0]) {
          case 'Imagenes':
            $gallery_imgs = scandir(PUBLICO.'images_gallery'.DIRECTORY_SEPARATOR, 1);
            // echo isImageValid(PUBLICO. 'images_gallery'. DIRECTORY_SEPARATOR . $gallery_img[0]);
            $categories = array(array('idcategoria' => 'Imagenes'), array('idcategoria' => 'Videos'));
            return require VIEWS.'category/imagenes.php';
          case 'Videos':
            $categories = array(array('idcategoria' => 'Imagenes'), array('idcategoria' => 'Videos'));
            return require VIEWS.'category/videos.php';
          case 'subcategory':
          echo "Mostrar productos de subcategoria: ";
          print_r($params[1]);
          exit();
          break;
        }
        // if ($params[0] == 'Imagenes') {
        //   $gallery_imgs = scandir(PUBLICO.'images_gallery'.DIRECTORY_SEPARATOR, 1);
        //   // echo isImageValid(PUBLICO. 'images_gallery'. DIRECTORY_SEPARATOR . $gallery_img[0]);
        //   $categories = array(array('idcategoria' => 'Imagenes'), array('idcategoria' => 'Videos'));
        //   return require VIEWS.'category/imagenes.php';
        // } elseif ($params[0] == 'Videos') {
        //   $categories = array(array('idcategoria' => 'Imagenes'), array('idcategoria' => 'Videos'));
        //   return require VIEWS.'category/videos.php';
        // }
        try {
          $catego = $this->category->toArray($params[0]);
          if (empty($catego)) {
            Log::write('No existe la categoria que se esta buscando.');
            return require VIEWS.'error/404.php';
          }
          try {
            $selectedCategory = $catego['idcategoria'];
            $productos        = $this->product->selecWithCategory($selectedCategory);
            $subcategories    = $this->subcategory->ofCategory($selectedCategory);
            // no va
            Log::write('Se muestra la categoria.');
            return require VIEWS.'category/show.php';
          } catch (Exception $e) {
            echo $e->getMessage();
            return;
          }
        } catch (Exception $e) {
          $error = $e->getMessage();
          Log::write('Se ha producido una excepción, '.$error);
          return require VIEWS.'error/500.php';
        }
      }

      public function createAction()
      {
          if (self::getSession('username')) {
              // viene de un formulario
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              extract($_POST);

              $isValidCategory = (
                isset($nombre) &&
                !empty($nombre)
              );
              if ($isValidCategory) {
                try {
                  $this->category->save(array(
                    'idcategoria' => $nombre,
                  ));
                  foreach ($subcategoria as $sub) {
                    try {
                      $this->category->saveWithSubcategory(array(
                        'idcategoria' => $nombre,
                        'idsubcategoria' => $sub,
                      ));
                    } catch (Exception $e) {
                      exit($e->getMessage());
                    }
                  }
                  return header('location: /');
                } catch (Exception $e) {
                  $error = $e->getMessage();
                  return require VIEWS.'error/500.php';
                }
              }
            }
            $client = $this->admin->toArray(self::getSession('username'));
            if ($client['rol'] == 'admin' || $client['rol'] == 'administrador') {
              try {
                $subcategorias = $this->subcategory->toArray();
                return require VIEWS.'category/create.php';
              } catch (Exception $e) {
                return require VIEWS.'error/500.php';
              }
            }
            return require VIEWS.'error/401.php';
          }
          return require VIEWS.'error/400.php';

      }

      public function jsonAction()
      {
        try {
          $id = !empty($this->_params[0]) ? $this->_params[0] : false;
          $categories = $this->category->toArray($id);
          if (empty($categories)) {
            $categories = array(
              'error' => 400,
              'errorMsg' => 'Categoria no encontrada',
            );
          }
          echo json_encode($categories);
        } catch (Exception $e) {
          $error = array(
            'error' => 200,
            'errorMsg' => $e->getMessage(),
          );
          echo json_encode($error);
        }
        return;
      }

      public function xmlAction()
      {
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
