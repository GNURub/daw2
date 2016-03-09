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
            function showImage($id, $urlimg){
              echo "<div class='lightbox card card-2'>";
              echo "<a class='lightbox' href='#{$id}'>";
              echo "<img src='{$urlimg}' alt='' />";
              echo "</a>";
              echo "</div>";
              echo "<div class='lightbox-target' id='{$id}'>";
              echo "<img src='{$urlimg}'/>";
              echo "<a class='lightbox-close' href='#'></a>";
              echo "</div>";
            }
            $dirs= array(0 => 'gal_img');
            $gallery_imgs = scandir(PUBLICO . $dirs[0], 1);
            foreach ($gallery_imgs as $i => $ele) {
              $url = PUBLICO . $dirs[0] . DIRECTORY_SEPARATOR. $ele;
              if(is_dir($url) && $ele != '.' && $ele != '..'){
                array_push($dirs, $ele);
              }
            }
            $categories = array(array('idcategoria' => 'Imagenes'), array('idcategoria' => 'Videos'));
            return require VIEWS.'category/imagenes.php';
          case 'Videos':
            $categories = array(array('idcategoria' => 'Imagenes'), array('idcategoria' => 'Videos'));
            return require VIEWS.'category/videos.php';
        }

        try {
          $catego = $this->category->toArray($params[0]);
          if (empty($catego)) {
            Log::write('No existe la categoria que se esta buscando.');
            return require VIEWS.'error/404.php';
          }
          try {
            $idsub = false;
            if(!empty($params[1])){
              $idsub = $params[1];
            }
            $selectedCategory = $catego['idcategoria'];
            $productos        = $this->product->selecWithCategorySubcatAndProduct(
            $selectedCategory,
            $idsub,
            "idproducto");
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
                  $error = $e->getCode();
                  if($error == 0){
                    try {
                      foreach ($subcategoria as $sub) {
                        $rel = $this->subcategory->ofCategory($nombre, $sub);
                        if(empty($rel)){
                          $this->category->saveWithSubcategory(array(
                            'idcategoria' => $nombre,
                            'idsubcategoria' => $sub,
                          ));

                        }
                      }
                      return header('location: /');
                    } catch (Exception $e) {
                      exit($e->getMessage());
                    }
                    return;
                  }
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
