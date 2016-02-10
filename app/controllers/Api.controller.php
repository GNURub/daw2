<?php
// /product/[{id}]/
// /category/{cat}
// /subcategory/{sub}
header('Access-Control-Allow-Origin: *');
class Api extends Controller {
    private $_params;
    private $product;
    private $category;
    private $subcategory;
    private $clients;
    static $products;
    private $isAdmin;
    static $lastItem;

    public function __construct($params = array())
    {
      $this->product    = new ProductModel();
      $this->clients    = new ClientModel();
      $this->category   = new CategoryModel();
      $this->subcategory= new SubcategoryModel();
      $this->_params    = $params;
      self::$products   = $this->product->toArray();
      $this->isAdmin    = (self::getSession('admin') == "admin" ||
                          self::getSession('admin') == "administrador");
    }

    public function index($params = array()){
      $this->productAction();
    }

    public function productAction()
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

    public function categoryAction()
    {

      $idcat = !empty($this->_params[0]) ? $this->_params[0] : false;
      if(!$idcat){
        $error = array(
          'error' => 400,
          'errorMsg' => "Debe de indicar una categoría correcta",
        );
        echo json_encode($error);
        return;
      }
      try {
        $products = $this->product->selecWithCategorySubcatAndProduct($idcat);
        if (empty($products)) {
          $products = array(
            'error' => 400,
            'errorMsg' => 'No hay productos',
          );
        }
        echo json_encode($products);
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
      header('Access-Control-Allow-Origin: *');
      try {
        $user = !empty($this->_params[0]) ? $this->_params[0] : false;
        $id = !empty($this->_params[1]) ? $this->_params[1] : false;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          if(!$user){
            throw new Exception("Inica el nombre e usuario", 1);
          }
          print_r($_POST);
          exit;
          extract($_POST);

          $hash_compra = md5(uniqid(time()));
          $isValidOrder = (
            isset($productos) &&
            !empty($productos) &&
            !empty($estado) &&
            isset($estado)
          );
          if($isValidOrder){
            $idorder = $this->client->save(array(
              "hash_compra" => $hash_compra,
              "estado"      => $estado,
              "username"    => $user
            ), "compras");
            foreach ($productos as $producto) {
              $this->client->save(array(
                "idcompra"   => $idorder,
                "idproducto" => $producto['idproducto'],
                "cantidad"   => $producto['q'],
                "username"   => $user
              ), "compras_productos_tallas_colores");
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
