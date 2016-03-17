<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

class Api extends Controller {
    private $_params;
    private $product;
    private $category;
    private $subcategory;
    private $clients;
    private $isAdmin;
    private $color;
    private $size;
    static  $products;
    static  $lastItem;

    public function __construct($params = array())
    {
      $this->product    = new ProductModel();
      $this->clients    = new ClientModel();
      $this->category   = new CategoryModel();
      $this->subcategory= new SubcategoryModel();
      $this->color      = new ColorModel();
      $this->size       = new SizeModel();
      $this->_params    = $params;
      self::$products   = $this->product->toArray();
      $this->isAdmin    = (self::getSession('admin') == "admin" ||
                          self::getSession('admin') == "administrador");
    }

    public function index($params = array()){
      echo json_encode(
        array(
          "endpoints" =>array(
            "GET  /api/product/[{id}]",
            "GET  /api/product/?q={query}",
            "GET  /api/category/",
            "GET  /api/category/[{category}]/[{group}]",
            "POST /api/orders/",
            "GET  /api/orders/{username}/[{idproducto}]",
            "GET  /api/properties/{producto}/[{idtalla}]",
          )
        )
      );
      return;
    }

    public function productAction($params)
    {
        function absUrl($pro){
                $pro['path'] = URL . 'images/' .$pro['path'];
                return $pro;
        }

        try {

          $id = !empty($this->_params[0]) ? $this->_params[0] : false;
          if(!$id && isset($_REQUEST['q']) && !empty($_REQUEST['q'])){
            $products = $this->product->search($_REQUEST['q']);
            $products = array_map('absUrl', $products);
            echo json_encode($products);
            return;
          }
          $products = $this->product->toArray($id);
          if(!empty($products)){
            if(isset($products['path'])){
                $products['path'] = URL . 'images/' .$products['path'];
            }else if(is_array($products)){
                $products = array_map('absUrl', $products);
            }
            echo json_encode($products);
            return;
          }

          throw new Exception("No hay productos");
        } catch (Exception $e) {
          $error = array(
            'error' => 404,
            'errorMsg' => $e->getMessage(),
          );
          echo json_encode($error);
        }
        return;
    }

    public function propertiesAction($params){
      $propers = $this->product->tallasColoresProducto($params[0], isset($params[1]) ? $params[1] : '');
      echo json_encode($propers);
      return;
    }

    public function categoryAction()
    {
      $idcat = !empty($this->_params[0]) ? $this->_params[0] : false;
      $group = !empty($this->_params[1]) ? $this->_params[1] : false;
      try {
        $products = $this->product->selecWithCategorySubcatAndProduct(
          $idcat,
          false,
          $group
        );
        if (empty($products)) {
          $products = $this->category->toArray(false, true, $group);
          if (empty($products)) {
            $products = array(
              'error' => 400,
              'errorMsg' => 'No hay productos',
            );
          }
          echo json_encode($products);
          return;
        }
        echo json_encode($products);
        return;
      } catch (Exception $e) {
        $error = array(
          'error' => 200,
          'errorMsg' => $e->getMessage(),
        );
        echo json_encode($error);
      }
      return;
    }

    function ordersAction(){
      try {
        $user = !empty($this->_params[0]) ? $this->_params[0] : false;
        $id   = !empty($this->_params[1]) ? $this->_params[1] : false;

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          if(!$user){
            throw new Exception("Inica el nombre e usuario", 1);
          }
          extract($_POST);

          $productos    = isJson($productos) ?
                          json_decode(stripslashes($productos), true) :
                          $productos;
          $estado       = isJson($estado) ?
                          json_decode(stripslashes($estado), true) :
                          $estado;
          $hash_compra  = md5(uniqid(time()));
          $isValidOrder = (
            isset($productos) &&
            !empty($productos) &&
            !empty($estado) &&
            isset($estado)
          );

          foreach ($productos as $producto) {
            $check = $this->product->productoTallaColor(
              $producto['idproducto'],
              $producto['talla'],
              $producto['color']
            );
            if(empty($check)){
              throw new Exception("No existe la relacion del producto
              {$producto['idproducto']}
               con a talla {$producto['talla']} y color {$producto['color']}", 1);
            }
          }

          if($isValidOrder){
            $idorder = $this->clients->save(array(
              "hash_compra" => $hash_compra,
              "estado"      => $estado,
              "username"    => $user
            ), "compras");

            foreach ($productos as $producto) {
              $isValidColor = $this->color->toArray($producto['color']);
              $isValidSize  = $this->size->toArray($producto['talla']);
              if(empty($isValidColor)){
                try {
                  $this->color->save(array(
                    "idcolor" => $producto['color']
                  ));
                } catch (Exception $e) {
                  throw new Exception("El color no es válido", 1);
                }
              }
              if(empty($isValidSize)){
                try {
                  $this->size->toArray(array(
                    "idtalla" => $producto['talla']
                  ));
                } catch (Exception $e) {
                  throw new Exception("La talla no es válida", 1);
                }
              }
              try {
                $this->clients->save(array(
                  "idcompra"   => $idorder,
                  "idproducto" => $producto['idproducto'],
                  "cantidad"   => $producto['q'],
                  "username"   => $user,
                  "idtalla"    => $producto['talla'],
                  "idcolor"    => $producto['color']
                ), "compras_productos_tallas_colores");
              } catch (Exception $e) {
                echo $e->getMessage();
                return;
              }

            }

            $res = array(
              'code' => 200,
              'Msg' => "OK",
              'order' => $idorder
            );
            echo json_encode($res);
            return;
          }

          throw new Exception("Parametros POSTS incorrectos", 1);
        }

        $pedidos = $this->clients->getOrders($user, $id);
        echo json_encode($pedidos);
      } catch (Exception $e) {
        $error = array(
          'error' => 400,
          'errorMsg' => $e->getMessage(),
        );
        echo json_encode($error);
      }
      return;
    }
}

?>
