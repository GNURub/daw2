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

      public function jsonAction()
      {
          try {
            $id = !empty($this->_params[0]) ? $this->_params[0] : false;
            $proucts = $this->product->toArray($id);
            echo json_encode($proucts);
          } catch (Exception $e) {
            $error = array(
              'error' => 200,
              'errorMsg' => $e->getMessage(),
            );
            echo json_encode($error);
          }
          return;
      }

      public function soapAction(){
        $server = new soap_server();
        $server->configureWSDL('GetArr','urn:GetArr');
        $server->wsdl->schemaTargetNamespaces = 'urn:GetArr';
        $server->wsdl->addComplexType(
        'ArrayReq',
        'complexType',
        'struct',
        'all',
        '',
        array(
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'code' => array('name' => 'code', 'type' => 'xsd:string'),
        'price' => array('name' => 'price', 'type' => 'xsd:integer'),
        'quantity' => array('name' => 'quantity', 'type' => 'xsd:integer')
        ));

        //function that get and return values
        function GetTotalPrice ($proArray) {
        $temparray = array();

          array_push($temparray, array('name' => $proArray['name'], 'code' => $proArray['code'], 'price' => $proArray['price'], 'quantity'
          => $proArray['quantity'], 'total_price' => $proArray['quantity'] * $proArray['price']));
          array_push($temparray, array('name' => $proArray['name'], 'code' => $proArray['code'], 'price' => $proArray['price'], 'quantity'
          => $proArray['quantity'], 'total_price' => $proArray['quantity'] * $proArray['price']));
          return $temparray;
        };

        //register the method
        $server->register('GetTotalPrice',
          array('proArray' => 'tns:ArrayReq'),// and this line also.
          array('result' => 'xsd:Array'),
          'urn:GetArr',
          'urn:GetArr#GetTotalPrice',
          'rpc',
          'encoded',
          'Get the product total price'
        );


        // Get our posted data if the service is being consumed
        // otherwise leave this data blank.
        $POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

        // pass our posted data (or nothing) to the soap service
        $server->service($POST_DATA);
        exit();
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
                      'titulo' => $titulo,
                      'marca' => $marca,
                      'precio' => $precio,
                      'gatosdeenvio' => $gastoenvio,
                      'descripcion' => $descripcion,
                  ))) {
                    try {
                      foreach ($categoria as $cat) {
                        $this->product->saveWithCategory(array(
                          'idproducto' => $idProduct,
                          'idcategoria' => $cat,
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
