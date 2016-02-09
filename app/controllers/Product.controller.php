<?php
  class Product extends Controller
  {
      private $_params;
      private $product;
      private $category;
      private $subcategory;
      private $admin;
      public static $products;

      public function __construct($params = array())
      {
        $this->product     = new ProductModel();
        $this->admin       = new ClientModel();
        $this->category    = new CategoryModel();
        $this->subcategory = new SubcategoryModel();
        $this->_params = $params;
        self::$products = $this->product->toArray();
      }

      public function index($params = array())
      {
          if (empty($params[0])) {
            return require VIEWS.'error/404.php';
          }
          try {
            $poducto = $this->product->toArray($params[0]);
            if (empty($poducto)) {
              return require VIEWS.'error/404.php';
            }
            return require VIEWS.'product/show.php';
          } catch (Exception $e) {
            return require VIEWS.'error/500.php';
          }
      }

      public function soapAction(){
        $server = new soap_server();
        $server->configureWSDL('productservice','urn:ProductModel', URL.'/product/soap');
        $server->wsdl->schemaTargetNamespaces = 'urn:ProductModel';
        $server->wsdl->addComplexType(
          'Producto',
          'complexType',
          'struct',
          'all',
          '',
          array(
          'idproducto' => array('name' => 'idproducto', 'type' => 'xsd:string'),
          'titulo' => array('name' => 'titulo', 'type' => 'xsd:string'),
          'descripcion' => array('name' => 'descripcion', 'type' => 'xsd:string'),
          'precio' => array('name' => 'precio', 'type' => 'xsd:integer'),
          'gatosdeenvio' => array('name' => 'gatosdeenvio', 'type' => 'xsd:integer'),
          'marca' => array('name' => 'marca', 'type' => 'xsd:string'),
          'createdAt' => array('name' => 'createdAt', 'type' => 'xsd:string'),
          'iddescuento' => array('name' => 'iddescuento', 'type' => 'xsd:string'),
          'idsubcategoria' => array('name' => 'idsubcategoria', 'type' => 'xsd:string'),
          'idimagen' => array('name' => 'idimagen', 'type' => 'xsd:integer'),
          'path' => array('name' => 'path', 'type' => 'xsd:string')
        ));
        $server->wsdl->addComplexType(
                'Productos',
                'complexType',
                'array',
                'sequence',
                '',
                array(),
                array(array('ref' => 'http://schemas.xmlsoap.org/soap/encoding/:arrayType',
                 'wsdl:arrayType' => 'tns:Producto[]')
                ),
                'tns:Producto'
        );
        $server->register("ProductModel.selecWithCategorySubcatAndProduct",
            array("category" => "xsd:string", "subcategory" => "xsd:string"),
            array("return" => "tns:Productos"),
            "urn:ProductModel",
            "urn:ProductModel#selecWithCategorySubcatAndProduct",
            "rpc",
            "encoded",
            "Get products by category or subcategory");
        $server->register("ProductModel.toArray",
            array("id" => "xsd:string"),
            array("return" => "xsd:Array"),
            "urn:ProductModel",
            "urn:ProductModel#toArray",
            "rpc",
            "encoded",
            "Get products id or all");
        $POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
        @$server->service($POST_DATA);

      }

      public function createAction()
      {
        if (self::getSession('username')) {
              // viene de un formulario
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              extract($_POST);
              $isValidProduct = (
              isset($titulo) &&
              isset($marca) &&
              isset($precio) &&
              isset($gastoenvio) &&
              isset($categoria) &&
              isset($descripcion) &&
              isset($subcategoria) &&
              !empty($subcategoria) &&
              !empty($titulo) &&
              !empty($marca) &&
              !empty($categoria) &&
              !empty($precio) &&
              !empty($gastoenvio) &&
              !empty($descripcion)
            );
              if ($_FILES['imagen']) {
                try {
                    $path = uploadImage($_FILES['imagen']);
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    return require VIEWS.'error/500.php';
                }
              } else {
                $path = false;
              }

              if ($isValidProduct) {
                try {
                  if ($idProduct = $this->product->save(array(
                      'titulo'       => $titulo,
                      'marca'        => $marca,
                      'precio'       => $precio,
                      'gatosdeenvio' => $gastoenvio,
                      'descripcion'  => $descripcion,
                  ))) {
                    try {
                      foreach ($categoria as $cat) {
                        // Controlamos cuando creamos un Producto
                        // en el que no hay una relacion entre categoria y
                        // subcategoria
                        try {
                          $this->category->saveWithSubcategory(array(
                            'idcategoria' => $cat,
                            'idsubcategoria' => $subcategoria,
                          ));
                        } catch (Exception $e) {
                        }
                        $this->product->saveWithCategoryAndSubCat(array(
                          'idproducto' => $idProduct,
                          'idcategoria' => $cat,
                          'idsubcategoria' => $subcategoria
                        ));
                      }
                      // subimos la imagen si existe
                      if ($path) {
                        $this->product->saveWithImage(array(
                          'idproducto' => $idProduct,
                          'path' => $path,
                        ));
                      }
                      return header('location: /');
                    } catch (Exception $e) {
                        $error = $e->getMessage();
                        return require VIEWS.'error/500.php';
                    }
                }
              } catch (Exception $e) {
                $error = $e->getMessage();
                return require VIEWS.'error/500.php';
              }
            }
          }
          $client = $this->admin->toArray(self::getSession('username'));
          if ($client['rol'] == 'admin' || $client['rol'] == 'administrador') {
            $categorias = $this->category->toArray();
            $subcategorias = $this->subcategory->toArray();
            return require VIEWS.'product/create.php';
          }
          return require VIEWS.'error/401.php';
        }
        return require VIEWS.'error/401.php';
      }

      public function addAction()
      {
          if (empty($this->_params[0])) {
            return require VIEWS.'error/404.php';
          }
          self::pushInSession('productos', $this->_params[0]);
          return header('location: /');

      }

      public function showAction()
      {
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
